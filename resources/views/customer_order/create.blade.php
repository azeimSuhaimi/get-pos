@extends('layouts.main_layout')
 
@section('title', 'create Customer Order page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
  <h1>create customer order</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item "><a href="{{route('customer_order')}}">customer order</a></li>
      <li class="breadcrumb-item active"><a href="{{route('customer_order.create')}}">customer order</a></li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<div class="card">
    <div class="card-body">
      <h5 class="card-title">Create New customer order</h5>

      <!-- Multi Columns Form -->
      <form class="row g-3" method="POST" onsubmit="confirmAndSubmit(this)" action="{{route('customer_order.store')}}">

        @csrf
        <div class="col-md-12">
          <label for="name" class="form-label"> Name</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{  old('name') }}" name="name" id="name">
          @error('name')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-6">
          <label for="email" class="form-label"> Email</label>
          <input type="text" class="form-control @error('email') is-invalid @enderror" value="{{  old('email') }}" name="email" id="email">
          @error('email')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-6">
          <label for="phone" class="form-label"> Phone</label>
          <input type="text" class="form-control @error('phone') is-invalid @enderror" value="{{  old('phone') }}" name="phone" id="phone">
          @error('phone')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>


        <div class="col-md-12">
          <label for="item" class="form-label">Item</label>
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