@extends('layouts.main_layout')
 
@section('title', 'Payment method page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <h1>POINT OF SALE</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('pos')}}">POS</a></li>
        <li class="breadcrumb-item active"><a href="{{route('invoice')}}">PAYMENT METHOD</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Bill Payment Method
    </div>
    <div class="card-body">
        <table id="" class="table table-bordered table-hover text-center ">
            <thead >
                <tr >
                    <th>No</th>
                    <th>Short Code</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            
            <tbody>
                @if (Cart::count() < 1)
                    <tr>
                        <td colspan="7">No entries found</td>
                    </tr>
                @else
                    
                    @foreach (Cart::content() as $row)
        
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->id}}</td>
                            <td>{{$row->name}}</td>
                            <td>{{$row->price}}</td>
                            <td>{{$row->qty}}</td>
                            <td rowspan="">{{$row->subtotal}}</td>
                        </tr>

                    @endforeach
                @endif
            </tbody>

            <tfoot>
                <tr >
                    <th  colspan="4">&nbsp;</th>
                    <th>Subtotal</th>
                    <th><?php echo Cart::subtotal(); ?></td>
                </tr>
                <tr>
                    <th colspan="4">&nbsp;</th>
                    <th>Tax</th>
                    <th><?php echo round(Cart::tax() * 20)/ 20 ?></td>
                </tr>
                <tr>
                    <th colspan="4">&nbsp;</th>
                    <th>Total</th>
                    <th><?php echo round(Cart::total() * 20)/ 20 ?></td>
                </tr>
    
                
            </tfoot>
        </table>
    </div>
    <div class="card-footer text-center py-3">
        
        <?php $i = 0?>
        @foreach (Cart::content() as $row)
            <?php $i = $loop->iteration; ?>
        @endforeach

        <form class="" action="{{route('invoice.cash.method')}}" method="get">
            @csrf
            <div class="d-grid mt-2"><button type="submit" class="btn btn-primary btn-block">Cash</button></div>
            
        </form>

        <form class="" action="{{route('invoice.digital.method')}}" method="get">
            @csrf
            <div class="d-grid mt-2"><button type="submit" class="btn btn-primary btn-block">Digital Pay</button></div>
            
        </form>

        <form class="" action="{{route('invoice.hybrid.method')}}" method="get">
            @csrf
            <div class="d-grid mt-2"><button type="submit" class="btn btn-primary btn-block">Hybrid</button></div>
            
        </form>

        <form class="" action="{{route('invoice.toyyibpay.method')}}" method="get">
            @csrf
            <div class="d-grid mt-2"><button type="submit" class="btn btn-primary btn-block">Toyyip pay</button></div>
            
        </form>

        <form id="new_sale" class="mt-2" onsubmit="confirmAndSubmit(this)" action="{{route('pos.remove.all')}}" method="post">
            @csrf
            <div class="d-grid mt-2"><button class="{{$i >= 1 ? '':'disabled'}} btn btn-primary btn-block" type="submit">New Sales</button></div>
            
          </form>
  
            <form id="suspend_bill" class="mt-2" onsubmit="confirmAndSubmit(this)" action="{{route('pos.suspend')}}" method="post">
              @csrf
              <input type="hidden" name="qty" value="{{$i}}">
              <div class="d-grid mt-2"><button class="{{$i >= 1 ? '':'disabled'}} btn btn-primary btn-block" type="submit">Suspend Bill</button></div>
              
            </form>

        
    </div>
</div>


@endsection