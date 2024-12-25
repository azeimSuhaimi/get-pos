@extends('layouts.main_layout')
 
@section('title', 'void list page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <h1>All void </h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('invoice_void')}}">Receipt</a></li>
        <li class="breadcrumb-item active"><a href="{{route('invoice_void.list')}}">List Void</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->


  <a href="{{route('invoice_void')}}" class="btn btn-danger mb-2">Close</a>


  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card text-bg-light">
          <div class="card-body">
            <h5 class="card-title">All Void</h5>
            <p>List all void.</p>

            

            <!-- Table with stripped rows -->
            <table class="table datatable table-hover">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Bill ID</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>#</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($invoice_void as $inv)
                  
                  <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$inv->invoice_id}}</td>
                      <td>{{$inv->created_at}}</td>
                      <td>{{$inv->total}}</td>
                      <td><a class="btn btn-primary" href="{{route('invoice_void.list.view').'?invoice_id='.$inv->invoice_id}}">view</a></td>
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