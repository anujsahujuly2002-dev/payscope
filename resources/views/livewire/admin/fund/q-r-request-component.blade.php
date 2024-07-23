<div>
    <div wire:loading  class="loading"></div>
    @include('admin.flash-message.flash-message')
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3 d-flex justify-content-end">
                @can('fund-new-request')
                    <a href="javascript:void(0);" class="btn btn-success waves-effect waves-light align-self-end"  wire:click.prevent='walletLoad'><i class="mdi mdi-plus me-2"></i>Wallet Load</a>
                @endcan
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <div class="row mb-2">
                                <div class="col-md-2">
                                    <div class="form-group mb-10">
                                        <input type="text" class="form-control start-date startdate rounded bg-light border-0 start_date" placeholder="Start Date" id="datepicker-basic" wire:model.live='start_date' >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control start-date startdate rounded bg-light border-0 end_date" placeholder="End Date" id="datepicker-basic" wire:model.live='end_date' >
                                </div>
                                <div class="col-md-2 mb-10">
                                    <div class="form-group">
                                        <input type="text" class="form-control  rounded bg-light border-0" placeholder="References No" wire:model.live="value">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-10">
                                    <div class="form-group">
                                        <input type="text" class="form-control  rounded bg-light border-0" placeholder="Agent Id / Parent Id" wire:model.live='agentId'>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-10">
                                    <div class="form-group">
                                        <select class="form-control  rounded bg-light border-0" wire:model.live="status">
                                            <option value="">Status</option>
                                            {{-- @foreach ($statuses as $status)
                                                <option value="{{$status->id}}">{!!$status->name!!}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3 d-flex">
                                                <a href="javascript:void(0);" class="btn  waves-effect waves-light align-self-center" style="background-color:#FE7A36;font-color:white" wire:click.prevent='export'><i class="fas fa-file-excel me-2"></i>Export</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="table-responsive mb-4">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 50px;">
                                        <div class="form-check font-size-16">
                                            {{-- <input type="checkbox" class="form-check-input" id="contacusercheck"> --}}
                                            <label class="form-check-label" for="contacusercheck">Sr No.</label>
                                        </div>
                                    </th>
                                    <th scope="col">id</th>
                                    <th scope="col">User Details</th>
                                    <th scope="col">Deposit Bank Details</th>
                                    <th scope="col">Refrence Details</th>
                                    <th scope="col">Opening balance	</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Closing balance</th>
                                    <th scope="col">Remark</th>
                                    <th scope="col">Status</th>
                                    @canany(['approved-fund-request'])
                                        <th scope="col" style="width: 200px;">Action</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($funds as $key =>$fund)
                                    @php
                                        $currentPage = $funds->currentPage() !=1?$funds->perPage():1;
                                        $srNo  =($funds->currentPage()-1)*$currentPage;
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                <input type="checkbox" class="form-check-input" id="contacusercheck1">
                                                <label class="form-check-label" for="contacusercheck1">{{$srNo+$loop->iteration}}</label>
                                            </div>
                                        </th>
                                        <td>
                                            <a href="javascript:void(0)" class="text-body">{{$fund->id}}</a>
                                        </td>
                                        <td>
                                            Name -  {{ucfirst($fund->user->name)}}<br>Mobile No.- {{$fund->user->mobile_no}}
                                        </td>
                                        <td>
                                            Name -  {{ucfirst($fund->bank->name)}}<br>Account No.- {{$fund->bank->account_number}}<br>Branch - {{$fund->bank->branch_name}}
                                        </td>
                                        <td>
                                            Ref No. -{{ucfirst($fund->references_no)}}<br>Paydate - {{$fund->pay_date}}<br>Paymode - {{strtoupper($fund->paymentMode->name)}}
                                        </td>
                                        <td class="fw-bolder">
                                            &#x20B9;{{moneyFormatIndia($fund->opening_amount)}}
                                        </td>
                                        <td class="fw-bolder">
                                            <span class="text-success fw-bolder"> &#x2B;</span>&#x20B9; {{moneyFormatIndia($fund->amount)}}
                                        </td>
                                        <td class="fw-bolder">
                                            &#x20B9;{{moneyFormatIndia($fund->closing_amount)}}
                                        </td>
                                        <td >
                                            {{$fund->remark}}
                                        </td>
                                        <td>
                                            {!!$fund->status->name!!}
                                        </td>
                                        @canany(['approved-fund-request'])
                                            <td>
                                                @if($fund->status->id !='2')
                                                    <li class="list-inline-item dropdown">
                                                        <a class="text-muted dropdown-toggle font-size-18 px-2" href="#"
                                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                            <i class="uil uil-ellipsis-v"></i>
                                                        </a>

                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            @can('approved-fund-request')
                                                                <a class="dropdown-item" href="javascript:void()"  wire:click.prevent='updateRequest({{$fund}})'>Update Request</a>
                                                            @endcan
                                                        </div>
                                                    </li>
                                                @endif
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach --}}

                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <div>
                                {{-- <p class="mb-sm-0">Showing 1 to 10 of {{$funds->total()}} entries</p> --}}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            {{-- @if ($funds->hasPages())
                                <div class="float-sm-end">
                                    <ul class="pagination mb-sm-0">
                                        @if ($funds->onFirstPage())
                                            <li class="page-item disabled">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item" wire:click="previousPage">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @endif
                                        @if ($funds->currentPage()>3)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">1</a>
                                            </li>
                                        @endif
                                        @if ($funds->currentPage()>4)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @foreach (range(1, $funds->lastPage()) as $i)
                                            @if ($i >=$funds->currentPage()-2 && $i <=$funds->currentPage())
                                                <li class="page-item @if($funds->currentPage() ==$i) active @endif"  wire:click="gotoPage({{ $i }})">
                                                    <a href="javascript:void(0)" class="page-link">{{$i}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                        @if ($funds->currentPage() < $funds->lastPage() - 3)
                                            <li class="page-item">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @if($funds->currentPage() < $funds->lastPage() - 2)
                                            <li class="page-item"  wire:click="gotoPage({{ $funds->lastPage()}})">
                                                <a href="javascript:void(0)" class="page-link">{{ $funds->lastPage()}}</a>
                                            </li>
                                        @endif
                                        @if($funds->hasMorePages())
                                            <li class="page-item" wire:click="nextPage">
                                                <a href="javascript:void(0)" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <a href="javascript:void(0)" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @endif --}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
   
        <!--  Large modal example -->
        <div class="modal fade bs-example-modal-lg" id="form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog ">
                <form wire:submit.prevent="makePayment" autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">Wallet Load Using Qr Request</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-2">
                                <div class="col-md-12 mb-0">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="text" id="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="Enter Amount" wire:model.defer='payment.amount'/>
                                    @error('amount')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Pay Now</button>
                        </div>
                    </div><!-- /.modal-content -->
                </form>
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    {{-- @include('admin.delete-confirmation.delete-confirmation') --}}
    {{-- @if($order) --}}
        @include('admin.razorpay.razorpay');
    {{-- @endif --}}
</div>
