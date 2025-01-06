@extends('layouts.main_layout')
 
@section('title', 'Account setting page')
 
@section('content')

@include('partials.popup')


<div class="card text-bg-light">
    <div class="card-body">
      <h5 class="card-title">Setting Toyyip Pay</h5>

      <!-- Multi Columns Form -->
      <form class="row g-3" method="POST" onsubmit="confirmAndSubmit(this)" action="{{route('user.account.setting.toyyip')}}">

        @csrf
        <div class="col-md-12">
          <label for="toyyip_key" class="form-label">toyyip key</label>
          <input type="text" class="form-control @error('toyyip_key') is-invalid @enderror" value="{{  Crypt::decryptString(auth()->user()->toyyip_key) }}" name="toyyip_key" id="toyyip_key">
          @error('toyyip_key')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-12">
            <label for="toyyip_category" class="form-label">toyyip category</label>
            <input type="text" class="form-control @error('toyyip_category') is-invalid @enderror" value="{{ Crypt::decryptString(auth()->user()->toyyip_category) }}" name="toyyip_category" id="toyyip_category">
            @error('toyyip_category')
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


<div class="card text-bg-light">
  <div class="card-body">
    <h5 class="card-title">Setting Company Details</h5>

    <form class="submit pb-3" onsubmit="confirmAndSubmit(this)" action="{{route('user.company.update.image')}}" method="post" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="id" value="{{$company->id}}">
  


      <!-- Profile Edit Form -->
      <div class="row mb-3">
        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Company Logo</label>
        <div class="col-md-8 col-lg-9">
          <img style="width:200px; height: 160px;" id="image-preview" src="/logo/{{$company->logo}} " alt="Profile">
          
        </div>
      </div>
  
      <div class="row mb-3">
          <label for="file-input" class="col-md-4 col-lg-3 col-form-label @error('file') is-invalid @enderror">Select Files Here</label>
          <div class="col-md-8 col-lg-9">
  
            <input  class="form-control" name="file" id="file-input" type="file" placeholder="" />
          </div>
          
      </div>
          @error('file')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
  
          <div class="text-center">
              <button type="submit" class="btn btn-primary">Edit Image</button>
              <button form="remove_image" type="submit"  class="btn btn-danger">Remove Image</button>
          </div>
  
    </form>
  
    <form id="remove_image" onsubmit="confirmAndSubmit(this)" action="{{route('user.company.remove.image')}}" method="post" >
        @csrf
        <input type="hidden" name="id" value="{{$company->id}}">
    </form>
  
  
    <form onsubmit="confirmAndSubmit(this)" action="{{route('user.company.update.detail')}}" method="post">
  
      @csrf
      <input type="hidden" name="id" value="{{$company->id}}">

      <div class="row mb-3">
        <label for="company_name" class="col-md-4 col-lg-3 col-form-label">Company Name</label>
        <div class="col-md-8 col-lg-9">
          <input name="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" value="{{ $company->company_name }}">
          @error('company_name')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label for="shop_name" class="col-md-4 col-lg-3 col-form-label">Shop Name</label>
        <div class="col-md-8 col-lg-9">
          <input name="shop_name" type="text" class="form-control @error('shop_name') is-invalid @enderror" id="shop_name" value="{{ $company->shop_name }}">
          @error('shop_name')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label for="company_id" class="col-md-4 col-lg-3 col-form-label">Company ID</label>
        <div class="col-md-8 col-lg-9">
          <input name="company_id" type="text" class="form-control @error('company_id') is-invalid @enderror" id="company_id" value="{{ $company->company_id }}">
          @error('company_id')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label for="address" class="col-md-4 col-lg-3 col-form-label">Address</label>
        <div class="col-md-8 col-lg-9">
          <input name="address" type="text" class="form-control @error('address') is-invalid @enderror" id="address" value="{{ $company->address }}">
          @error('address')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label for="poscode" class="col-md-4 col-lg-3 col-form-label">Poscode</label>
        <div class="col-md-8 col-lg-9">
          <input name="poscode" type="text" class="form-control @error('poscode') is-invalid @enderror" id="poscode" value="{{ $company->poscode }}">
          @error('poscode')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label for="city" class="col-md-4 col-lg-3 col-form-label">City</label>
        <div class="col-md-8 col-lg-9">
          <input name="city" type="text" class="form-control @error('city') is-invalid @enderror" id="city" value="{{ $company->city }}">
          @error('city')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label for="state" class="col-md-4 col-lg-3 col-form-label">State</label>
        <div class="col-md-8 col-lg-9">
          <input name="state" type="text" class="form-control @error('state') is-invalid @enderror" id="state" value="{{ $company->state }}">
          @error('state')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label for="country" class="col-md-4 col-lg-3 col-form-label">Country</label>
        <div class="col-md-8 col-lg-9">
          <input name="country" type="text" class="form-control @error('country') is-invalid @enderror" id="country" value="{{ $company->country }}">
          @error('country')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label for="phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
        <div class="col-md-8 col-lg-9">
          <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" value="{{ $company->phone }}">
          @error('phone')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label for="description" class="col-md-4 col-lg-3 col-form-label">Description</label>
        <div class="col-md-8 col-lg-9">
          <input name="description" type="text" class="form-control @error('description') is-invalid @enderror" id="description" value="{{ $company->description }}">
          @error('description')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>
      </div>
  
  
  

  
  
      <div class="text-center">
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </div>
    </form><!-- End Profile Edit Form -->


  </div>
</div>


<script>
  const fileInput = document.getElementById('file-input');
  const imagePreview = document.getElementById('image-preview');
  
  fileInput.addEventListener('change', function () {
    const file = fileInput.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function () {
        imagePreview.src = reader.result;
        //imagePreview.style.display = 'block';
      };
      reader.readAsDataURL(file);
    } else {
      //imagePreview.style.display = 'none';
    }
  });
  
  
  
</script>


@endsection