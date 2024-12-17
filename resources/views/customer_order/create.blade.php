@extends('layouts.main_layout')
 
@section('title', 'create Customer Order page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item "><a href="{{route('customer_order')}}">customer order</a></li>
      <li class="breadcrumb-item active"><a href="{{route('customer_order.create')}}">customer order</a></li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<div class="card text-bg-light">
    <div class="card-body">

      <div class="pt-4 pb-2">
          <h5 class="card-title text-center pb-0 fs-4">Create New customer order</h5>
          <p class="text-center small">Register customer order Here</p>
      </div>

      <a href="{{route('customer_order')}}" class="btn btn-primary mb-4">BACK</a>


      <!-- Multi Columns Form -->
      <form class="row g-3" method="POST" onsubmit="confirmAndSubmit(this)" action="{{route('customer_order.store')}}">

        @csrf
        <div class="col-md-12">
          <label for="name" class="form-label"> Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{  old('name') }}" name="name" id="name">
          @error('name')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-6">
          <label for="email" class="form-label"> Email <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('email') is-invalid @enderror" value="{{  old('email') }}" name="email" id="email">
          @error('email')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-6">
          <label for="phone" class="form-label"> Phone <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('phone') is-invalid @enderror" value="{{  old('phone') }}" name="phone" id="phone">
          @error('phone')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>


        <div class="col-md-12">
          <label for="item" class="form-label">Item <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('item') is-invalid @enderror" value="{{  old('item') }}" name="item" id="item">
          @error('item')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-12">
          <label for="remark" class="form-label">Remark</label>
          <input type="text" class="form-control @error('remark') is-invalid @enderror" value="{{  old('remark') }}" name="remark" id="remark">
          @error('remark')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
      </form><!-- End Multi Columns Form -->

    </div>
</div>

@endsection