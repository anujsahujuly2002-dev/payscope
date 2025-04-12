<div>
    @include('admin.flash-message.flash-message')
    @if(!$showOtpVerification)
    <div wire:loading class="loading"></div>
@endif




    <!-- OTP Verification Modal -->
    @if($showOtpVerification)
    <div class="modal fade show" id="otpVerificationModal" tabindex="-1" style="display: block; background-color: rgba(0,0,0,0.5);" aria-modal="true" role="dialog" wire:poll.1000ms="decreaseTimer">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">OTP Verification</h5>
                    <button type="button" class="btn-close" wire:click="cancelOtpVerification"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h4>Verify Your Identity</h4>
                        <p>We've sent a 6-digit verification code to your mobile number</p>
                        <h5 class="text-primary">{{ substr($user->mobile_no, 0, 2) . 'XXXX' . substr($user->mobile_no, -4) }}</h5>
                        <div class="timer-container mt-2">
                            <span class="badge bg-info">Time remaining: {{ $this->formattedTimeRemaining }}</span>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="otp" class="form-label">Enter 6-digit OTP</label>
                        <input type="text" class="form-control text-center @if($otpError) is-invalid @endif" placeholder="Enter OTP" maxlength="6" wire:model.defer="otp">
                        @if($otpError)
                            <div class="invalid-feedback">
                                {{ $otpError }}
                            </div>
                        @endif
                    </div>

                    <div class="text-center mb-3">
                        <button type="button"
                        wire:loading.class="btn-loading"
                        wire:click="verifyOtp"
                        class="btn btn-primary"
                        @if($otpTimeRemaining <= 0) disabled @endif>
                    <span class="spinner-border spinner-border-sm me-1"
                          wire:loading
                          wire:target="verifyOtp"></span>
                    <i class="uil uil-check me-1" wire:loading.remove wire:target="verifyOtp"></i>
                    <span wire:loading.remove wire:target="verifyOtp">Verify OTP</span>
                    <span wire:loading wire:target="verifyOtp">Verifying...</span>
                </button>
                    </div>

                    <div class="text-center">
                        <p class="mb-0">Didn't receive code?
                            <a href="javascript:void(0)" wire:click="resendOtp" @if($otpTimeRemaining > 240) disabled @endif>
                                Resend OTP {{ $otpTimeRemaining > 240 ? '(Available in ' . ($otpTimeRemaining - 240) . ' seconds)' : '' }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row mb-4">
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-center">
                        <div class="clearfix"></div>
                        <div>
                            <img src="{{ URL::asset('/assets/images/users/avatar-4.jpg') }}" alt="" class="avatar-lg rounded-circle img-thumbnail">
                        </div>
                        <h5 class="mt-3 mb-2">{{$user?->name}}</h5>
                        <button class="btn btn-sm btn-light rounded-pill">
                            <i class="fas fa-user-shield me-1"></i>
                            {{ ucwords(str_replace('-', ' ', $user->roles->first()->name)) }}
                        </button>

                    </div>

                    <hr class="my-4">

                    <div class="text-muted">
                        <div class="table-responsive mt-4">
                            <div>
                                <p class="mb-1">Name :</p>
                                <h5 class="font-size-16">{{$user?->name}}</h5>
                            </div>
                            <div class="mt-4">
                                <p class="mb-1">Mobile :</p>
                                <h5 class="font-size-16">{{$user?->mobile_no}}</h5>
                            </div>
                            <div class="mt-4">
                                <p class="mb-1">E-mail :</p>
                                <h5 class="font-size-16">{{$user?->email}}</h5>
                            </div>
                            <div class="mt-4">
                                <p class="mb-1">Location :</p>
                                <h5 class="font-size-16">{{$user->getRoleNames()->first()=='api-partner'?$user?->apiPartner?->address:$user?->retailer?->address}},{{$user->getRoleNames()->first()=='api-partner'?ucwords($user?->apiPartner?->state?->name):ucwords($user?->retailer?->state?->name)}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card mb-0">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link @if($tab !='password manager') active @endif" data-bs-toggle="tab" href="#about" role="tab">
                            <i class="uil uil-user-circle font-size-20"></i>
                            <span class="d-none d-sm-block"> Profile Details</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($tab =='password manager') active @endif" data-bs-toggle="tab" href="#messages" role="tab">
                            <i class="uil-cog font-size-20"></i>
                            <span class="d-none d-sm-block">Password Manager</span>
                        </a>
                    </li>
                </ul>
                <!-- Tab content -->
                <div class="tab-content p-4">
                    <div class="tab-pane @if($tab !='password manager') active show @endif" id="about" role="tabpanel">
                       <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Personal Information</h3>

                            </div>
                            <div class="card-body">
                                <form wire:submit.prevent="initiateProfileUpdate" autocomplete="off">
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
                                            <input type="text" id="name" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email" wire:model.defer='state.email' readonly disabled>
                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                            <small class="text-muted">Email cannot be changed</small>
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
                    <div class="tab-pane @if($tab =='password manager') active show @endif" id="messages" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Change Password</h3>

                            </div>
                            <div class="card-body">
                                <form wire:submit.prevent="initiatePasswordChange" autocomplete="off">
                                    <div class="row g-2">
                                        <div class="col-md-6 mb-0">
                                            <label for="old_password" class="form-label">Old Password</label>
                                            <input type="password" id="old_password" class="form-control  @error('old_password') is-invalid @enderror" placeholder="Enter Old Password" wire:model.defer='password.old_password'>
                                            @error('old_password')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-0">
                                            <label for="new_password" class="form-label">New Password</label>
                                            <input type="password" id="new_password" class="form-control  @error('new_password') is-invalid @enderror" placeholder="Enter New Password" wire:model.defer='password.new_password'>
                                            @error('new_password')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-0">
                                            <label for="confirm_password" class="form-label">Confirm Password</label>
                                            <input type="password" id="confirm_password" class="form-control  @error('confirm_password') is-invalid @enderror" placeholder="Enter Confirm Password" wire:model.defer='password.confirm_password'>
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
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
