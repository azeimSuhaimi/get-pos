@extends('layouts.main_layout')
 
@section('title', 'purchase details page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a href="{{route('customer')}}">All Customer</a></li>
            <li class="breadcrumb-item active"><a href="{{route('customer.purchase.detail').'?id_cust='.$customer->id}}">Purchase Details</a></li>
        </ol>
    </nav>
</div><!-- End Page Title -->



<div class="card">



    <div class="card-body text-bg-light">

        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">List Customer Purchase</h5>
            <p class="text-center small">List Purchase Details</p>
        </div>

        <a href="{{route('customer')}}" class="btn btn-primary mb-4">BACK</a>

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

        <form onsubmit="confirmAndSubmit(this)" action="{{route('customer.enter.member')}}" method="post">

            @csrf
            <input type="hidden" name="cust_phone" value="{{$customer->phone}}">
            <input type="hidden" name="id" value="{{$customer->id}}">
            @error('id')
            <span class=" invalid-feedback mt-2">{{ $message }}</span>
        @enderror

            <div class="col-md-6 m-2">
                <label for="invoice_id" class="form-label">Bill Invoice <span class="text-danger"></span></label>
                <input type="text" class="form-control @error('invoice_id') is-invalid @enderror" value="{{old('invoice_id')}}" name="invoice_id" id="invoice_id">
                @error('invoice_id')
                    <span class=" invalid-feedback mt-2">{{ $message }}</span>
                @enderror
            </div>

            <button class="btn btn-primary" type="submit">submit</button>
        </form>


            <h3 class="text-center">List Purchase Details</h3>
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

            <h3 class="text-center">List Items Redeem Details</h3>
            <!-- Table with stripped rows -->
            <table class="table datatable table-hover">
                <thead>
                  <tr>
                      <th>No</th>
                      <th>Item</th>
                      <th>Description</th>
                      <th>Point</th>
                      <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($customeritemredeen as $row)
                    
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$row->name_item}}</td>
                        <td>{{$row->description_item}}</td>
                        <td>{{$row->point}}</td>
                        <td>{{$row->created_at}}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
            <!-- End Table with stripped rows -->

    </div>
</div>


@endsection