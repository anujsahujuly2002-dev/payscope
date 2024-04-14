<div>
    <div wire:loading  class="loading"></div>
    @include('admin.flash-message.flash-message')
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3 d-flex justify-content-end">
                @can('payout-new-request')
                    <a href="javascript:void(0);" class="btn btn-success waves-effect waves-light align-self-end" wire:click.prevent='payoutRequest'><i class="mdi mdi-plus me-2"></i>Add New</a>
                @endcan
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
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
                                    @foreach ($statuses as $status)
                                        <option value="{{$status->id}}">{!!$status->name!!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3 d-flex">
                                        <a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light align-self-center" wire:click.prevent=''><i class="fas fa-file-excel me-2"></i>Export</a>
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
                                    <th scope="col">Bank Details</th>
                                    <th scope="col">Reference Details</th>
                                    <th scope="col">Opening balance</th>
                                    <th scope="col">Order amount</th>
                                    <th scope="col">Debit charges</th>
                                    <th scope="col">Closing balance</th>
                                    <th scope="col">Remark</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Status</th>
                                    {{-- @canany(['permission-edit', 'permission-delete'])
                                        <th scope="col" style="width: 200px;">Action</th>
                                    @endcanany --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payoutRequestData as $key =>$payoutReq)
                                    @php
                                        $currentPage = $payoutRequestData->currentPage() !=1?$payoutRequestData->perPage():1;
                                        $srNo  =($payoutRequestData->currentPage()-1)*$currentPage;
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                {{-- <input type="checkbox" class="form-check-input" id="contacusercheck1"> --}}
                                                <label class="form-check-label" for="contacusercheck1">{{$srNo+$loop->iteration}}</label>
                                            </div>
                                        </th>
                                        <td>
                                            <a href="javascript:void(0)" class="text-body">{{$payoutReq->id}}</a>
                                        </td>
                                        <td>
                                            {{ucfirst($payoutReq->user->name)}}<br> {{$payoutReq?->user?->mobile_no}}</td>
                                        <td>
                                            Account No. -{{ucfirst($payoutReq->account_number)}}<br>Account Holder Name - {{$payoutReq->account_holder_name}}<br>Ifsc Code - {{strtoupper($payoutReq->ifsc_code)}}                                        </td>
                                        <td>
                                            Transaction Id:-{{$payoutReq->payout_ref}} <br> Payout Id:-{{$payoutReq->payout_id}}
                                        </td>
                                        <td class="fw-bolder">
                                            &#x20B9;{{moneyFormatIndia($payoutReq?->payoutTransactionHistories?->balance)}}</td>
                                        <td class="fw-bolder">
                                            <span class="text-danger fw-bolder">&#8722;</span> &#x20B9;{{moneyFormatIndia($payoutReq->amount)}}
                                        </td>
                                        <td class="fw-bolder">
                                            <span class="text-danger fw-bolder">&#8722;</span>&#x20B9;{{moneyFormatIndia($payoutReq?->payoutTransactionHistories?->charge)}}
                                        </td>
                                        <td class="fw-bolder"> &#x20B9;{{moneyFormatIndia($payoutReq?->payoutTransactionHistories?->closing_balnce)}}
                                        </td>
                                        <td>
                                            {{$payoutReq?->payoutTransactionHistories?->remarks}}
                                        </td>
                                        <td>
                                            {{$payoutReq->created_at}}
                                        </td>
                                        <td>{!!$payoutReq->status->name!!}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <div>
                                <p class="mb-sm-0">Showing 1 to 10 of {{$payoutRequestData->total()}} entries</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            @if ($payoutRequestData->hasPages())
                                <div class="float-sm-end">
                                    <ul class="pagination mb-sm-0">
                                        @if ($payoutRequestData->onFirstPage())
                                            <li class="page-item disabled">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item" wire:click="previousPage">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @endif
                                        @if ($payoutRequestData->currentPage()>3)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">1</a>
                                            </li>
                                        @endif
                                        @if ($payoutRequestData->currentPage()>4)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @foreach (range(1, $payoutRequestData->lastPage()) as $i)
                                            @if ($i >=$payoutRequestData->currentPage()-2 && $i <=$payoutRequestData->currentPage())
                                                <li class="page-item @if($payoutRequestData->currentPage() ==$i) active @endif"  wire:click="gotoPage({{ $i }})">
                                                    <a href="javascript:void(0)" class="page-link">{{$i}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                        @if ($payoutRequestData->currentPage() < $payoutRequestData->lastPage() - 3)
                                            <li class="page-item">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @if($payoutRequestData->currentPage() < $payoutRequestData->lastPage() - 2)
                                            <li class="page-item"  wire:click="gotoPage({{ $payoutRequestData->lastPage()}})">
                                                <a href="javascript:void(0)" class="page-link">{{ $payoutRequestData->lastPage()}}</a>
                                            </li>
                                        @endif
                                        @if($payoutRequestData->hasMorePages())
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
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
        <!--  Large modal example -->
        <div class="modal fade bs-example-modal-lg" id="form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-lg">
                <form wire:submit.prevent="storePayoutNewRequest" autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">Payout New  Request</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-2">
                                <div class="col-md-4 mb-0">
                                    <label for="account_number" class="form-label">Account Number</label>
                                    <input type="text" id="account_number" class="form-control @error('account_number') is-invalid @enderror" placeholder="Enter Account Number" wire:model.defer='payoutFormRequest.account_number'/>
                                    @error('account_number')
                                        <div class="invalid-feedback"> {{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-0">
                                    <label for="ifsc-code" class="form-label">Ifsc Code</label>
                                    <input type="text" id="ifsc-code" class="form-control @error('ifsc_code') is-invalid @enderror" placeholder="Enter Ifsc code" wire:model.defer='payoutFormRequest.ifsc_code'/>
                                    @error('ifsc_code')
                                        <div class="invalid-feedback"> {{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-0">
                                    <label for="account-holder-name" class="form-label">Account Holder Name</label>
                                    <input type="text" id="account-holder-name" class="form-control @error('account_holder_name') is-invalid @enderror" placeholder="Enter Account Holder Name" wire:model.defer='payoutFormRequest.account_holder_name'/>
                                    @error('account_holder_name')
                                        <div class="invalid-feedback"> {{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-0">
                                    <label for="account-holder-name" class="form-label">Amount</label>
                                    <input type="text" id="account-holder-name" class="form-control @error('amount') is-invalid @enderror" placeholder="Enter Amount" wire:model.defer='payoutFormRequest.amount'/>
                                    @error('amount')
                                        <div class="invalid-feedback"> {{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-0">
                                    <label for="mobile_number" class="form-label">Payment Mode</label>
                                    <select id="paymnet_mode" class="form-control @error('payment_mode') is-invalid @enderror"  wire:model.defer='payoutFormRequest.payment_mode'>
                                        <option value="">Select Payment Mode</option>
                                        @foreach ($paymentModes as $paymentMode)
                                            <option value="{{$paymentMode->id}}">{{strtoupper($paymentMode->name)}}</option>
                                        @endforeach
                                    </select>
                                    @error('payment_mode')
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
    <!-- end row -->
    @include('admin.delete-confirmation.delete-confirmation')
</div>
