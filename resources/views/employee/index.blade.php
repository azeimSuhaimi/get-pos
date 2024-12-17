@extends('layouts.main_layout')
 
@section('title', 'All Employee page')
 
@section('content')

@include('partials.popup')


<div class="pagetitle">
    <h1>All Employee</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{route('employee')}}">All Employee</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="card text-bg-light">
    <div class="card-body">
      <h5 class="card-title">All Employee</h5>
      <p>List all employee.</p>

      <!-- Table with stripped rows -->
      <table class="table datatable table-hover">
        <thead>
          <tr>
              <th>No</th>
              <th>Image</th>
              <th>Name</th>
              <th>Work I.D.</th>
              <th>Email</th>
              <th>Status</th>
              <th>Action</th>
              <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($employee as $emp)
            
            <tr>
                <td>{{$loop->iteration}}</td>
                <td><img src="profile/{{$emp->picture}}" style="width:50px; height: 40px;"></td>
                <td>{{$emp->name}}</td>
                <td>{{$emp->work_id}}</td>
                <td>{{$emp->email}}</td>
                <td>{{$emp->status == true ? 'Active':'Resign'}}</td>
                <td>
                  <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{route('employee.edit')}}?id={{$emp->id}}" class="btn btn-primary ">Edit</a>
                    <a href="{{route('employee.view')}}?id={{$emp->id}}" class="btn btn-info ">View</a>
                  </div>
                      
                </td>

            </tr>
          @endforeach
        </tbody>
      </table>
      <!-- End Table with stripped rows -->

    </div>
  </div>


@endsection