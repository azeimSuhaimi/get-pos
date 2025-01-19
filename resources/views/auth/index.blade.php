@extends('layouts.auth_layout')
 
@section('title', 'Login page')
 
@section('content')

@include('partials.popup')

<div class="d-flex justify-content-center py-4">
    <a href="{{route('auth')}}" class="logo d-flex align-items-center w-auto">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Point Of Sale</span>
    </a>
</div><!-- End Logo -->


<div class="card mb-3">

    <div class="card-body">

        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
            <p class="text-center small">Enter your email & password to login</p>
        </div>

        <form class="row g-3 needs-validation" method="POST" action="{{route('auth.login')}}" novalidate>
            @csrf
            <div class="col-12">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-group has-validation">
                    
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror " id="email" value="{{ old('email') }}" required>
                    <div class="invalid-feedback">Please enter your email.</div>
                    @error('email')
                        <span class=" invalid-feedback mt-2">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror " value="{{ old('password') }}" id="password" required>
                <div class="invalid-feedback">Please enter your password!</div>
                @error('password')
                    <span class=" invalid-feedback mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-6">
                <div class="form-check ">
                    <input class="form-check-input" type="checkbox" id="show_password" onchange="showPassword()" />
                    <label class="form-check-label" for="show_password">Show Password</label>
                </div>
            </div>

            <div class="col-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember_token"  id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>
            </div>
            <div class="col-12">
            <button class="btn btn-primary w-100" type="submit">Login</button>
            </div>
            <div class="col-12">
                <p class="small mb-0"> <a  href="{{route('auth.create_account')}}">Create Account</a></p>
                <p class="small mb-0"> <a  href="{{route('auth.forgot_password')}}">Forgot Password?</a></p>
            </div>
        </form>
        <div class="col-12">
            <p class="small mb-0">login with github <a href="/auth/github/redirect">login</a></p>
        </div>
        <div class="col-12">
            <p class="small mb-0">login with GOOGLE <a href="/auth/google/redirect">login</a></p>
        </div>
    </div>
</div>

<script>
    function showPassword() {
    // Get the password input and checkbox elements
    var password = document.getElementById("password");
    var checkbox = document.getElementById("show_password");

    // Check the state of the checkbox
    if (checkbox.checked) {
        // If the checkbox is checked, change the input type to "text"
        password.type = "text";
    } else {
        // If the checkbox is not checked, change the input type back to "password"
        password.type = "password";
    }
}

</script>

@endsection