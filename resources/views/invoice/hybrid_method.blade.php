@extends('layouts.main_layout')
 
@section('title', 'hybrid method page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <h1>POINT OF SALE</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('pos')}}">POS</a></li>
        <li class="breadcrumb-item "><a href="{{route('invoice')}}">PAYMENT METHOD</a></li>
        <li class="breadcrumb-item active"><a href="{{route('invoice.digital.method')}}">HYBRID METHOD</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Digital Method
    </div>
    <div class="card-body">

        <form id="search_page" class="text-start" autocomplete="off" action="{{route('invoice.add_member.hybrid')}}" method="get">
            @csrf
            <button class="btn btn-primary" type="submit">Search Member</button>
        </form>

        <div class="row d-flex justify-content-center align-items-cente">

            <h6 class="card-title text-center text-uppercase font-weight-bold">amount </h6>
            <div class="col-md-5">
                <div class="mb-">
        
                    <h5 class="card-title text-center text-uppercase font-weight-bold">subtotal : {{Cart::subtotal()}}</h5>
                </div>
    
                <div class="mb-">
                    <h5 class="card-title text-center text-uppercase font-weight-bold">tax : {{Cart::tax()}}</h5>
                </div>
        
                <div class="mb-">
                    <h5 class="card-title text-center text-uppercase font-weight-bold">total : {{Cart::total()}}</h5>
                </div>

                <div class="">
                    <h5 id="displayText" class="card-title text-center text-uppercase font-weight-bold">Balance : 0</h5>
                </div>
            </div>

            <div class="col-md-5 ">
                <form id="hybrid" onsubmit="confirmAndSubmit(this)"  action="{{route('invoice.pay')}}" method="post">
                    @csrf
            
                    <input type="hidden" name="HYBRID" value="HYBRID">
                    <input type="hidden" id="total" name="total" value="{{Cart::total()}}">


                    <input type="hidden" name="id_cust" value="{{ ($request->has('id') ? $request->input('id'):'') }}">
                    
                    <div class="mb-3">

                        <input type="text" class="form-control @error('name_cust') is-invalid @enderror" name="name_cust" id="name_cust" value="{{ ($request->has('name') ? $request->input('name'):'') }}" placeholder="Name Customer" readonly>
                        @error('name_cust')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">

                        <input type="email" class="form-control @error('email_cust') is-invalid @enderror" name="email_cust" id="email_cust" value="{{ ($request->has('email') ? $request->input('email'):'') }}" placeholder="email Customer" readonly>
                        @error('email_cust')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">

                        <input type="tel" class="form-control @error('phone_cust') is-invalid @enderror" name="phone_cust" id="phone_cust" value="{{ ($request->has('phone') ? $request->input('phone'):'') }}" placeholder="Phone Customer" readonly>
                        @error('phone_cust')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">

                        <input type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" id="amount" value="{{ old('amount') }}" placeholder="Amount Tendered">
                        @error('amount')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
            
                    <div class="mb-3">

                        <input type="text" class="form-control @error('reference_no') is-invalid @enderror" name="reference_no" id="reference_no" value="{{ old('reference_no') }}" placeholder="reference no">
                        @error('reference_no')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="payment_type" class="form-label">payment type</label>
                        <select class="form-control @error('payment_type') is-invalid @enderror" name="payment_type" id="payment_type">
                            <option ></option>
                            <option value="debit" @selected(old('payment_type') == 'debit')>debit</option>
                            <option value="credit" @selected(old('payment_type') == 'credit')>credit</option>
                            <option value="tng" @selected(old('payment_type') == 'tng')>touch n go</option>
                            <option value="duitnow" @selected(old('payment_type') == 'duitnow')>duitnow</option>
                        </select>
                        @error('payment_type')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    
                    
                </form>
        
            </div>
            <div class="d-grid mt-2"><button form="hybrid" class="btn btn-primary btn-block" type="submit">Submit</button></div>
        </div>
    </div>
</div>

<script>


    const textInput = document.getElementById('amount');
    const displayText = document.getElementById('displayText');
    const total = document.getElementById('total');
    
    
    textInput.addEventListener('input', () => {
        let t =   textInput.value - total.value;
        displayText.textContent = 'Balance : ' + t ;
    });
    
    </script>

@endsection