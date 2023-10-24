
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
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            {{-- @foreach ($apiPartners as $key =>$apipartner)
    
                                <tr>
                                    <td><i class="fab fa-vuejs fa-lg text-success me-3"></i><strong>{{$loop->iteration}}</strong></td>
                                    <td>{{$apipartner->id}}</td>
                                    <td> {{ucfirst($apipartner->name)}}<br>{{$apipartner->apiPartner->mobile_no}}<br>{{ucfirst($apipartner->getRoleNames()->first())}}</td>
                                    <td>{{ucfirst($apipartner->apiPartner->parentDetails->name)}}<br>{{$apipartner->apiPartner->parentDetails->getRoleNames()->first()=='super admin'?'9519035604':$apipartner->apiPartner->mobile_no}}<br>{{ucfirst($apipartner->apiPartner->parentDetails->getRoleNames()->first())}}</td>
                                    <td>{{ucfirst($apipartner->apiPartner->shop_name)}}</br>{{$apipartner->apiPartner->website}}</td>
                                    <td>0.00</td>
                                    <td>{{$apipartner->created_at}}</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" @if($apipartner->status==1) checked @endif wire:change='statusUpdate({{$apipartner->id}},{{$apipartner->status}})' >
                                            <span class="slider round"></span> 
                                        </label>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                @can('apipartner-edit')
                                                    <a class="dropdown-item" href="javascript:void(0);" wire:click.prevent='editapipartner({{$apipartner}})'><i class="bx bx-edit-alt me-2"></i> Edit</a>
                                                @endcan
                                                @can('apipartner-delete')
                                                <a class="dropdown-item" href="javascript:void(0);" wire:click.prevent='deleteConfirmation({{$apipartner->id}})'><i class="bx bx-trash me-2"></i> Delete</a>
                                                @endcan
                                                <div class="loading" wire:loading wire:target='deleteConfirmation'  wire:loading.attr="disabled" ></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
    
            </div>
            <!-- Modal -->
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
                                        <label for="pincode" class="form-label">Remark</label>
                                        <textarea type="text" id="pincode" class="form-control " placeholder="Enter Remark" wire:model.defer='fundNewRequests.remark'></textarea>
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
