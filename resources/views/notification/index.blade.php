@extends('layouts.main_layout')
 
@section('title', 'notification page')
 
@section('content')

@include('partials.popup')


<section class="section">
    <div class="row">
      <div class="col-lg-12">
  
        <div class="card text-bg-light">
          <div class="card-body">
            <h5 class="card-title">Online Order </h5>
            <p>List all Online.</p>
  
            
  
            <!-- Table with stripped rows -->
            <table class="table datatable table-hover">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Bill ID</th>
                    <th>Name</th>
                    <th>Number</th>
                    <th>Total</th>
                    <th>#</th>
                    <th>#</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($notification as $row)
                <?php 
                    $invoice = DB::table('invoices')->where('id',$row->invoice_id)->first();
                    
                ?>
                  <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$invoice->invoice_id}}</td>
                      <td>{{$invoice->name}}</td>
                      <td>{{$invoice->name}}</td>
                      <td>RM {{$invoice->total}}</td>
                      <td><a class="btn btn-{{$row->status_read == true ? 'success':'info'}}" href="{{route('notification.view').'?id='.$invoice->id}}">view</a></td>
                      <td><a class="btn btn-primary" onclick="confirmAndRedirect(this)" href="{{route('notification.edit').'?id='.$invoice->id}}">finish</a></td>
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