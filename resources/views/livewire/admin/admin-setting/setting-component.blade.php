<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="d-flex">
                            <div class="text-end">
                                <p>OTP Setting :</p> 
                            </div>
                            <div style="margin-left: 120px;">
                                <label class="switch">
                                    <input type="checkbox" id="switch" switch="bool" wire:change="OtpEnabled('otp verification','{{$otpEnabled->value}}')" @if($otpEnabled->value=="yes") checked @endif />
                                    <label for="switch" data-on-label="Enable" data-off-label="Disable"></label>
                                </label>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-6 ">
                    {{-- <div class="d-flex juistify-content-left">
                        <div>
                            <p>OTP Setting :</p> 
                        </div>
                        <div class="ms-3">
                            <label class="switch">
                                <input type="checkbox" id="switch" switch="bool" wire:change="OtpEnabled('otp-verification',{{$otpEnabled}})" @if($otpEnabled=="true") checked @endif />
                                <label for="switch" data-on-label="Enable" data-off-label="Disable"></label>
                            </label>
                        </div>
                    </div> --}}
                  
                </div>
            </div>
        </div>
    </div>
</div>



{{-- @if ($this->otpEnabled)
    <div>
        <p>OTP is currently enabled. You can show additional content or options here.</p>
    </div>
@else
    <div>
        <p>OTP is currently disabled. You can show alternative content or options here.</p>
    </div>
@endif --}}
