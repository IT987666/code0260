@extends('layouts.app')

<style>


.btn-primary {
    background-color: #109faf;
    color: white;
    border: none;
    font-size: 16px;
    padding: 10px 20px;
    border-radius: 5px;
}

.btn-primary:hover {
    background-color: #168f9c;
    transform: scale(1.05);
}
</style>

@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="login-register container">
        
        <ul class="nav nav-tabs mb-5" id="login_register" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link nav-link_underscore active" id="login-tab" data-bs-toggle="tab" href="#tab-item-login"
                   role="tab" aria-controls="tab-item-login" aria-selected="true">Login</a>
            </li>
        </ul>
        <div class="tab-content pt-2" id="login_register_tab_content">
            <div class="tab-pane fade show active" id="tab-item-login" role="tabpanel" aria-labelledby="login-tab">
                <div class="login-form">
                    <form method="POST" action="{{ route('login') }}" name="login-form" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control form-control_gray @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label for="email">Email address *</label>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="pb-3"></div>

                        <div class="form-floating mb-3">
                            <input id="password" type="password" class="form-control form-control_gray @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password">
                            <label for="password">Password *</label>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        <button class="btn btn-primary w-100 text-uppercase" type="submit" style="background-color: #109faf; color: white; border: none; font-size: 16px; padding: 10px 20px; border-radius: 5px;">
                            Log In
                        </button>
                        
                        <div class="customer-option mt-4 text-center">
                            <span class="text-secondary">No account yet?</span>
                            <a href="{{ route('register') }}" class="btn-text js-show-register">Create Account</a> |
                            <a href="{{ route('password.request') }}" class="btn-text js-show-register">Forgot Password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
{{--@extends('layouts.app')

@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="login-register container">
        <ul class="nav nav-tabs mb-5" id="login_register" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link nav-link_underscore active" id="login-tab" data-bs-toggle="tab" href="#tab-item-login"
                   role="tab" aria-controls="tab-item-login" aria-selected="true">Login</a>
            </li>
        </ul>
        <div class="tab-content pt-2" id="login_register_tab_content">
            <div class="tab-pane fade show active" id="tab-item-login" role="tabpanel" aria-labelledby="login-tab">
                <div class="login-form">
                    <form method="POST" action="{{ route('login') }}" name="login-form" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control form-control_gray @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label for="email">Email address *</label>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="pb-3"></div>

                        <div class="form-floating mb-3">
                            <input id="password" type="password" class="form-control form-control_gray @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password">
                            <label for="password">Password *</label>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        <button class="btn btn-primary w-100 text-uppercase" type="submit">Log In</button>

                        <div class="customer-option mt-4 text-center">
                            <span class="text-secondary">No account yet?</span>
                            <a href="{{ route('register') }}" class="btn-text js-show-register">Create Account</a> |
                            <a href="{{ route('password.request') }}" class="btn-text js-show-register">Forgot Password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
--}}