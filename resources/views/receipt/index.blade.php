@extends('layouts.main_layout')
 
@section('title', 'receipt list page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <h1>All Customer</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{route('receipt')}}">Receipt</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">All Receipt Today</h5>
            <p>List all Receipt.</p>

            

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
                @foreach ($invoice as $inv)
                  
                  <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$inv->invoice_id}}</td>
                      <td>{{$inv->created_at}}</td>
                      <td>{{$inv->total}}</td>
                      <td><a class="btn btn-primary" href="{{route('receipt.view').'?invoice_id='.$inv->invoice_id}}">view</a></td>
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