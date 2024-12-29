@extends('layouts.main_layout')
 
@section('title', 'create item redeem page')
 
@section('content')

@include('partials.popup')


<div class="pagetitle">
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('pointredeen')}}">All Items Redeem</a></li>
        <li class="breadcrumb-item active"><a href="{{route('pointredeen.create')}}">Create Item Redeem</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  



  <div class="card">
      <div class="card-body text-bg-light">
        
        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Create New Item Redeem</h5>
            <p class="text-center small">Register Item Here</p>
        </div>

        <a href="{{route('pointredeen')}}" class="btn btn-primary ">BACK</a>



        <!-- Multi Columns Form -->
        <form id="priceForm" class="row g-3" method="POST" onsubmit="confirmAndSubmit(this)" action="{{route('pointredeen.store')}}">
  
          @csrf
          <div class="col-md-12">
            <label for="name" class="form-label">Item Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{  old('name') }}" name="name" id="name">
            @error('name')
                <span class=" invalid-feedback mt-2">{{ $message }}</span>
            @enderror
          </div>
  

  
          <div class="col-md-6">
            <label for="point" class="form-label">Item point <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('point') is-invalid @enderror" value="{{  old('point') }}" name="point" id="point">
            @error('point')
                <span class=" invalid-feedback mt-2">{{ $message }}</span>
            @enderror
          </div>
  

  
          <div class="col-md-12">
            <label for="description" class="form-label">Item Description <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('description') is-invalid @enderror" value="{{  old('description') }}" name="description" id="description">
            @error('description')
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