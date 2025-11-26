@extends('layouts.main_layout')
 
@section('title', 'customer page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <h1>All Customer</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{route('customer')}}">All Customer</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card text-bg-light">
          <div class="card-body">
            <h5 class="card-title">All Customer</h5>

            <a href="{{route('customer.create')}}" class="btn btn-primary ">ADD CUSTOMER</a>

            <!-- Table with stripped rows -->
            <table class="table datatable table-hover">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Phone.</th>
                    <th>Email</th>
                    <th>Point</th>
                    <th>Action</th>

                </tr>
              </thead>
              <tbody>
                @foreach ($customer as $cust)
                  
                  <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$cust->name}}</td>
                      <td>{{$cust->phone}}</td>
                      <td>{{$cust->email}}</td>
                      <td>{{$cust->point}}</td>
                      <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                          <a href="{{route('customer.edit')}}?id={{$cust->id}}" class="btn btn-primary  ">Edit Details</a>
                          <a href="{{route('customer.view')}}?id={{$cust->id}}" class="btn btn-info  ">view Details</a>
                          <a href="{{route('customer.purchase.detail')}}?id_cust={{$cust->id}}" class="btn btn-warning ">Purchase details</a>
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