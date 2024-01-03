
<div>
    <div wire:loading  class="loading"></div>
    <div>
        @include('admin.flash-message.flash-message')
        <div class="row">
            <div class="col-md-6">
                <h4 class="fw-bold py-3 mb-4">Payout Request</h4>
            </div>
            <div class="col-md-6">
                @can('payout-new-request')
                    <button wire:click.prevent='payoutRequest' class="btn btn-primary" style="float: right" >New Payout Request</button>
                @endcan
            </div>
        </div>
        <!-- Basic Bootstrap Table -->
        <div class="card mb-2">
            <div class="search_section">
                <div class="row search-form">
                    <div class="col-md-2">
                        <div class="form-group mb-10">
                            <input type="text" class="form-control start-date startdate" placeholder="Start Date" id="start-date" wire:model='start_date'>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-10">
                            <input type="text" class="form-control start-date end-date" placeholder="To Date" id="end-date" wire:moel="end_date">
                        </div>
                    </div>
                    <div class="col-md-2 mb-10">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="References No" wire:model.defer="value">
                        </div>
                    </div>
                    <div class="col-md-2 mb-10">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Agent Id / Parent Id" wire:model.defer='agentId'>
                        </div>
                    </div>
                    <div class="col-md-2 mb-10">
                        <div class="form-group">
                            <select class="form-control" wire:model.defer="status">
                                <option value="">Status</option>
                                @foreach ($statuses as $status)
                                    <option value="{{$status->id}}">{!!$status->name!!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button wire:click.prevent='search' class="btn btn-primary" style="float: right" >Search</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <h5 class="card-header">Payout Request</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>User Details</th>
                            <th>Bank Details</th>
                            <th>Reference Details</th>
                            <th>Amount	</th>
                            <th>Remark</th>
                            {{-- @can('approved-fund-request') --}}
                                <th>Action</th>
                            {{-- @endcan --}}
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($payoutRequestData as $key =>$payoutReq)
                            <tr>
                                <td><i class="fab fa-vuejs fa-lg text-success me-3"></i><strong>{{$loop->iteration}}</strong></td>
                                <td> {{ucfirst($payoutReq->user->name)}}<br> {{$payoutReq->user->apiPartner->mobile_no}}</td>
                                <td>Account No. -{{ucfirst($payoutReq->account_number)}}<br>Account Holder Name - {{$payoutReq->account_holder_name}}<br>Ifsc Code - {{strtoupper($payoutReq->ifsc_code)}}</td>
                                <td>Transaction Id:-{{$payoutReq->payout_ref}} <br> Payout Id:-{{$payoutReq->payout_id}}</td>
                                <td>{{$payoutReq->amount}}</td>
                                <td>{{$payoutReq->remarks}}</td>
                                <td>{!!$payoutReq->status->name!!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <!-- Modal -->
            <div class="modal fade" id="form" tabindex="-1" aria-hidden="true" role="dialog" wire:ignore.self>
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <form wire:submit.prevent="storePayoutNewRequest" autocomplete="off">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="formTitle">Payout New  Request</h5>
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
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close </button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @include('admin.delete-confirmation.delete-confirmation')
    </div>
</div>
