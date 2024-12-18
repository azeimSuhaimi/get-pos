@extends('layouts.main_layout')
 
@section('title', 'receipt list Today page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <h1>All Customer </h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{route('invoice_void')}}">Receipt</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="card text-bg-light">
    <div class="card-body">
      <h5 class="card-title">Daily Sale</h5>

      <!-- Multi Columns Form -->
      <form class="row g-3" method="get" onsubmit="confirmAndSubmit(this)" action="{{route('invoice_void')}}">

        @csrf
        <div class="row mb-3">
            <label for="date" class="col-md-4 col-lg-3 col-form-label">Date <span class="text-danger">*</span></label>
            <div class="col-md-8 col-lg-9">
              <input name="date" id="date" type="date" class="form-control @error('date') is-invalid @enderror" id="date" value="{{ old('date') }}">
              @error('date')
                  <span class=" invalid-feedback mt-2">{{ $message }}</span>
              @enderror
            </div>
          </div>

          <script>
            const dateInput = document.querySelector("#date");
            
            // Set the maximum allowed date to today (no future dates)
            function updateDateLimits() {
              const today = new Date();
              const formattedDate = today.toISOString().split('T')[0]; // format as YYYY-MM-DD
              dateInput.max = formattedDate; // No future dates allowed
              dateInput.min = "1900-01-01"; // You can adjust the min date as needed (e.g., 1900 or the earliest valid date)
            }
            
            // Call the function to initialize the input on page load
            updateDateLimits();
            </script>


        <div class="text-center">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
      </form><!-- End Multi Columns Form -->

    </div>
</div>

@if ($request->input('date') != null)
<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card text-bg-light">
        <div class="card-body">
          <h5 class="card-title">All Receipt </h5>
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
                    <td><a class="btn btn-primary" href="{{route('invoice_void.view').'?invoice_id='.$inv->invoice_id}}">view</a></td>
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
@else
  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card text-bg-light">
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
                      <td><a class="btn btn-primary" href="{{route('invoice_void.view').'?invoice_id='.$inv->invoice_id}}">view</a></td>
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
@endif





@endsection