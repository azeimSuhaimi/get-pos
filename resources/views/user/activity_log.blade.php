@extends('layouts.main_layout')
 
@section('title', 'Activity Log page')
 
@section('content')

@include('partials.popup')


<div class="pagetitle">
    <h1>Activity Log</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Activity Log</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Activity Log</h5>
            <p>Activity did you do in whole time.</p>

            <!-- Table with stripped rows -->
            <table class="table datatable  table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Activity</th>
                  <th>Details</th>
                  <th>Date</th>
                  <th>Time</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($activity_log as $log)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$log->activity}}</td>
                        <td>{{$log->details}}</td>
                        <td>{{$log->date}}</td>
                        <td>{{$log->time}}</td>
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