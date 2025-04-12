<?php

namespace App\Livewire\Admin\PaymentCollection;

use Livewire\Component;
use App\Models\Status;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Exports\QRCollectionExport;
use App\Models\QRPaymentCollection;
use App\Models\Settelment;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Http\Helper\Payin\PhonePe;
use Carbon\Carbon;

class PaymentCollectionComponent extends Component
{
    use WithFileUploads,WithPagination;
    public $start_date;
    public $end_date;
    public $agentId;
    public $status;
    public $statuses = [];
    public $banks;
    public $value;
    public $paymentModes;
    public $payment =[];

    public $currentBalance = 0;
    public $settelmentDueToday = 0;
    public $previousSettelment = 0;
    public $upcommingSettelment = 0;
    private $phonePe;

    public function __construct()
    {
        $this->phonePe = new PhonePe();
    }

    public function render()
    {
        if (!Auth::user()->can('qr-collection-list')) {
            throw UnauthorizedException::forPermissions(['qr-collection-list']);
        }
        $this->statuses = Status::all();

        $qr_collection = QRPaymentCollection::when(auth()->user()->getRoleNames()->first() == 'api-partner', function($u) {
            $u->where('user_id', auth()->user()->id);
        })
        ->when(auth()->user()->getRoleNames()->first() == 'retailer', function($query) {
            $query->where('user_id', auth()->user()->id);
        })
        ->when($this->start_date && $this->end_date, function($query) {
            $query->whereDate('created_at', '>=', $this->start_date)->whereDate('created_at', '<=', $this->end_date);
        })
        ->when($this->agentId, function($query) {
            $query->where('user_id', $this->agentId);
        })
        ->when($this->start_date && !$this->end_date, function($query) {
            $query->whereDate('created_at', '>=', $this->start_date);
        })
        ->when($this->value, function($query) {
            $query->where('qr_code_id',$this->value);
        })
        ->when($this->value !=null,function($u){
            $u->orWhere('payment_id',$this->value);
        })
        ->when($this->status !== null, function($query) {
            $query->where('status_id', $this->status);
        })
        ->latest()->paginate(100);
        $userId = auth()->user()->id;
        $role = auth()->user()->getRoleNames()->first();
        // Query for currentBalance and settelmentDueToday
        $result = QRPaymentCollection::selectRaw("
            SUM(CASE WHEN is_payment_settel = '0' AND status_id = '2' AND DATE(created_at) = CURDATE() THEN payments_amount_received ELSE 0 END) as current_balance,
            SUM(CASE WHEN is_payment_settel = '0' AND status_id = '2' AND DATE(created_at) <= CURDATE() THEN payments_amount_received ELSE 0 END) as settelment_due_today
        ")
        ->when($role !== 'super-admin', function ($query) use ($userId) {
            $query->where('user_id', $userId); // Filter by user_id for non-super-admin roles
        })
        ->first();

        // Query for previousSettelment
        $previousSettelment = Settelment::when($role !== 'super-admin', function ($query) use ($userId) {
            $query->where('user_id', $userId); // Filter by user_id for non-super-admin roles
        })
        ->latest()
        ->first();

        // Assigning to properties
        $this->currentBalance = $result->current_balance ?? 0;
        $this->settelmentDueToday = $result->settelment_due_today ?? 0;

        // For previousSettelment, fetch amount if record exists
        $this->previousSettelment = $previousSettelment->amount ?? 0;
        return view('livewire.admin.payment-collection.payment-collection-component', ['qr_collection' => $qr_collection]);
    }

    public function initiatePayment() {
        if (!Auth::user()->can('qr-collection-list'))
        throw UnauthorizedException::forPermissions(['qr-collection-add-payment']);
        $this->reset();
        $this->dispatch('show-form');
    }

    public function makePayment() {
        $validateData = Validator::make($this->payment,[
            'amount'=>'required|numeric|min:1',
            'name'=>'required|string|min:3',
            'email'=>'required|email',
            "mobile_no"=>'required|digits:10'
        ])->validate();
        do {
            $validateData['order_id'] = 'GROSC'.rand(111111111111, 999999999999);
        } while (QRPaymentCollection::where("order_id", $validateData['order_id'])->first() instanceof QRPaymentCollection);
        $validateData['user_id'] =auth()->user()->id; 
        $response = $this->phonePe->initiatePayment($validateData);
        if($response['status']):
            QRPaymentCollection::create([
                'user_id'=>auth()->user()->id,
                'qr_code_id'=>$response['data']['orderId'],
                'order_id'=>$validateData['order_id'],
                'name'=>$validateData['name'],
                'email'=>$validateData['email'],
                'mobile_no'=>$validateData['mobile_no'],
                'type'=>'intent',
                'payment_amount'=>$validateData['amount'],
                'qr_status'=>"Pending",
                'fixed_amount'=>'1',
                'qr_close_at'=>Carbon::parse($response['data']['expireAt'])->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s'),
                'qr_created_at'=>now()->format('Y-m-d h:i:s'),
                'status_id'=>"1",
                'payment_type'=>'qr',
                'payment_channel'=>'phone-pe',
                'payments_count_received'=>'1',
            ]);
            return redirect($response['data']['redirectUrl']);
        else:
            $this->reset();
            $this->dispatch('hide-form');
            return redirect()->back()->with('error',$response['message']);
        endif;
        
       

    }

    public function export() {
        $data = [
            'user_id' => auth()->user()->getRoleNames()->first() == 'super-admin' ? $this->agentId : auth()->user()->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'value' => $this->value,
            'status'=> $this->status
        ];
        return Excel::download(new QRCollectionExport($data), time() . '.xlsx');
    }
}
