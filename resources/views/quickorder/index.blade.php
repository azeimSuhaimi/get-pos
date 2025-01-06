@extends('layouts.auth_layout')
 
@section('title', 'select shop page')
 
@section('content')

@include('partials.popup')



<div class="card text-bg-light">
    <div class="card-body">
      <h5 class="card-title">find your shops</h5>

      <!-- Multi Columns Form -->
      <form class="row g-3" method="get" onsubmit="confirmAndSubmit(this)" action="{{route('quick.list')}}">

        @csrf
        <div class="row mb-3">
            <label for="user_email" class="col-md-4 col-lg-3 col-form-label">Shop Name <span class="text-danger">*</span></label>
            <div class="col-md-8 col-lg-9">
                <select name="user_email" id="user_email" class="form-select col-form-control  @error('user_email') is-invalid @enderror">
                    <option selected>Open This Select Menu</option>
                    @foreach($company as $row )
                        <option value="{{$row->user_email}}" @selected(old('user_email') === $row->user_email)>{{$row->shop_name}}</option>
                    @endforeach
                </select>
              
              @error('user_email')
                  <span class=" invalid-feedback mt-2">{{ $message }}</span>
              @enderror
            </div>
          </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
      </form><!-- End Multi Columns Form -->

    </div>
</div>



@endsection