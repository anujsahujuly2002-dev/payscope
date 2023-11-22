<div>
    <div wire:loading  class="loading"></div>
    <div>
        @include('admin.flash-message.flash-message')
        <div class="row">
            <div class="col-md-6">
                <h4 class="fw-bold py-3 mb-4">Manage Api Partner</h4>
            </div>
            <div class="col-md-6">
                @can('api-partner-create')
                <button wire:click.prevent='createApiPartner' class="btn btn-primary" style="float: right" >Create
                    Api Partner</button>
                @endcan
            </div>
        </div>
        <div class="card mb-2">
            <div class="search_section">
                <div class="row search-form">
                    <div class="col-md-2">
                        <div class="form-group mb-10">
                            <input type="text" class="form-control start-date" placeholder="Start Date" id="start-date" wire:model='start_date'>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-10">
                            <input type="text" class="form-control start-date" placeholder="To Date" id="end-date">
                        </div>
                    </div>
                    <div class="col-md-2 mb-10">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search Value" wire:model.defer="value">
                        </div>
                    </div>
                    <div class="col-md-2 mb-10">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Agent Id / Parent Id">
                        </div>
                    </div>
                    <div class="col-md-2 mb-10">
                        <div class="form-group">
                            <select class="form-control">
                                <option value="">Select member Status</option>
                                <option value="">Active</option>
                                <option value="">Block</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button wire:click.prevent='search' class="btn btn-primary" style="float: right" >Search</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">Api Partner List</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>id</th>
                            <th>Name</th>
                            <th>Parent Details</th>
                            <th>Company Profile</th>
                            <th>Wallet Details</th>
                            <th>Created At </th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($apiPartners as $key =>$apipartner)

                            <tr>
                                <td><i class="fab fa-vuejs fa-lg text-success me-3"></i><strong>{{$loop->iteration}}</strong></td>
                                <td>{{$apipartner->id}}</td>
                                <td> {{ucfirst($apipartner->name)}}<br>{{$apipartner->apiPartner->mobile_no}}<br>{{ucfirst($apipartner->getRoleNames()->first())}}</td>
                                <td>{{ucfirst($apipartner->apiPartner->parentDetails->name)}}<br>{{$apipartner->apiPartner->parentDetails->getRoleNames()->first()=='super admin'?'9519035604':$apipartner->apiPartner->mobile_no}}<br>{{ucfirst($apipartner->apiPartner->parentDetails->getRoleNames()->first())}}</td>
                                <td>{{ucfirst($apipartner->apiPartner->shop_name)}}</br>{{$apipartner->apiPartner->website}}</td>
                                <td>{{$apipartner->walletAmount->amount}}</td>
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
                                            {{-- @can('apipartner-edit')
                                                <a class="dropdown-item" href="javascript:void(0);" wire:click.prevent='editapipartner({{$apipartner}})'><i class="bx bx-edit-alt me-2"></i> Edit</a>
                                            @endcan
                                            @can('apipartner-delete')
                                            <a class="dropdown-item" href="javascript:void(0);" wire:click.prevent='deleteConfirmation({{$apipartner->id}})'><i class="bx bx-trash me-2"></i> Delete</a>
                                            @endcan --}}
                                            <div class="loading" wire:loading wire:target='deleteConfirmation'  wire:loading.attr="disabled" ></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <!-- Modal -->
        <div class="modal fade" id="form" tabindex="-1" aria-hidden="true" role="dialog" wire:ignore.self>
            <div class="modal-dialog modal-xl" role="document">
                <form wire:submit.prevent="StoreApiPartner" autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                            {{-- @if ($editapipartnerForm)
                                <h5 class="modal-title" id="formTitle">Edit apipartner</h5>
                            @else --}}
                                <h5 class="modal-title" id="formTitle">Create Api Partner</h5>
                            {{-- @endif --}}
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Personal Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-md-4 mb-0">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" id="name" class="form-control  @error('name') is-invalid @enderror" placeholder="Enter Name" wire:model.defer='state.name'/>
                                            @error('name')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0">
                                            <label for="email" class="form-label">Email Id</label>
                                            <input type="text" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email Id" wire:model.defer='state.email'/>
                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0">
                                            <label for="mobile_number" class="form-label">Mobile Number</label>
                                            <input type="text" id="mobile_number" class="form-control @error('mobile_number') is-invalid @enderror" placeholder="Enter Mobile Number" wire:model.defer='state.mobile_number'/>
                                            @error('mobile_number')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mb-0">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" id="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter Address" wire:model.defer='state.address'/>
                                            @error('address')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0">
                                            <label for="state" class="form-label">State</label>
                                            <select id="state_name" class="form-control @error('state_name') is-invalid @enderror" placeholder="Enter State" wire:model.lazy='state.state_name'>
                                                <option value="">Select State</option>
                                                @foreach ($states as $state)
                                                    <option value="{{$state->id}}">{{ucfirst($state->name)}}</option>
                                                @endforeach
                                            </select>
                                            @error('state_name')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" id="city" class="form-control @error('city') is-invalid @enderror" placeholder="Enter City" wire:model.defer='state.city'/>
                                            @error('city')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0">
                                            <label for="pincode" class="form-label">Pincode</label>
                                            <input type="text" id="pincode" class="form-control @error('pincode') is-invalid @enderror" placeholder="Enter Pincode" wire:model.defer='state.pincode'/>
                                            @error('pincode')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"> Buisness Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-0">
                                            <label for="shop_name" class="form-label">Shop Name</label>
                                            <input type="text" id="shop_name" class="form-control @error('shop_name') is-invalid @enderror" placeholder="Enter Shop Name" wire:model.defer='state.shop_name'/>
                                            @error('shop_name')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0">
                                            <label for="pancard_number" class="form-label">Pancard Number</label>
                                            <input type="text" id="pancard_number" class="form-control @error('pancard_number') is-invalid @enderror" placeholder="Enter Pancard Number" wire:model.defer='state.pancard_number'/>
                                            @error('pancard_number')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0">
                                            <label for="adhaarcard_number" class="form-label">AdhaarCard Number</label>
                                            <input type="text" id="adhaarcard_number" class="form-control @error('adhaarcard_number') is-invalid @enderror" placeholder="Enter Adhaar Card Number" wire:model.defer='state.adhaarcard_number'/>
                                            @error('adhaarcard_number')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0 mt-2">
                                            <label for="scheme" class="form-label">Scheme</label>
                                            <select type="text" id="scheme" class="form-control @error('scheme') is-invalid @enderror" wire:model.defer='state.scheme'>
                                                <option value="">Select Scheme</option>
                                                @foreach ($schemes as $scheme)
                                                    <option value="{{$scheme->id}}">{{$scheme->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('scheme')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0 mt-2">
                                            <label for="website" class="form-label">Website</label>
                                            <input type="text" id="website" class="form-control @error('website') is-invalid @enderror" placeholder="Enter Website" wire:model.defer='state.website'/>
                                            @error('website')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
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
