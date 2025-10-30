@extends('layouts.main_layout')
 
@section('title', 'craete waste page')
 
@section('content')

@include('partials.popup')


<div class="pagetitle">
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('waste')}}">All wastes</a></li>
        <li class="breadcrumb-item active"><a href="{{route('waste.create')}}">Create waste</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  



  <div class="card">
      <div class="card-body text-bg-light">
        
        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Create New waste</h5>
            <p class="text-center small">Register waste Here</p>
        </div>

        <a href="{{route('waste')}}" class="btn btn-primary ">BACK</a>



        <!-- Multi Columns Form -->
        <form id="priceForm" class="row g-3" method="POST" onsubmit="confirmAndSubmit(this)" action="{{route('waste.store')}}">
  
          @csrf

  
          <div class="col-md-6">
            <label for="shortcode" class="form-label">waste Shortcode <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('shortcode') is-invalid @enderror" value="{{  old('shortcode') }}" name="shortcode" id="shortcode">
            @error('shortcode')
                <span class=" invalid-feedback mt-2">{{ $message }}</span>
            @enderror
          </div>
  
          <div class="col-md-6">
            <label for="quantity" class="form-label">waste Quantity <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('quantity') is-invalid @enderror" value="{{  old('quantity') }}" name="quantity" id="quantity">
            @error('quantity')
                <span class=" invalid-feedback mt-2">{{ $message }}</span>
            @enderror
          </div>
  

          <div class="col-md-12">
            <label for="reason" class="form-label">waste reason <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('reason') is-invalid @enderror" value="{{  old('reason') }}" name="reason" id="reason">
            @error('reason')
                <span class=" invalid-feedback mt-2">{{ $message }}</span>
            @enderror
          </div>
  
          <div class="col-md-12">
            <label for="remark" class="form-label">waste Remark <span class="text-danger">*</span></label>
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

        <script>
          document.getElementById('priceForm').addEventListener('submit', function(event) {
              // Get the values of cost and price
              let cost = parseFloat(document.getElementById('cost').value);
              let price = parseFloat(document.getElementById('price').value);
              
              // Check if cost is greater than price or price is less than cost
              if (cost > price) {
                Swal.fire({
                  icon: "error",
                  title: "Oops...",
                  text: "Cost cannot be greater than price.",
                });
                  event.preventDefault();  // Prevent form submission
              } else if (price < cost) {
                Swal.fire({
                  icon: "error",
                  title: "Oops...",
                  text: "Price cannot be less than cost.",
                });
                  alert('');
                  event.preventDefault();  // Prevent form submission
              }
          });
      </script>

  
      </div>
  </div>

@endsection