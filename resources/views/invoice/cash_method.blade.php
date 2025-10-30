@extends('layouts.main_layout')
 
@section('title', 'cash method page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <h1>POINT OF SALE</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('pos')}}">POS</a></li>
        <li class="breadcrumb-item "><a href="{{route('invoice')}}">PAYMENT METHOD</a></li>
        <li class="breadcrumb-item active"><a href="{{route('invoice.cash.method')}}">CASH METHOD</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Cash Method
    </div>
    <div class="card-body">


        <div class="row d-flex justify-content-center align-items-cente">

            <h6 class="card-title text-center text-uppercase font-weight-bold">amount cash</h6>

            <div class="col-md-5">
                <div class="">
        
                    <h5 class="card-title text-center text-uppercase font-weight-bold">subtotal : {{Cart::subtotal()}}</h5>
                </div>
    
                <div class="">
                    <h5 class="card-title text-center text-uppercase font-weight-bold">tax : {{round(Cart::tax() * 20)/ 20}}</h5>
                </div>
        
                <div class="">
                    <h5 class="card-title text-center text-uppercase font-weight-bold">total : {{round(Cart::total() * 20)/ 20}}</h5>
                </div>

                <div class="">
                    <h5 id="displayText" class="card-title text-center text-uppercase font-weight-bold">Balance : 0</h5>
                </div>
            </div>
            <div class="col-md-5 ">
                
                <form id="cash" onsubmit="confirmAndSubmit(this)"  action="{{route('invoice.pay')}}" method="post">
                    @csrf
            
                    <input type="hidden" name="payment_type" value="CASH">

                    <input type="hidden" id="total" name="total" value="{{round(Cart::total() * 20)/ 20}}">


                    <input type="hidden" name="id_cust" value="{{ ($request->has('id') ? $request->input('id'):'') }}">
                    
                    <div class="mb-3">
                  
                        <input type="text" class="form-control @error('name_cust') is-invalid @enderror" name="name_cust" id="name_cust" value="{{ ( session('cust_name')  ? session('cust_name'):'') }}" placeholder="Name Customer" readonly>
                        @error('name_cust')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        
                        <input type="email" class="form-control @error('email_cust') is-invalid @enderror" name="email_cust" id="email_cust" value="{{ (session('cust_email')  ? session('cust_email'):'') }}" placeholder="email Customer" readonly>
                        @error('email_cust')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        
                        <input type="tel" class="form-control @error('phone_cust') is-invalid @enderror" name="phone_cust" id="phone_cust" value="{{ (session('cust_phone')  ? session('cust_phone'):'') }}" placeholder="Phone Customer" readonly>
                        @error('phone_cust')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class=" mb-3">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror " id="name" value="{{ old('name') }}" placeholder="name">
                        
                        @error('name')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
            
                    <div class="mb-3">
                        
                        <input type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" id="amount" value="{{ old('amount') }}" placeholder="Amount Tendered">
                        @error('amount')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    
                </form>
        
            </div>

            <div class="d-grid mt-2"><button type="button" id="exactAmountBtn" class="btn btn-secondary">Exact Amount</button></div>
            <div class="d-grid mt-2"><button form="cash" class="btn btn-primary btn-block" type="submit">Submit</button></div>
<!-- Button to set exact amount -->


        </div>
    </div>
</div>


<script>


const textInput = document.getElementById('amount');
const displayText = document.getElementById('displayText');
const total = document.getElementById('total');
const exactAmountBtn = document.getElementById('exactAmountBtn');


textInput.addEventListener('input', () => {
    let t =   textInput.value - total.value;
    displayText.textContent = 'Balance : ' + t ;
});

// Set the amount to the exact total when the button is clicked
exactAmountBtn.addEventListener('click', () => {
    textInput.value = total.value;  // Set amount to the total
    displayText.textContent = 'Balance: 0';  // Set balance to 0
});

</script>

@endsection