@extends('layouts.auth_layout')
 
@section('title', 'reset forgot password page')
 
@section('content')

@include('partials.popup')

<div class="card mb-3">

    <div class="card-body">

        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Reset Your Password?</h5>
            <p class="text-center small">email user</p>
        </div>

        <form onsubmit="confirmAndSubmit(this)" action="{{route('password.update')}}" method="post" class="row g-3 needs-validation" novalidate>

            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="col-12">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror " id="email" value="{{ old('email') }}" required>
                    <div class="invalid-feedback">Please enter your email.</div>
                    @error('email')
                        <span class=" invalid-feedback mt-2">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <label for="password" class="form-label">New Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror " value="{{ old('password') }}" id="password" required>
                <div class="invalid-feedback">Please enter your New password!</div>
                @error('password')
                    <span class=" invalid-feedback mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-12">
                <label for="password_confirmation" class="form-label">Comfirm Password</label>
                <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror " value="{{ old('password_confirmation') }}" id="password_confirmation" required>
                <div class="invalid-feedback">Please enter your Comfirm password !</div>
                @error('password_confirmation')
                    <span class=" invalid-feedback mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-6">
                <div class="form-check ">
                    <input class="form-check-input" type="checkbox" id="show_password" onchange="showPassword()" />
                    <label class="form-check-label" for="show_password">Show Password</label>
                </div>
            </div>


            <div class="col-12">
            <button class="btn btn-primary w-100" type="submit">Reset</button>
            </div>
            <div class="col-12">
            <p class="small mb-0"> <a  href="{{route('auth')}}">Return</a></p>
            </div>
        </form>

    </div>
</div>

<script>
    function showPassword() {
    // Get the password input and checkbox elements
    var password = document.getElementById("password");
    var password_comfirm = document.getElementById("password_confirmation");
    var checkbox = document.getElementById("show_password");

    // Check the state of the checkbox
    if (checkbox.checked) {
        // If the checkbox is checked, change the input type to "text"
        password.type = "text";
        password_comfirm.type = "text";
    } else {
        // If the checkbox is not checked, change the input type back to "password"
        password.type = "password";
        password_comfirm.type = "password";
    }
}

</script>

@endsection