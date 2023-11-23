
    <div>
        <div wire:loading  class="loading"></div>
        <div>
            @include('admin.flash-message.flash-message')
            <div class="row">
                <div class="col-md-6">
                    <h4 class="fw-bold py-3 mb-4">Wallet Load Request</h4>
                </div>
                <div class="col-md-6">
                    @can('fund-new-request')
                        <button wire:click.prevent='fundNewRequest' class="btn btn-primary" style="float: right" >New Request</button>
                    @endcan
                </div>
            </div>
            <!-- Basic Bootstrap Table -->
            @role('api-partner')
                <div class="row">
                    @if($banks->count()>0)
                        @foreach ($banks as $bank)
                            <div class="col-sm-4">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="text-semibold no-margin-top">{{$bank->name}}</h6>
                                                <ul class="list list-unstyled">
                                                    <li>Ifsc : <span class="text-semibold">{{$bank->ifsc_code}}</span> </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="text-semibold text-right no-margin-top">{{$bank->account_number}}</h6>
                                                <ul class="list list-unstyled text-right">
                                                    <li>Branch : <span class="text-semibold">{{$bank->branch_name}}</span> </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endrole
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
                <h5 class="card-header">Wallet Load Request</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Deposit Bank Details</th>
                                <th>Refrence Details</th>
                                <th>Amount</th>
                                <th>Remark</th>
                                <th>Status</th>
                                @can('approved-fund-request')
                                    <th>Action</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($funds as $key =>$fund)

                                <tr>
                                    <td><i class="fab fa-vuejs fa-lg text-success me-3"></i><strong>{{$loop->iteration}}</strong></td>
                                    <td>Name -  {{ucfirst($fund->bank->name)}}<br>Account No.- {{$fund->bank->account_number}}<br>Branch - {{$fund->bank->branch_name}}</td>
                                    <td>Ref No. -{{ucfirst($fund->references_no)}}<br>Paydate - {{$fund->pay_date}}<br>Paymode - {{strtoupper($fund->paymentMode->name)}}</td>
                                    <td>{{$fund->amount}}</td>
                                    <td>{{$fund->remark}}</td>
                                    <td>{!!$fund->status->name!!}</td>
                                    @canany(['approved-fund-request'])
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @can('approved-fund-request')
                                                        <a class="dropdown-item" href="javascript:void(0);" wire:click.prevent='updateRequest({{$fund}})'><i class="bx bx-edit-alt me-2"></i> Update Request</a>
                                                    @endcan
                                                 {{--    @can('apipartner-delete')
                                                    <a class="dropdown-item" href="javascript:void(0);" wire:click.prevent='deleteConfirmation({{$apipartner->id}})'><i class="bx bx-trash me-2"></i> Delete</a>
                                                    @endcan --}}
                                                    <div class="loading" wire:loading wire:target='deleteConfirmation'  wire:loading.attr="disabled" ></div>
                                                </div>
                                            </div>
                                        </td>
                                    @endcanany
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <!-- Modal -->
            @if(!$approvedForm)
                <div class="modal fade" id="form" tabindex="-1" aria-hidden="true" role="dialog" wire:ignore.self>
                    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                        <form wire:submit.prevent="storeFundNewRequest" autocomplete="off">
                            <div class="modal-content">
                                <div class="modal-header">
                                    {{-- @if ($editapipartnerForm)
                                        <h5 class="modal-title" id="formTitle">Edit apipartner</h5>
                                    @else --}}
                                        <h5 class="modal-title" id="formTitle">Wallet Fund Request</h5>
                                    {{-- @endif --}}
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-2">
                                        <div class="col-md-4 mb-0">
                                            <label for="name" class="form-label">Deposit Bank</label>
                                            <select  id="bank" class="form-control @error('bank') is-invalid @enderror" wire:model.defer='fundNewRequests.bank'>
                                                <option value="">Select Bank</option>
                                                @foreach ($banks as $bank)
                                                    <option value="{{$bank->id}}">{{$bank->name}}({{$bank->account_number}})</option>
                                                @endforeach
                                            </select>
                                            @error('bank')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0">
                                            <label for="email" class="form-label">Amount</label>
                                            <input type="text" id="email" class="form-control @error('amount') is-invalid @enderror" placeholder="Enter Amount" wire:model.defer='fundNewRequests.amount'/>
                                            @error('amount')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0">
                                            <label for="mobile_number" class="form-label">Payment Mode</label>
                                            <select id="paymnet_mode" class="form-control @error('payment_mode') is-invalid @enderror"  wire:model.defer='fundNewRequests.payment_mode'>
                                                <option value="">Select Payment Mode</option>
                                                @foreach ($paymentModes as $paymentMode)
                                                    <option value="{{$paymentMode->id}}">{{ucfirst($paymentMode->name)}}</option>
                                                @endforeach
                                            </select>
                                            @error('payment_mode')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0">
                                            <label for="pay_date" class="form-label">Pay Date</label>
                                            <input type="date" id="pay_date" class="form-control @error('pay_date') is-invalid @enderror" placeholder="Enter Address" wire:model.defer='fundNewRequests.pay_date'/>
                                            @error('pay_date')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0">
                                            <label for="reference_number" class="form-label">Ref No.</label>
                                            <input type="text" id="reference_number" class="form-control @error('reference_number') is-invalid @enderror" placeholder="Enter Refernce No" wire:model.defer='fundNewRequests.reference_number'/>
                                            @error('reference_number')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0">
                                            <label for="pay_slip" class="form-label">Pay Slip (Optional)</label>
                                            <input type="file" id="pay_slip" class="form-control"  wire:model.defer='paySlip'/>
                                        </div>
                                        <div class="col-md-4 mb-0">
                                            <label for="remark" class="form-label">Remark</label>
                                            <textarea type="text" id="remark" class="form-control " placeholder="Enter Remark" wire:model.defer='fundNewRequests.remark'></textarea>
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
            @else
                <div class="modal fade" id="form" tabindex="-1" aria-hidden="true" role="dialog" wire:ignore.self>
                    <div class="modal-dialog" role="document">
                        <form wire:submit.prevent="updateFundRequest" autocomplete="off">
                            <div class="modal-content">
                                <div class="modal-header">
                                    {{-- @if ($editapipartnerForm)
                                        <h5 class="modal-title" id="formTitle">Edit apipartner</h5>
                                    @else --}}
                                        <h5 class="modal-title" id="formTitle">Fund Request Update</h5>
                                    {{-- @endif --}}
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-2">
                                        <div class="col-md-12 mb-0">
                                            <label for="name" class="form-label">Status</label>
                                            <select  id="bank" class="form-control @error('bank') is-invalid @enderror" wire:model.defer='status'>
                                                <option value="">Select Status</option>
                                                @foreach ($statuses as $status)
                                                    <option value="{{$status->id}}">{!!$status->name!!}</option>
                                                @endforeach
                                            </select>
                                            @error('bank')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mb-0">
                                            <label for="remark" class="form-label">Remark</label>
                                            <textarea type="text" id="remark" class="form-control " placeholder="Enter Remark" wire:model.defer='remark'></textarea>
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
            @endif
            @include('admin.delete-confirmation.delete-confirmation')
        </div>
    </div>
