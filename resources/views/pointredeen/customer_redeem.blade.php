@extends('layouts.main_layout')
 
@section('title', 'cash method page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <h1>Customer Redeem</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a href="{{route('pointredeen')}}">All Items Redeem</a></li>
            <li class="breadcrumb-item active"><a href="{{route('pointredeen.customer_redeem')}}?id={{$request->input('id')}}">Customer Redeem</a></li>
        </ol>
    </nav>
  </div><!-- End Page Title -->

<div class="card mb-4">

    <div class="card-body">
        <form id="search_page" class="text-start" autocomplete="off" action="{{route('pointredeen.search_customer')}}?id={{$request->input('id')}}" method="get">
            @csrf
            <input type="hidden" name="id" value="{{$request->input('id')}}">
            <button class="btn btn-primary mt-3" type="submit">Search Member</button>
        </form>

        <div class="row d-flex justify-content-center align-items-cente">

            <h6 class="card-title text-center text-uppercase font-weight-bold">Customer Redeem</h6>

            <div class="col-md-5">
                <div class="">
        
                    <h5 class="card-title text-center text-uppercase font-weight-bold">Item : {{$items->name}}</h5>
                </div>
    
                <div class="">
                    <h5 class="card-title text-center text-uppercase font-weight-bold">Description : {{$items->description}}</h5>
                </div>
        
                <div class="">
                    <h5 class="card-title text-center text-uppercase font-weight-bold">Point : {{$items->point}}</h5>
                </div>

                <div class="">
                    <h5 id="displayText" class="card-title text-center text-uppercase font-weight-bold @error('item_status') text-danger @enderror">Status : {{$items->status == true ? 'Active':'Deactive'}}</h5>
                    @error('item_status')
                        <span class="text-danger text-center text-uppercase">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-5 ">
                
                <form id="cash" onsubmit="confirmAndSubmit(this)"  action="{{route('pointredeen.redeen')}}" method="post">
                    @csrf

                    <input type="hidden" name="item_status" value="{{$items->status}}">
                    <input type="hidden" name="item_point" value="{{$items->point}}">
            
                    <input type="hidden" name="id" value="{{$request->input('id')}}">

                    <input type="hidden" name="id_cust" value="{{ ($request->has('id_cust') ? $request->input('id_cust'):'') }}">
                    
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
                        
                        <input type="text" class="form-control @error('point_customer') is-invalid @enderror" name="point_customer" id="point_customer" value="{{ ($request->has('point') ? $request->input('point'):'') }}" placeholder="Amount Tendered" readonly>
                        @error('point_customer')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
        
            </div>

            
            <div class="d-grid mt-2"><button form="cash" class="btn btn-primary btn-block" type="submit">Submit</button></div>
<!-- Button to set exact amount -->


        </div>
    </div>
</div>

@endsection