@extends('layouts.main_layout')
 
@section('title', 'All Item reden page')
 
@section('content')

@include('partials.popup')


<div class="pagetitle">
    <h1>All Item Redeem</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{route('pointredeen')}}">All Items Redeem</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card text-bg-light">
          <div class="card-body">
            <h5 class="card-title">All Items</h5>

            <div class="btn-group" role="group" >
              <a href="{{route('pointredeen.create')}}" class="btn btn-primary mb-3">ADD ITEM </a>
              
            </div>


            <!-- Table with stripped rows -->
            <table class="table datatable table-hover ">
              <thead >
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Point</th>
                    <th>Status</th>
                    <th>Action</th>
                    
                </tr>
              </thead>
              <tbody>
                @foreach ($itemredeen as $row)
                  
                  <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$row->name}}</td>
                      <td>{{$row->description}}</td>
                      <td>{{$row->point}}</td>
                      <td>{{$row->status == true ? 'Active':'Deactive'}}</td>
                      <td>
                        <div class="btn-group" role="group" >
                          <a href="{{route('pointredeen.customer_redeem')}}?id={{$row->id}}" class="btn btn-success">Redeem</a>
                          <a href="{{route('pointredeen.edit')}}?id={{$row->id}}" class="btn btn-primary ">Edit</a>
                          <a href="{{route('pointredeen.view')}}?id={{$row->id}}" class="btn btn-info">View</a>
                          
                        </div>

                            
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