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

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">All Customer</h5>
            <p>List all Customer.</p>

            <a href="{{route('customer.create')}}" class="btn btn-primary rounded-pill waves-effect waves-light">Create</a>

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
                    <th></th>
                    <th></th>
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
                            <a href="{{route('customer.edit')}}?id={{$cust->id}}" class="btn btn-primary rounded-pill waves-effect waves-light">Edit Details</a>
                      </td>
                      <td>
                        <a href="{{route('customer.view')}}?id={{$cust->id}}" class="btn btn-info rounded-pill waves-effect waves-light">view Details</a>
                      </td>
                      <td>
                        <a href="{{route('customer.purchase.detail')}}?id_cust={{$cust->id}}" class="btn btn-warning rounded-pill waves-effect waves-light">Purchase details</a>
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