@extends('layouts.quickorder_layout')
 
@section('title', 'POS page')
 
@section('content')

@include('partials.popup')


<div class="container">
    <div class="text-end mt-5">
        <form autocomplete="off" action="{{route('quick.cart.view')}}" method="get">
            @csrf
            <input type="hidden" name="user_email"  value="{{$validated['user_email']}}">
            <button class="btn btn-danger" type="submit">Close</button>
        </form>
    </div>   

    <div class="card mb-4 mt-5">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Update Quantity On Item
        </div>
        <div class="card-body">
            <form onsubmit="confirmAndSubmit(this)" action="{{route('quick.update_quantity').'?user_email='.$validated['user_email']}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$rowid->id}}">
                <input type="hidden" name="rowid" value="{{$rowid->rowId}}">
                <input type="number" style="width: 30%;" name="qty" value="{{$rowid->qty}}">
                <button type="submit" class="btn btn-success">Edit</button>
            </form>

        </div>
    </div> 
</div>

 






@endsection