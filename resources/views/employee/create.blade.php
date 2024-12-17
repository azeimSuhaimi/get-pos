@extends('layouts.main_layout')
 
@section('title', 'create employee page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item active"><a href="{{route('employee.create')}}">Create Employee</a></li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<div class="card text-bg-light">
    <div class="card-body">

      <div class="pt-4 pb-2">
          <h5 class="card-title text-center pb-0 fs-4">Create New Employee</h5>
          <p class="text-center small">Register Member Here</p>
      </div>


      <!-- Multi Columns Form -->
      <form class="row g-3" method="POST" onsubmit="confirmAndSubmit(this)" action="{{route('employee.store')}}">

        @csrf
        <div class="col-md-12">
          <label for="name" class="form-label">Employee Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{  old('name') }}" name="name" id="name">
          @error('name')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-6">
          <label for="email" class="form-label">Employee Email <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('email') is-invalid @enderror" value="{{  old('email') }}" name="email" id="email">
          @error('email')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-6">
          <label for="phone" class="form-label">Employee Phone <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('phone') is-invalid @enderror" value="{{  old('phone') }}" name="phone" id="phone">
          @error('phone')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-6">
          <label for="ic" class="form-label">Employee I.C <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('ic') is-invalid @enderror" value="{{  old('ic') }}" name="ic" id="ic">
          @error('ic')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-6">
          <label for="work_id" class="form-label">Employee Work I.D <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('work_id') is-invalid @enderror" value="{{  old('work_id') }}" name="work_id" id="work_id">
          @error('work_id')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-12">
          <label for="address" class="form-label">Employee Address <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('address') is-invalid @enderror" value="{{  old('address') }}" name="address" id="address">
          @error('address')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-12">
          <label for="address2" class="form-label">Employee Second Address <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('address2') is-invalid @enderror" value="{{  old('address2') }}" name="address2" id="address2">
          @error('address2')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-4">
          <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
          <div class="form-check">
            <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="gender" value="male"  {{old('gender') === 'male' ? 'checked' : ''}}>
            <label class="form-check-label" for="gender">
            Male
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="gender" value="female" {{old('gender') === 'female' ? 'checked' : ''}}>
            <label class="form-check-label" for="gender">
              Female
              </label>
          </div>
          @error('gender')
              <span class=" invalid-feedback mt-2">{{ $message }}</span>
          @enderror
        </div>

        <div class="col-md-4">
          
            <label class="form-label" for="birthday">Birthday <span class="text-danger">*</span></label>
              <input class="form-control @error('birthday') is-invalid @enderror" name="birthday" id="birthday" type="date" value="{{  old('birthday') }}" />
              @error('birthday')
                  <span class=" invalid-feedback mt-2">{{ $message }}</span>
              @enderror
          
        </div>

        <div class="col-md-4">
            <label for="inputState" class="form-label">Position <span class="text-danger">*</span></label>
            <select name="position" class="form-select @error('position') is-invalid @enderror">
                  <option value="" selected>Choose...</option>
                  <option value="cashier" @selected(old('position') == 'cashier')>Cashier</option>
                  <option value="retail" @selected(old('position') == 'retail')>Retail</option>
                  <option value="supervisor" @selected(old('position') == 'supervisor')>supervisor</option>
          </select>
          @error('position')
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