@extends('layouts.main_layout')
 
@section('title', 'view page')
 
@section('content')

@include('partials.popup')






    
    <a href="{{route('notification')}}" class="btn btn-danger mb-2">Close</a>
    <a class="btn btn-primary mb-2" onclick="confirmAndRedirect(this)" href="{{route('notification.edit').'?id='.$invoice->id}}">finish</a>

  <div class="card text-bg-light mb-4">

      <div class="card-body">
        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Receipt</h5>
            
        </div>

          <h1 class="card-title text-uppercase text-center font-weight-bold"> {{$invoice->daily_unique_number}} </h1>
          <h5 class=" text-uppercase text-end font-weight-bold">bill id : {{$invoice->invoice_id}}</h5>
          <h5 class=" text-uppercase text-end font-weight-bold">date : {{$invoice->created_at}}</h5>
          @if ($invoice->name)
            <h5 class=" text-uppercase text-end font-weight-bold">name customer : {{$invoice->name}}</h5>
          @endif
          @if ($invoice->email_cust !== null)
              
            <h5 class=" text-uppercase text-start font-weight-bold">name  : {{$invoice->name_cust}}</h5>
            <h5 class=" text-uppercase text-start font-weight-bold">email  : {{$invoice->email_cust}}</h5>
            <h5 class=" text-uppercase text-start font-weight-bold">phone  : {{$invoice->phone_cust}}</h5>
          @endif

          <table id="datatablesSimple" class="table table-bordered table-hover text-center">
              <thead>
                  <tr>
                      <th>No</th>
                      <th>item</th>
                      <th>name</th>
                      <th>price</th>
                      <th>quantity</th>
                      <th>subtotal</th>
                  </tr>
              </thead>

                  @foreach ($invoice_detail as $row)
      
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$row->shortcode}}</td>
                        <td>{{$row->name}}</td>
                        <td>{{$row->price}}</td>
                        <td>{{$row->quantity}}</td>
                        <td>{{$row->quantity * $row->price}}</td>
                    </tr>
                    @if ($row->remark !== '')
                        <tr>
                            <td colspan="8">{{$row->remark}}</td>
                        </tr>
                    @endif
                  @endforeach

                  <tr>
                    <td colspan="4">&nbsp;</td>
                    <td>Subtotal</td>
                    <td>{{$invoice->subtotal}}</td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;</td>
                    <td>Tax</td>
                    <td>{{$invoice->tax}}</td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;</td>
                    <td>Total</td>
                    <td>{{$invoice->total}}</td>
                </tr>
                @foreach ($payment_method as $pay)

                    @if ($pay->payment_type == 'CASH')
                        <tr>
                            <td colspan="4">&nbsp;</td>
                            <td>{{$pay->payment_type}}</td>
                            <td>{{$pay->tender}}</td>
                        </tr>


                        @if ($pay->tender >= $invoice->total)
                            <tr>
                                <td colspan="4">&nbsp;</td>
                                <td>Balance</td>
                                <td>{{$pay->tender - $invoice->total}}</td>
                            </tr>
                        @endif

                    @endif

                    @foreach ($payment_type as $row )
                        @if ($pay->payment_type == $row->payment_name)
                            <tr>
                                <td colspan="4">&nbsp;</td>
                                <td>{{$pay->payment_type}}</td>
                                <td>{{$pay->tender}}</td>
                            </tr>

                            <tr>
                                <td colspan="4">&nbsp;</td>
                                <td>Reference No</td>
                                <td>{{$pay->reference_no}}</td>
                            </tr>

                        @endif
                    @endforeach


                @endforeach
  

          </table>

      </div>
  </div>






@endsection