<div>
    @include('admin.flash-message.flash-message')
    <div class="text-center mt-2">
        <h5 class="text-primary">Welcome Back !</h5>
        <p class="text-muted">Sign in to continue to {{env('APP_NAME')}}.</p>
    </div>
    <div class="p-2 mt-4">
        <form wire:submit.prevent="doLogin">
            <div class="mb-3">
                <label class="form-label" for="username">Email</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror"  wire:model="username" value="{{ old('username') }}" id="username" placeholder="Enter Email address">
                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <div class="float-end">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-muted">Forgot
                            password?</a>
                    @endif
                </div>
                <label class="form-label" for="userpassword">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" wire:model="password" value="" name="password" id="userpassword" placeholder="Enter password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="auth-remember-check"
                    name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="auth-remember-check">Remember me</label>
            </div>
            <div class="mt-3 text-end">
                <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">Log In</button>
                <div wire:loading wire:target="doLogin" class="loading"></div>
            </div>
            {{-- <div class="mt-4 text-center">
                <div class="signin-other-title">
                    <h5 class="font-size-14 mb-3 title">Sign in with</h5>
                </div>
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="javascript:void()"
                            class="social-list-item bg-primary text-white border-primary">
                            <i class="mdi mdi-facebook"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="javascript:void()"
                            class="social-list-item bg-info text-white border-info">
                            <i class="mdi mdi-twitter"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="javascript:void()"
                            class="social-list-item bg-danger text-white border-danger">
                            <i class="mdi mdi-google"></i>
                        </a>
                    </li>
                </ul>
            </div> --}}
            {{-- <div class="mt-4 text-center">
                <p class="mb-0">Don't have an account ? <a href="{{ url('register') }}"
                        class="fw-medium text-primary"> Signup now </a> </p>
            </div> --}}
        </form>
    </div>
</div>