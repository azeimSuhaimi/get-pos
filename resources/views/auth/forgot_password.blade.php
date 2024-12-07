@extends('layouts.auth_layout')
 
@section('title', 'forgot password page')
 
@section('content')

@include('partials.popup')


<div class="card mb-3">

    <div class="card-body">

        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Password Recovery</h5>
            <p class="text-center small">Enter your email address and we will send you a link to reset your password.</p>
        </div>

        <form method="POST" onsubmit="confirmAndSubmit(this)" action="{{route('auth.forgot_password.email')}}" class="row g-3 needs-validation" novalidate>

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
                <button class="btn btn-primary w-100" type="submit">Send Password Reset Link</button>
            </div>

            <div class="col-12">
                <p class="small mb-0"> <a  href="{{route('auth')}}">Back</a></p>
            </div>
        </form>

    </div>
</div>


@endsection



