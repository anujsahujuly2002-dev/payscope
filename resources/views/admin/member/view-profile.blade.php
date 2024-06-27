@extends('admin.layouts.master')
@section('title')
View Profile
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        {{-- @slot('pagetitle') Profile @endslot --}}
        @slot('title')View Profile @endslot
    @endcomponent
    <div class="row mb-4">
        <div class="col-xl-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-center">
                        <div class="clearfix"></div>
                        <div>
                            <img src="{{ asset('assets/images/.users/profile.jpg') }}" alt="" class="avatar-lg rounded-circle img-thumbnail">
                        </div>
                        <h5 class="mt-3 mb-1">{{$user?->name}}</h5>
                        <p class="text-muted">{{ucwords(str_replace('-',' ',$user->roles->first()->name))}}</p>
                    </div>
                    <hr class="my-4">
                    <div class="text-muted">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Personal Informarion
                                </h4>
                            </div>
                            <div class="card-body">
                                {{-- <div class="table-responsive mt-4"> --}}
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div>
                                                <p class="mb-1">Name :</p>
                                                <h5 class="font-size-16">{{$user?->name}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div>
                                                <p class="mb-1">Mobile Number :</p>
                                                <h5 class="font-size-16">{{$user?->mobile_no}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div>
                                                <p class="mb-1">E-mail Id :</p>
                                                <h5 class="font-size-16">{{$user?->email}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div>
                                                <p class="mb-1">Address :</p>
                                                <h5 class="font-size-16">{{$user->getRoleNames()->first()=='api-partner'?$user?->apiPartner?->address:$user?->retailer?->address}},{{$user->getRoleNames()->first()=='api-partner'?ucwords($user?->apiPartner?->city):ucwords($user?->retailer?->city)}},{{$user->getRoleNames()->first()=='api-partner'?ucwords($user?->apiPartner?->state?->name):ucwords($user?->retailer?->state?->name)}},{{$user->getRoleNames()->first()=='api-partner'?$user?->apiPartner?->pincode:$user?->retailer?->pincode}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Bussiness Informarion
                                </h4>
                            </div>
                            <div class="card-body">
                                {{-- <div class="table-responsive mt-4"> --}}
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div>
                                                <p class="mb-1">Shop Name :</p>
                                                <h5 class="font-size-16">{{$user->getRoleNames()->first()=='api-partner'?ucwords($user?->apiPartner->shop_name):ucwords($user?->retailer?->shop_name)}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div>
                                                <p class="mb-1">Pancard Number :</p>
                                                <h5 class="font-size-16">{{$user->getRoleNames()->first()=='api-partner'?strtoupper($user?->apiPartner->pancard_no):strtoupper($user?->retailer?->pancard_no)}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div>
                                                <p class="mb-1">AdhaarCard Number :</p>
                                                <h5 class="font-size-16">{{$user->getRoleNames()->first()=='api-partner'?strtoupper($user?->apiPartner->addhar_card):strtoupper($user?->retailer?->addhar_card)}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <p class="mb-1">Scheme :</p>
                                                <h5 class="font-size-16">{{$user->getRoleNames()->first()=='api-partner'?$user?->apiPartner?->scheme?->name:$user?->retailer?->scheme->name}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <p class="mb-1">WebSite :</p>
                                                <h5 class="font-size-16">{{$user->getRoleNames()->first()=='api-partner'?$user?->apiPartner?->website:$user?->retailer?->website}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card mb-0">
                <!-- Nav tabs -->
                {{-- <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link @if($tab !='password manager') active @endif" data-bs-toggle="tab" href="#about" role="tab">
                            <i class="uil uil-user-circle font-size-20"></i>
                            <span class="d-none d-sm-block"> Profile Details</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tasks" role="tab">
                            <i class="uil uil-clipboard-notes font-size-20"></i>
                            <span class="d-none d-sm-block">Kyc Details</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($tab =='password manager') active @endif" data-bs-toggle="tab" href="#messages" role="tab">
                            <i class="uil uil-envelope-alt font-size-20"></i>
                            <i class="uil-cog"></i>
                            <i class="uil-cog font-size-20"></i>
                            <span class="d-none d-sm-block">Password Manager</span>
                        </a>
                    </li>
                </ul> --}}
                <!-- Tab content -->
                {{-- <div class="tab-content p-4">
                    <div class="tab-pane @if($tab !='password manager') active show @endif" id="about" role="tabpanel">
                       <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Personal Information</h3>
                            </div>
                            <div class="card-body">
                                <form wire:submit.prevent="updatePersonalInformation" autocomplete="off">
                                    <div class="row g-2">
                                        <div class="col-md-6 mb-0">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" id="name" class="form-control  @error('name') is-invalid @enderror" placeholder="Enter Name" wire:model.defer='state.name'>
                                            @error('name')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-0">
                                            <label for="name" class="form-label">Mobile</label>
                                            <input type="text" id="name" class="form-control  @error('mobile_no') is-invalid @enderror" placeholder="Enter Mobile" wire:model.defer='state.mobile_no'>
                                            @error('mobile_no')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-0">
                                            <label for="name" class="form-label">Email</label>
                                            <input type="text" id="name" class="form-control  @error('email') is-invalid @enderror" placeholder="Enter Email" wire:model.defer='state.email'>
                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-0">
                                            <label for="state" class="form-label">State</label>
                                            <select id="state_name" class="form-control @error('state_name') is-invalid @enderror" placeholder="Enter State" wire:model.defer='state.state_name'>
                                                <option value="">Select State</option>
                                                @foreach ($states as $state)
                                                    <option value="{{$state->id}}">{{ucwords($state->name)}}</option>
                                                @endforeach
                                            </select>
                                            @error('state_name')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-0">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" id="city" class="form-control @error('city') is-invalid @enderror" placeholder="Enter City" wire:model.defer='state.city'>
                                            @error('city')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-0">
                                            <label for="pincode" class="form-label">Pincode</label>
                                            <input type="text" id="pincode" class="form-control @error('pincode') is-invalid @enderror" placeholder="Enter Pincode" wire:model.defer='state.pincode' >
                                            @error('pincode')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mb-0">
                                            <label for="address" class="form-label">Address</label>
                                           <textarea id="address" class="form-control @error('address') is-invalid @enderror" wire:model.defer='state.address'></textarea>
                                            @error('address')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light me-1">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                       </div>
                    </div>
                    <div class="tab-pane" id="tasks" role="tabpanel">
                       <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">KYC Details</h3>
                            </div>
                            <div class="card-body">
                                
                            </div>
                        </div> 
                    </div>
                    <div class="tab-pane @if($tab =='password manager') active show @endif" id="messages" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Change Password</h3>
                            </div>
                            <div class="card-body">
                                <form wire:submit.prevent="changePassword" autocomplete="off">
                                    <div class="row g-2">
                                        <div class="col-md-6 mb-0">
                                            <label for="old_password" class="form-label">Old Password</label>
                                            <input type="text" id="old_password" class="form-control  @error('old_password') is-invalid @enderror" placeholder="Enter Old Password" wire:model.defer='password.old_password'>
                                            @error('old_password')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-0">
                                            <label for="new_password" class="form-label">New Passwprd</label>
                                            <input type="text" id="new_password" class="form-control  @error('new_password') is-invalid @enderror" placeholder="Enter New Password" wire:model.defer='password.new_password'>
                                            @error('new_password')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-0">
                                            <label for="confirm_password" class="form-label">Confirm Password</label>
                                            <input type="text" id="confirm_password" class="form-control  @error('confirm_password') is-invalid @enderror" placeholder="Enter Confirm Password" wire:model.defer='password.confirm_password'>
                                            @error('confirm_password')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light me-1">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection