<div>
    <div class="container-fluid height-100">
        <div class="row d-flex justify-content-end align-items-end">
            <div class="col-md-8">
                <div class="textstyle p-5">
                    <h3>Welcome to Groscope!</h3>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Cum
                        sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                </div>
            </div>
            <div class="col-md-4 p-0">
                @include('admin.flash-message.flash-message')
                <form wire:submit.prevent="otpVerify">
                    <div class="card p-5">
                        <h1>Forgot Your Password</h1>
                        <h6>Please enter the one time password to verify your account</h6>
                        <div> <span>A code has been sent to</span> <small>@if ($message = Session::get('mobile_no')) {{ $message }}@endif</small> </div>

                        <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                            <input class="m-2 text-center form-control rounded" type="text" id="first" wire:model="otp.0" autocomplete="off">
                            <input class="m-2 text-center form-control rounded" type="text" id="second"  wire:model="otp.1" autocomplete="off">
                            <input class="m-2 text-center form-control rounded" type="text" id="third" wire:model="otp.2" autocomplete="off">
                            <input class="m-2 text-center form-control rounded" type="text" id="fourth" wire:model="otp.3" autocomplete="off">
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-danger px-4 validate" type="submit">Validate</button>
                            <div wire:loading wire:target="otpVerify" class="loading"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function(event) {
        function OTPInput() {
            const inputs = document.querySelectorAll('#otp > *[id]');
            // console.log(inputs);
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('keydown', function(event) {
                    if (event.key === "Backspace") {
                        console.log(inputs[i]);
                        inputs[i].value = '';
                        @this.set('otp.'+i,"")
                        if (i !== 0) inputs[i - 1].focus();
                    } else {
                        if (i === inputs.length - 1 && inputs[i].value !== '') {
                            return true;
                        } else if (event.keyCode > 47 && event.keyCode < 58) {
                            inputs[i].value = event.key;
                            if (i !== inputs.length - 1) inputs[i + 1].focus();
                            @this.set('otp.'+i, inputs[i].value)
                            event.preventDefault();

                        } else if (event.keyCode > 64 && event.keyCode < 91) {
                            inputs[i].value = String.fromCharCode(event.keyCode);
                            if (i !== inputs.length - 1) inputs[i + 1].focus();
                            @this.set('otp.'+i, inputs[i].value)
                            event.preventDefault();
                        }
                    }
                });
            }
        }
        OTPInput();
    });
</script>
</div>
