@extends('layouts.main_layout')
 
@section('title', 'craete item page')
 
@section('content')

@include('partials.popup')


<div class="pagetitle">
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('item')}}">All Items</a></li>
        <li class="breadcrumb-item active"><a href="{{route('item.create')}}">Create Item</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  



  <div class="card">
      <div class="card-body text-bg-light">
        
        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Create New Item</h5>
            <p class="text-center small">Register Item Here</p>
        </div>

        <a href="{{route('item')}}" class="btn btn-primary ">BACK</a>



        <!-- Multi Columns Form -->
        <form id="priceForm" class="row g-3" method="POST" onsubmit="confirmAndSubmit(this)" action="{{route('item.store')}}">
  
          @csrf
          <div class="col-md-12">
            <label for="name" class="form-label">Item Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{  old('name') }}" name="name" id="name">
            @error('name')
                <span class=" invalid-feedback mt-2">{{ $message }}</span>
            @enderror
          </div>
  
          <div class="col-md-6">
            <label for="shortcode" class="form-label">Item Shortcode <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('shortcode') is-invalid @enderror" value="{{  old('shortcode') }}" name="shortcode" id="shortcode">
            @error('shortcode')
                <span class=" invalid-feedback mt-2">{{ $message }}</span>
            @enderror
          </div>
  
          <div class="col-md-6">
            <label for="quantity" class="form-label">Item Quantity <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('quantity') is-invalid @enderror" value="{{  old('quantity') }}" name="quantity" id="quantity">
            @error('quantity')
                <span class=" invalid-feedback mt-2">{{ $message }}</span>
            @enderror
          </div>
  
          <div class="col-md-6">
            <label for="cost" class="form-label">Item Cost <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('cost') is-invalid @enderror" value="{{  old('cost') }}" name="cost" id="cost">
            @error('cost')
                <span class=" invalid-feedback mt-2">{{ $message }}</span>
            @enderror
          </div>
  
          <div class="col-md-6">
            <label for="price" class="form-label">Item Price <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('price') is-invalid @enderror" value="{{  old('price') }}" name="price" id="price">
            @error('price')
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
  

  
          <div class="col-md-4">
            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
            <div class="form-check">
              <input class="form-check-input @error('category') is-invalid @enderror" type="radio" name="category" id="category" value="retail"  {{old('category') === 'retail' ? 'checked' : ''}}>
              <label class="form-check-label" for="category">
              Retail
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input @error('category') is-invalid @enderror" type="radio" name="category" id="category" value="nonretail" {{old('category') === 'nonretail' ? 'checked' : ''}}>
              <label class="form-check-label" for="category">
                Non Retail
                </label>
            </div>
            @error('gender')
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