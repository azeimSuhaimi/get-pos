@extends('layouts.main_layout')
 
@section('title', 'All waste page')
 
@section('content')

@include('partials.popup')


<div class="pagetitle">
    <h1>All waste</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{route('waste')}}">All wastes</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card text-bg-light">
          <div class="card-body">
            <h5 class="card-title"></h5>

            <a href="{{route('waste.create')}}" class="btn btn-primary mb-3">ADD waste </a>
            

            <!-- Table with stripped rows -->
            <table class="table datatable table-hover ">
              <thead >
                <tr>
                    <th>No</th>
                    <th>Shortcode</th>
                    <th>Name</th>
                    <th>total</th>
                    <th>quantity</th>
                    <th>date</th>
                    <th>Action</th>
                    
                </tr>
              </thead>
              <tbody>
                @foreach ($wastes as $waste)
                  
                  <tr>
                      <td>{{$loop->iteration}}</td>
                      
                      <td>{{$waste->shortcode}}</td>
                      <td>{{$waste->name}}</td>
                      <td>{{$waste->price}}</td>
                      <td>{{$waste->quantity}}</td>
                      <td>{{$waste->created_at}}</td>
                      
                      <td>
                        <div class="btn-group" role="group" >
                          
                          <a href="{{route('waste.view')}}?id={{$waste->id}}" class="btn btn-info">View</a>
                          
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