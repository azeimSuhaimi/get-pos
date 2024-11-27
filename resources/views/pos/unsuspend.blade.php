
@extends('layouts.main_layout')
 
@section('title', 'unsuspend page')
 
@section('content')

@include('partials.popup')


<div class="pagetitle">
    <h1>POINT OF SALE</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('pos')}}">POS</a></li>
        <li class="breadcrumb-item active"><a href="{{route('pos.suspend.list')}}">SUSPEND LIST</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        List suspend bill
    </div>
    <div class="card-body">
        <table id="datatables" class="text-center table datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Bill_id</th>
                    <th>Created_By_Email</th>
                    <th>Total</th>
                    <th>#</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Bill_id</th>
                    <th>Created_By_Email</th>
                    <th>Total</th>
                    <th>#</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($suspend as $row )
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$row->bill_id}}</td>
                        <td>{{$row->user_email}}</td>
                        <td>{{$row->total}}</td>
                        <td>
                            <form onsubmit="confirmAndSubmit(this)" class="submit" action="{{route('pos.unsuspend')}}" method="post">
                                @csrf
                                
                                <input type="hidden" name="id" value="{{$row->id}}">
                                <button type="submit" class="btn btn-primary">Unsuspend</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection


















