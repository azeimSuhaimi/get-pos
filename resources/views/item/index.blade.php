@extends('layouts.main_layout')
 
@section('title', 'All Item page')
 
@section('content')

@include('partials.popup')


<div class="pagetitle">
    <h1>All Item</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{route('item')}}">All Items</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">All Items</h5>
            <p>List all Items.</p>

            <a href="{{route('item.create')}}" class="btn btn-primary mb-3">Create </a>

            <!-- Table with stripped rows -->
            <table class="table datatable table-hover">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Image</th>
                    <th>Shortcode</th>
                    <th>Name</th>
                    <th>price</th>
                    <th>quantity</th>
                    <th>Status</th>
                    <th>Action</th>
                    <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $item)
                  
                  <tr>
                      <td>{{$loop->iteration}}</td>
                      <td><img src="items/{{$item->picture}}" style="width:50px; height: 40px;"></td>
                      <td>{{$item->shortcode}}</td>
                      <td>{{$item->name}}</td>
                      <td>{{$item->retail}}</td>
                      <td>{{$item->quantity}}</td>
                      <td>{{$item->status == true ? 'Active':'Deactive'}}</td>
                      <td>
                            <a href="{{route('item.edit')}}?id={{$item->id}}" class="btn btn-primary rounded-pill waves-effect waves-light">Edit</a>
                      </td>
                      <td>
                        <a href="{{route('item.view')}}?id={{$item->id}}" class="btn btn-info rounded-pill waves-effect waves-light">View</a>
                      </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <!-- End Table with stripped rows -->

          </div>
        </div>

      </div>
    </div>
  </section>


@endsection