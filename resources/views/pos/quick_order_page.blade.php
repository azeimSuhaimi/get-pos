@extends('layouts.main_layout')
 
@section('title', 'POS page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <h1>POINT OF SALE</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('pos')}}">POS</a></li>
        <li class="breadcrumb-item active"><a href="">Quick Order Page</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->


  <div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Enter Quick Order
    </div>
    <div class="card-body">
        <form onsubmit="confirmAndSubmit(this)" action="{{route('pos.quick.order')}}" method="post">
            @csrf
            <div class="row mb-3">
                <label for="barcode" class="col-sm-2 col-form-label">Quick Order ID</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('barcode') is-invalid @enderror" value="{{ old('barcode') }}" name="barcode" id="barcode">
                    @error('barcode')
                        <span class=" invalid-feedback mt-2">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">submit</button>
        </form>

    </div>
</div>



@endsection