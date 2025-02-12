@extends('layouts.main_layout')
 
@section('title', 'Receipt page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <h1>POINT OF SALE</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('invoice_void')}}">list receipt</a></li>
        <li class="breadcrumb-item active"><a href="{{route('invoice_void.view').'?invoice_id='.$invoice_id}}">view</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->



  @if (Request::is('invoice_void_view'))
      
    <a href="{{route('invoice_void')}}" class="btn btn-danger mb-2">Close</a>
    @endif

  <div class="card text-bg-light mb-4">
      <div class="card-header">
          <i class="fas fa-table me-1"></i>
          Receipt
      </div>
      <div class="card-body">
          <h1 class="card-title text-uppercase text-center font-weight-bold">Receipt</h1>
          <h5 class=" text-uppercase text-end font-weight-bold">bill id : {{$invoice->invoice_id}}</h5>
          <h5 class=" text-uppercase text-end font-weight-bold">date : {{$invoice->created_at}}</h5>
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
                      <th>discount</th>
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
                      <td>{{$row->discount}}%</td>
                      <td>{{$row->quantity}}</td>
                          <td>{{$row->quantity * $row->price}}</td>
                      </tr>
                  @endforeach

                  <tr>
                    <td colspan="5">&nbsp;</td>
                    <td>Subtotal</td>
                    <td>{{$invoice->subtotal}}</td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;</td>
                    <td>Tax</td>
                    <td>{{$invoice->tax}}</td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;</td>
                    <td>Total</td>
                    <td>{{$invoice->total}}</td>
                </tr>
                @foreach ($payment_method as $pay)

                    @if ($pay->payment_type == 'CASH')
                        <tr>
                            <td colspan="5">&nbsp;</td>
                            <td>Payment Type</td>
                            <td>{{$pay->payment_type}}</td>
                        </tr>

                        <tr>
                            <td colspan="5">&nbsp;</td>
                            <td>Tender</td>
                            <td>{{$pay->tender}}</td>
                        </tr>

                        @if ($pay->tender >= $invoice->total)
                            <tr>
                                <td colspan="5">&nbsp;</td>
                                <td>Balance</td>
                                <td>{{$pay->tender - $invoice->total}}</td>
                            </tr>
                        @endif

                    @endif

                    @foreach ($payment_type as $row )
                    @if ($pay->payment_type == $row->payment_name)
                        <tr>
                            <td colspan="5">&nbsp;</td>
                            <td>{{$pay->payment_type}}</td>
                            <td>{{$pay->tender}}</td>
                        </tr>

                        <tr>
                            <td colspan="5">&nbsp;</td>
                            <td>Reference No</td>
                            <td>{{$pay->reference_no}}</td>
                        </tr>

                    @endif
                @endforeach









                @endforeach
  

          </table>

      </div>
  </div>



  <div class="card mb-4">
    <div class="card-body">
        <h4 class="card-title text-uppercase text-center font-weight-bold">Void This Invoice</h4>
        <form onsubmit="confirmAndSubmit(this)" action="{{route('invoice_void.void')}}" method="post">
            @csrf

                <input type="hidden" name="invoice_id" value="{{$invoice->invoice_id}}">


            <!---->
            <div class="mt-4 mb-0">
                <div class="d-grid mt-2"><button type="submit" class="btn btn-danger btn-block" >Void Invoice</button></div>
            </div>
            
        </form>
    </div>
</div>








@endsection