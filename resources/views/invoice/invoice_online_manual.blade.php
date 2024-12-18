@extends('layouts.main_layout')
 
@section('title', 'digital method page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <h1>POINT OF SALE</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('pos')}}">POS</a></li>
        <li class="breadcrumb-item "><a href="{{route('invoice.list_online_manual')}}">PAYMENT METHOD</a></li>
        <li class="breadcrumb-item active"><a href="{{route('invoice.invoice_online_manual')}}">ONLINE METHOD MENUAL </a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

<div class="card text-bg-light mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Online Method Manual
    </div>
    <div class="card-body">

        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Online Method Manual</h5>
            
        </div>
  
        <a href="{{route('invoice.list_online_manual')}}" class="btn btn-primary mb-4">BACK</a>

        <div class="row d-flex justify-content-center align-items-center">
            <h6 class="card-title text-center text-uppercase font-weight-bold">amount </h6>
            <div class="col-md-5">
                <div class="mb-3">
        
                    <h5 class="card-title text-center text-uppercase font-weight-bold">subtotal : {{$invoice->subtotal}}</h5>
                </div>
    
                <div class="mb-3">
                    <h5 class="card-title text-center text-uppercase font-weight-bold">tax : {{$invoice->tax}}</h5>
                </div>
        
                <div class="mb-3">
                    <h5 class="card-title text-center text-uppercase font-weight-bold">total : {{$invoice->total}}</h5>
                </div>
            </div>
            <div class="col-md-5 ">
                
                <form onsubmit="confirmAndSubmit(this)"  action="{{route('invoice.invoice_online_manual_process')}}" method="post">
                    @csrf
            
                    <input type="hidden" name="invoice_id" value="{{$invoice->invoice_id}}">


                    <input type="hidden" name="id_cust" value="{{ ($request->has('id') ? $request->input('id'):'') }}">
                    
                    <div class="mb-3">
                        <label for="name_cust" class="form-label">Name Customer</label>
                        <input type="text" class="form-control @error('name_cust') is-invalid @enderror" name="name_cust" id="name_cust" value="{{ $invoice->name_cust }}" placeholder="Name Customer" readonly>
                        @error('name_cust')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email_cust" class="form-label">Email Customer</label>
                        <input type="email" class="form-control @error('email_cust') is-invalid @enderror" name="email_cust" id="email_cust" value="{{ $invoice->email_cust }}" placeholder="email Customer" readonly>
                        @error('email_cust')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone_cust" class="form-label">Phone Customer</label>
                        <input type="tel" class="form-control @error('phone_cust') is-invalid @enderror" name="phone_cust" id="phone_cust" value="{{ $invoice->phone_cust }}" placeholder="Phone Customer" readonly>
                        @error('phone_cust')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
            
                    <div class="mb-3">
                        <label for="reference_no" class="form-label">Reference No (Transaction ID)</label>
                        <input type="text" class="form-control @error('reference_no') is-invalid @enderror" name="reference_no" id="reference_no" value="{{ old('reference_no') }}" placeholder="reference no">
                        @error('reference_no')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="d-grid mt-2"><button class="btn btn-primary btn-block" type="submit">Submit</button></div>
                    
                </form>
        
            </div>
        </div>
    </div>
</div>

@endsection