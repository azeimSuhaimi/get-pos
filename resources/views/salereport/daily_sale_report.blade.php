@extends('layouts.main_layout')
 
@section('title', 'daily sale report page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <h1>Sale Report</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{route('daily.sale.report')}}">Daily Sale Report</a></li>
        
      </ol>
    </nav>
  </div><!-- End Page Title -->

<div class="card">
    <div class="card-body">
      <h5 class="card-title">Daily Sale Report</h5>

      <!-- Multi Columns Form -->
      <form class="row g-3" method="get" onsubmit="confirmAndSubmit(this)" action="{{route('daily.sale.report')}}">

        @csrf
        <div class="row mb-3">
            <label for="date" class="col-md-4 col-lg-3 col-form-label">Date</label>
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



  <div class="card">



      <div class="card-body">



        <div class="card-title">Daily Sale Report | <strong>Date: </strong>{{\Carbon\Carbon::parse($date)->format('d-m-Y')}}
        
          
          <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <li class="dropdown-header text-start">
                <h6>PDF</h6>
              </li>
        
              <li><a class="dropdown-item" target="_blank" href="{{route('daily.sale.report.pdf')}}?date={{$date}}" id="filter-today">Print</a></li>
              
            </ul>
          </div> 
        
        </div>


    <!-- Sales Summary Section -->
    <h2>Sales Summary</h2>
    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <td><strong>Total Sales</strong></td>
                <td>RM {{ number_format($totalsale, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Total Transactions</strong></td>
                <td>{{ $totaltransaction }}</td>
            </tr>
            <tr>
                <td><strong>Gross Sale</strong></td>
                <td>RM {{ number_format($totalgrosssale, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Total Tax</strong></td>
                <td>RM {{ number_format($totaltax, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <h2>expense Summary</h2>
    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <td><strong>Total expense</strong></td>
                <td>RM {{ number_format($totalexpense, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Total count expense</strong></td>
                <td>{{ $countexpense }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Sales by Payment Type Section -->
    <h2>Sales by Payment Type</h2>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Payment Type</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
          <?php 
            $totalcash = 0
            
            ?>
          @foreach ($totalpaymenttypecash as $row)
          <?php 
            $item = DB::table('invoices')
            ->where('user_email',auth()->user()->email)
            ->where('invoice_id', $row->invoice_id)
            ->first();
            $totalcash += $item->total
        
        ?>
          @endforeach


            @foreach ( $payment_method as $row)
              
              @if ($row->payment_type == 'CASH')
                <tr>
                    <td> {{$row->payment_type }}</td>
                    <td>{{$totalcash}}</td>
                </tr>
              @else
                <tr>
                    <td> {{$row->payment_type }}</td>
                    <td>{{$row->total}}</td>
                </tr>
              @endif

            @endforeach 
        </tbody>
    </table>


      </div>
  </div>
@endif





@endsection