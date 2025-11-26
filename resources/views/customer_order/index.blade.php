@extends('layouts.main_layout')
 
@section('title', 'customer order page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <h1>All customer order</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{route('customer_order')}}">All customer order</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <a href="{{route('customer_order.create')}}" class="btn btn-primary mb-2">Create</a>


  <div class="card text-bg-light">
    <div class="card-body">
      <h5 class="card-title">search by month</h5>

     
      <form class="row g-3" method="get" onsubmit="confirmAndSubmit(this)" action="{{route('customer_order')}}">

        @csrf
        <div class="row mb-3">
            <label for="date" class="col-md-4 col-lg-3 col-form-label">Date <span class="text-danger">*</span></label>
            <div class="col-md-8 col-lg-9">
              <input name="date" id="date" type="month" class="form-control @error('date') is-invalid @enderror" id="date" value="{{ $date == null ? '':$date }}">
              @error('date')
                  <span class=" invalid-feedback mt-2">{{ $message }}</span>
              @enderror
            </div>
          </div>

          <script>
            const monthInput = document.querySelector("#date");
          
            // Set the maximum allowed month to the current month (no future months allowed)
            function updateMonthLimits() {
              const today = new Date();
              const formattedMonth = today.toISOString().slice(0, 7); // format as YYYY-MM
              monthInput.max = formattedMonth; // No future months allowed
              monthInput.min = "1900-01"; // Adjust the min month as needed (e.g., 1900-01 or the earliest valid month)
            }
          
            // Call the function to initialize the input on page load
            updateMonthLimits();
          </script>
          


        <div class="text-center">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
      </form>

    </div>
</div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card text-bg-light">
          <div class="card-body">
            <h5 class="card-title">All customer order {{$date == null ? \Carbon\Carbon::now()->format('F Y'):\Carbon\Carbon::parse($date)->format('F Y')}}</h5>
            <p>List all customer order .</p>

            

            <!-- Table with stripped rows -->
            <table class="table datatable table-hover">
              <thead>
                <tr>
                    
                    <th>Date</th>
                    <th>Name.</th>
                    <th>Phone</th>
                    
                    <th>Item</th>
                    <th>Remark</th>
                    <th>#</th>

                </tr>
              </thead>
              <tbody>
                @foreach ($customer_order as $row)
                  
                  <tr>
                      
                      <td>{{\Carbon\Carbon::parse($row->created_at)->format('d-m-y')}}</td>
                      <td>{{$row->name}}</td>
                      <td>{{$row->phone}}</td>
                      
                      <td>{{$row->item}}</td>
                      <td>{{$row->remark}}</td>
                      <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                          @if ($row->contact == false)
                            <form onsubmit="confirmAndSubmit(this)" action="{{route('customer_order.update.contact')}}" method="post">
                              @csrf
                              <input type="hidden" name='id' value="{{$row->id}}">
                              <button class="btn btn-primary" type="submit">Contact</button>
                            </form>
                          @else
                            <button class="btn btn-success">Contact Check </button>
                          @endif

                          @if ($row->status == false)
                            <form onsubmit="confirmAndSubmit(this)" action="{{route('customer_order.update.status')}}" method="post">
                              @csrf
                              <input type="hidden" name='id' value="{{$row->id}}">
                              <button class="btn btn-primary" type="submit">pickup</button>
                            </form>
                          @else
                            <button class="btn btn-success">pick up Check</button>
                          @endif


                          @if ($row->status == false)
                            <form onsubmit="confirmAndSubmit(this)" action="{{route('customer_order.remove')}}" method="post">
                              @csrf
                              <input type="hidden" name='id' value="{{$row->id}}">
                              <button class="btn btn-danger" type="submit">Remove</button>
                            </form>
                          @endif
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