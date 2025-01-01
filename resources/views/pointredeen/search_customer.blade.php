@extends('layouts.main_layout')
 
@section('title', 'Redeem Item page')
 
@section('content')

@include('partials.popup')



<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Search Customer
    </div>
    <div class="card-body">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-12">


                    <div class="text-end">
                        <form autocomplete="off" action="{{route('pointredeen.customer_redeem')}}?id={{$request->input('id')}}" method="get">
                            @csrf
                            <input type="hidden" name="id" value="{{$request->input('id')}}">
                            <button class="btn btn-danger" type="submit">Close</button>
                        </form>
                    </div>                
                


                <h5 class="card-title">All Customer</h5>
                <p>List all Customer.</p>
    
                <!-- Table with stripped rows -->
                <table class="table datatable table-hover .table-sm">
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
                                <form action="{{route('pointredeen.customer_redeem')}}" method="get">
                                    <input type="hidden" name="id" value="{{$request->input('id')}}">
                                    <input type="hidden" name="id_cust" value="{{$cust->id}}">
                                    <input type="hidden" name="phone" value="{{$cust->phone}}">
                                    <input type="hidden" name="name" value="{{$cust->name}}">
                                    <input type="hidden" name="email" value="{{$cust->email}}">
                                    <input type="hidden" name="point" value="{{$cust->point}}">
                                    <button type="submit" class="btn btn-primary rounded-pill waves-effect waves-light">add</button>
                                </form>
                            

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

@endsection