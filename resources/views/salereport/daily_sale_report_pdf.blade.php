
<div style="text-align: center;margin: 0;"> <h2 style="margin: 0;">{{$company->company_name}}</h2></div>
<div style="text-align: center;margin: 0;"> <h4 style="margin: 0;">Company No : {{$company->company_id}}</h4></div>
<div style="text-align: center;margin: 0;"> <h4 style="margin: 0;">{{$company->address}}, {{$company->city}}</h4></div>
<div style="text-align: center;margin: 0;"> <h4 style="margin: 0;">{{$company->poscode}}, {{$company->state}}, {{$company->country}}.</h4></div>
<div style="text-align: center;margin: 0;"> <h4 style="margin: 0;">Phone No : {{$company->phone}}</h4></div>

<br>
<br>

<div class="card">



    <div class="card-body">

      
      <div class="card-title">Daily Sale Report | <strong>Date: </strong>{{\Carbon\Carbon::parse($date)->format('d-m-Y')}}
      

      
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
          ->where('user_id',auth()->user()->id)
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