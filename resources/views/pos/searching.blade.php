
@extends('layouts.main_layout')
 
@section('title', 'searching page')
 
@section('content')

@include('partials.popup')



<div class="pagetitle">
    <h1>POINT OF SALE</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('pos')}}">POS</a></li>
        <li class="breadcrumb-item active"><a href="{{route('pos.search.item')}}">SEARCHING PAGE</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->


<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Items List

        <div class="text-end">
            <form autocomplete="off" action="{{route('pos')}}" method="get">
                @csrf
                <button class="btn btn-danger" type="submit">Close</button>
            </form>
        </div>

    </div>
    <div class="card-body">
        <table id="datatablesSimple" class="text-center table datatable">
            <thead >
                <tr >
                    <th>No</th>
                    <th>Short Code</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>#</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Short Code</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>#</th>
                    
                </tr>
            </tfoot>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->shortcode}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->description}}</td>
                        <td>{{$item->price}}</td>
                        <td>
                            <form action="{{route('pos.add.item')}}" method="post">
                                @csrf
                                <input type="hidden" name="shortcode" value="{{$item->shortcode}}">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection














