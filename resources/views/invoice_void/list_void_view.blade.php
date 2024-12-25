@extends('layouts.main_layout')
 
@section('title', 'Receipt page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <h1>void page</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('invoice_void')}}">Receipt</a></li>
        <li class="breadcrumb-item "><a href="{{route('invoice_void.list')}}">List Void</a></li>
        <li class="breadcrumb-item active"><a href="{{route('invoice_void.list.view')}}">List Void view</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->



  @if (Request::is('invoice_void_list_view'))
      
    <a href="{{route('invoice_void.list')}}" class="btn btn-danger mb-2">Close</a>
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
                            <td>Payment Type</td>
                            <td>{{$pay->payment_type}}</td>
                        </tr>

                        <tr>
                            <td colspan="4">&nbsp;</td>
                            <td>Tender</td>
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


                    @if ($pay->payment_type == 'debit')
                        <tr>
                            <td colspan="4">&nbsp;</td>
                            <td>Payment Type</td>
                            <td>{{$pay->payment_type}}</td>
                        </tr>

                        <tr>
                            <td colspan="4">&nbsp;</td>
                            <td>Reference No</td>
                            <td>{{$pay->reference_no}}</td>
                        </tr>


                    @endif

                    @if ($pay->payment_type == 'credit')
                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td>Payment Type</td>
                        <td>{{$pay->payment_type}}</td>
                    </tr>

                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td>Reference No</td>
                        <td>{{$pay->reference_no}}</td>
                    </tr>

                @endif

                @if ($pay->payment_type == 'duitnow')
                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td>Payment Type</td>
                        <td>{{$pay->payment_type}}</td>
                    </tr>

                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td>Reference No</td>
                        <td>{{$pay->reference_no}}</td>
                    </tr>


                @endif

                @if ($pay->payment_type == 'tng')
                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td>Payment Type</td>
                        <td>{{$pay->payment_type}}</td>
                    </tr>

                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td>Reference No</td>
                        <td>{{$pay->reference_no}}</td>
                    </tr>

                @endif

                @if ($pay->payment_type == 'TOYYIBPAY')
                <tr>
                    <td colspan="4">&nbsp;</td>
                    <td>Payment Type</td>
                    <td>{{$pay->payment_type}}</td>
                </tr>

                <tr>
                    <td colspan="4">&nbsp;</td>
                    <td>Reference No</td>
                    <td>{{$pay->reference_no}}</td>
                </tr>



            @endif

                @endforeach
  

          </table>

      </div>
  </div>












@endsection