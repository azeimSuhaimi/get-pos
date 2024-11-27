@extends('layouts.main_layout')
 
@section('title', 'Login page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <h1>List Customer Purchase</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a href="{{route('customer')}}">All Customer</a></li>
            <li class="breadcrumb-item active"><a href="{{route('customer.purchase.detail').'?id_cust='.$customer->id}}">Purchase Details</a></li>
        </ol>
    </nav>
</div><!-- End Page Title -->



<div class="card">

    <div class="card-header">


        
    </div>

    <div class="card-body">

        <form class="row g-3" onsubmit="confirmAndSubmit(this)" action="{{route('customer.update')}}" method="post">

            @csrf

                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="name" class="form-label">Customer Name</label>
                        <p class="text-danger text-uppercase">{{ $customer->name }}</p>
                    </div>
                </div>


            

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">Customer Email</label>
                        <p class="text-danger text-uppercase">{{ $customer->email }}</p>
                    </div>
                </div>


                            

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="phone" class="form-label">Customer Phone</label>
                        <p class="text-danger text-uppercase">{{ $customer->phone }}</p>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="ic" class="form-label">Customer I.C</label>
                        <p class="text-danger text-uppercase">{{ $customer->ic }}</p>
                    </div>
                </div>





                            

                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="address" class="form-label">Customer Address</label>
                        <p class="text-danger text-uppercase">{{ $customer->address }}</p>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">customer Point</label>
                        <p class="text-danger text-uppercase">{{$customer->point }}</p>
                    </div>
                </div>








        </form>


            <!-- Table with stripped rows -->
            <table class="table datatable table-hover">
                <thead>
                  <tr>
                      <th>No</th>
                      <th>Shortcode</th>
                      <th>Name</th>
                      <th>price</th>
                      <th>quantity</th>
                      <th>data</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($purchase_detail as $item)
                    
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->shortcode}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->price}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->created_at }}</td>

                    </tr>
                  @endforeach
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

    </div>
</div>


@endsection