<?php

namespace App\Livewire\Admin\Fund;

use App\Models\Status;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Exports\QRCollectionExport;
use App\Models\QRPaymentCollection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class QRCollectionComponent extends Component
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


    public function render()
    {
        // if (!Auth::user()->can('qr-collection-list')) {
        //     throw UnauthorizedException::forPermissions(['qr-collection-list']);
        // }

        $this->statuses = Status::all();

        $qr_collection = QRPaymentCollection::when(auth()->user()->getRoleNames()->first() == 'api-partner', function($u) {
                $u->where('user_id', auth()->user()->id);
            })
            ->when(auth()->user()->getRoleNames()->first() == 'retailer', function($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->when($this->start_date && $this->end_date, function($query) {
                $query->whereDate('created_at', '>=', $this->start_date)
                      ->whereDate('created_at', '<=', $this->end_date);
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
            return view('livewire.admin.fund.q-r-collection-component', [
            'qr_collection' => $qr_collection
        ]);
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
