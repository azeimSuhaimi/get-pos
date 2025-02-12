@extends('layouts.main_layout')
 
@section('title', 'POS page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <h1>POINT OF SALE</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('pos')}}">POS</a></li>
        @if (Request::is('pos_update_quantity_page'))
            <li class="breadcrumb-item active"><a href="">Update Quantity</a></li>
        @endif
        @if (Request::is('pos_update_price_page'))
            <li class="breadcrumb-item active"><a href="">Update Price</a></li>
        @endif
        
      </ol>
    </nav>
  </div><!-- End Page Title -->

    <div class="text-end">
        <form autocomplete="off" action="{{route('pos')}}" method="get">
            @csrf
            <button class="btn btn-danger" type="submit">Close</button>
        </form>
    </div>   


    @if (Request::is('pos_update_quantity_page'))
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Update Quantity On Item
            </div>
            <div class="card-body">
                <form onsubmit="confirmAndSubmit(this)" action="{{route('pos.update.quantity')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$rowid->id}}">
                    <input type="hidden" name="rowid" value="{{$rowid->rowId}}">
                    
                    <input type="number" style="width: 30%;" name="qty" value="{{$rowid->qty}}">
                    <button type="submit" class="btn btn-success">Edit</button>
                </form>

            </div>
        </div>        
    @endif

    @if (Request::is('pos_update_price_page'))
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Update Price On Item
            </div>
            <div class="card-body">
                <form onsubmit="confirmAndSubmit(this)" action="{{route('pos.update.price')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$rowid->id}}">
                    <input type="hidden" name="rowid" value="{{$rowid->rowId}}">
                    <input type="hidden" name="discount" value="{{$rowid->options->discount}}">
                    <input type="number" style="width: 30%;" name="price" value="{{$rowid->price}}">
                    <button type="submit" class="btn btn-success">Edit</button>
                </form>

            </div>
        </div>        
    @endif




@endsection