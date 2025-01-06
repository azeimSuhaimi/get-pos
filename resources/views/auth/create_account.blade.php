@extends('layouts.auth_layout')
 
@section('title', 'create account page')
 
@section('content')

@include('partials.popup')


<div class="d-flex justify-content-center py-4">
  <a href="{{route('auth')}}" class="logo d-flex align-items-center w-auto">
      <img src="assets/img/logo.png" alt="">
      <span class="d-none d-lg-block">Point Of Sale</span>
  </a>
</div><!-- End Logo -->


<div class="card">
    <div class="card-body">
      <h5 class="card-title">Create New Account</h5>

      <!-- Multi Columns Form -->
      <form class="row g-3" method="POST" onsubmit="confirmAndSubmit(this)" action="{{route('auth.create_account.create')}}">

        @csrf
        <div class="col-md-12">
          <label for="name" class="form-label"> Name</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{  old('name') }}" name="name" id="name">
          @error('name')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-12">
          <label for="email" class="form-label"> Email</label>
          <input type="text" class="form-control @error('email') is-invalid @enderror" value="{{  old('email') }}" name="email" id="email">
          @error('email')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-12">
          <label for="phone" class="form-label"> Phone</label>
          <input type="text" class="form-control @error('phone') is-invalid @enderror" value="{{  old('phone') }}" name="phone" id="phone">
          @error('phone')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-12">
          <label for="ic" class="form-label"> I.C</label>
          <input type="text" class="form-control @error('ic') is-invalid @enderror" value="{{  old('ic') }}" name="ic" id="ic">
          @error('ic')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
      </form><!-- End Multi Columns Form -->
      <p class="small mb-0"> <a  href="{{route('auth')}}">Already have Account</a></p>
    </div>
</div>

@endsection