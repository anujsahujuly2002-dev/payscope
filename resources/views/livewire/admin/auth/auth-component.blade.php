<div>
    @include('admin.flash-message.flash-message')
    <div class="app-brand justify-content-center">
        <a href="javascript:void()" class="app-brand-link gap-2">
            <span class="app-brand-logo demo"></span>
            <span class="app-brand-text demo text-body fw-bolder">Payscope</span>
        </a>
    </div>
    <h4 class="mb-2">Welcome to Payscope! 👋</h4>
    <form id="formAuthentication" class="mb-3" wire:submit.prevent="doLogin">
        <div class="mb-3">
            <label for="email" class="form-label">Email or Username</label>
            <input type="text" class="form-control @error('username')is-invalid @enderror" id="email" wire:model="username"placeholder="Enter your email or username" autofocus aria-describedby="emailHelp"/>
            @error('username') 
                <div class="invalid-feedback">
                    {{$message}}
                </div> 
            @enderror
        </div>
        <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Password</label>
                <a href="javascript:void()">
                    <small>Forgot Password?</small>
                </a>
            </div>
            <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control @error('password')is-invalid @enderror" wire:model="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>

            </div>
            @error('password') 
                <div class="invalid-feedback">
                    {{$message}}
                </div> 
            @enderror
        </div>
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-me" />
                <label class="form-check-label" for="remember-me"> Remember Me </label>
            </div>
        </div>
        <div class="mb-3">
            <button class="btn btn-primary d-grid w-100 cursor-pointer"> Sign in</button>
            <div wire:loading wire:target="doLogin" class="loading"></div>
        </div>
    </form>
    <p class="text-center">
        <span>New on our platform?</span>
        <a href="javascript:void()"> <span>Create an account</span></a>
    </p>
</div>