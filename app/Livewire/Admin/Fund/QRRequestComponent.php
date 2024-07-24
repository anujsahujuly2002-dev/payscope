<?php

namespace App\Livewire\Admin\Fund;

use App\Models\Bank;
use App\Models\Fund;
use Razorpay\Api\Api;
use App\Models\Status;
use App\Models\Wallet;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\QRRequest;
use App\Models\PaymentMode;
use Illuminate\Support\Facades\Validator;
use Razorpay\Api\Errors\SignatureVerificationError;

class QRRequestComponent extends Component
{
    use WithFileUploads,WithPagination;
    public $start_date;
    public $end_date;
    public $status;
    public $banks;
    public $orderId;
    public $qr_requests;
    public $paymentModes;
    public $payment =[];
    public $listeners = [
        'updateRequest' => 'updateRazorpay'
    ];

    public function render()
    {
        $this->qr_requests = QRRequest::with('user', 'status')->get();
        // $this->banks = Bank::where('status','1')->get();
        // $this->paymentModes = PaymentMode::get();
        $statuses = Status::get();
        $qr_requests = QRRequest::when(auth()->user()->getRoleNames()->first()=='api-partner',function($query){
            $query->where('user_id',auth()->user()->id);
        })->when(auth()->user()->getRoleNames()->first()=='retailer',function($query){
            $query->where('user_id',auth()->user()->id);
        })
        ->when($this->start_date !=null && $this->end_date ==null,function($u){
            $u->whereDate('created_at',$this->start_date);
        })
        ->when($this->orderId !=null,function($u){
            $u->where('user_id',$this->orderId);
        })
        ->when($this->start_date !=null && $this->end_date !=null,function($twoBetweenDates){
            $twoBetweenDates->whereDate('created_at','>=',$this->start_date)->whereDate("created_at","<=",$this->end_date);
        })->latest()->paginate(10);
        return view('livewire.admin.fund.q-r-request-component',compact('statuses','qr_requests'));
    }


    public function walletLoad() {
        $this->reset();
        $this->dispatch('show-form');
    }

    public function makePayment() {
        // dd($this->payment);
        $validateData = Validator::make($this->payment,[
            'amount'=>'required|numeric|min:1',
        ])->validate();
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        do {
            $validateData['order_id'] = 'GROSC'.rand(111111111111, 999999999999);
        } while (QRRequest::where("order_id", $validateData['order_id'])->first() instanceof QRRequest);

        $orders = $api->order->create([
            'receipt'         => $validateData['order_id'],
            'amount'          =>($validateData['amount']*100), // Amount in paisa
            'currency'        => 'INR',
            'payment_capture' => 1 // Auto capture payment
        ]);
        QRRequest::create([
            'user_id'=>auth()->user()->id,
            'order_id'=>$orders->id,
            'opening_amount'=>auth()->user()->walletAmount->amount,
            'order_amount'=>$validateData['amount'],
        ]);
        $this->dispatch('razorpay-modal',[
            'amount'=>$orders->amount,
            'order_id'=>$orders->id,
        ]);
        $this->dispatch('hide-form');
    }

    public function updateRazorpay($response) {
        $success = true;
        $error = "Payment Failed!";

        if (empty($response) ===false) {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            try {
                $attributes = [
                    'razorpay_order_id' => $response['razorpay_order_id'],
                    'razorpay_payment_id' => $response['razorpay_payment_id']??"",
                    'razorpay_signature' => $response['razorpay_signature']??"",
                ];
                $api->utility->verifyPaymentSignature($attributes);
            } catch (SignatureVerificationError $e) {
                $success = false;
                $error = 'Razorpay Error : ' . $e->getMessage();
            }
        }

        if ($success === true) {
            $getQRRequest = QRRequest::where('order_id',$response['razorpay_order_id'])->first();
            $getQRRequest->update([
                'status_id'=>'2',
                'closing_amount'=>$getQRRequest->opening_amount+$getQRRequest->order_amount,
                'razorpay_response'=>json_encode($response),
            ]);
            $walletAmount = Wallet::where('user_id',$getQRRequest->user_id)->first()->amount;
            Wallet::where('user_id',$getQRRequest->user_id)->update([
                'amount'=>$getQRRequest->order_amount+$walletAmount
            ]);
            sleep(1);
            session()->flash('success','Wallet load Successfully !');
            return back();
        } else {
            $getQRRequest = QRRequest::where('order_id',$response['razorpay_order_id'])->first();
            $getQRRequest->update([
                'status_id'=>'3',
                'closing_amount'=>$getQRRequest->opening_amount,
                'razorpay_response'=>json_encode($response),
            ]);
            session()->flash('error',$error);
        }

    }
}
