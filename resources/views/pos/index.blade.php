@extends('layouts.main_layout')
 
@section('title', 'POS page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <h1>POINT OF SALE</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{route('pos')}}">POS</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->


  <div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        


        <div >
          <form id="search_page" class="text-start" autocomplete="off" action="{{route('pos.search.item')}}" method="get">
              @csrf
              <button class="btn btn-success" type="submit"><i class="bi bi-search"></i></button>
          </form>

          <form class="text-end" autocomplete="off" action="{{route('pos.add.item')}}" method="post">
            @csrf
            <input class="@error('category') is-invalid @enderror" type="text" value="{{  old('shortcode') }}" name="shortcode" placeholder="enter shortcode">
            <button class="btn btn-primary" type="submit"><i class="bi bi-plus"></i></button>
          </form>
        </div>
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
                    <th>Discount</th>
                    <th>#</th>
                    <th>Subtotal Item</th>
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
                            <td>
                                {{$row->price}}
                            </td>
                            <td>
                                {{$row->qty}}
                            </td>
                            <td>
                                {{$row->options->discount}}%
                            </td>

                            <td>
                                <div class="btn-group m-0 p-0" role="group">
                                    <form action="{{route('pos.update.price.page')}}" method="get">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$row->id}}">
                                        <input type="hidden" name="rowid" value="{{$row->rowId}}">
                                        <button type="submit" class="btn btn-success"><i class="bi bi-coin"></i></button>
                                    </form>
                                    <form action="{{route('pos.update.quantity.page')}}" method="get">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$row->id}}">
                                        <input type="hidden" name="rowid" value="{{$row->rowId}}">
                                        <button type="submit" class="btn btn-warning"><i class="bi bi-plus"></i></button>
                                    </form>
                                    <form onsubmit="confirmAndSubmit(this)" action="{{route('pos.add.remark')}}" method="get">
                                        @csrf
                                        <input type="hidden" name="rowid"  value="{{$row->rowId}}">
                                        
                                        <button type="submit" class="btn btn-info"><i class="bi bi-pencil"></i></button>
                                    </form>
                                    <form onsubmit="confirmAndSubmit(this)" action="{{route('pos.remove.item')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="rowid"  value="{{$row->rowId}}">
                                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                                
                            </td>
                            <td rowspan="{{$loop->iteration}}">{{$row->subtotal()}}</td>
                        </tr>

                        @if ($row->options->remark !== '')
                            <tr>
                                <td colspan="7">{{$row->options->remark}}</td>
                            </tr>
                        @endif

                    @endforeach
                @endif
            </tbody>

            <tfoot>
                <tr >
                    <th  colspan="6">&nbsp;</th>
                    <th>Subtotal</th>
                    <th><?php echo Cart::subtotal(); ?></td>
                </tr>
                <tr>
                    <th colspan="6">&nbsp;</th>
                    <th>Tax</th>
                    <th><?php echo round(Cart::tax() * 20) / 20; ?></td>
                </tr>
                <tr>
                    <th colspan="6">&nbsp;</th>
                    <th>Total</th>
                    <th><?php echo round(Cart::total() * 20) / 20; ?></td>
                </tr>
    
                
            </tfoot>
        </table>

        <?php 
            $number = 7.26;

            // Multiply by 20, round to nearest integer, then divide by 20
            $rounded = round(Cart::total() * 20) / 20;

            //echo $rounded; // Output: 7.25
            ?>

        <?php $i = 0?>
        @foreach (Cart::content() as $row)
            <?php $i = $loop->iteration; ?>
        @endforeach
        <?php $u = 0?>
        @foreach ($suspend as $row)
            <?php $u = $loop->iteration; ?>
        @endforeach 

        <div class="card-footer d-flex text-center ">
            <form class="mt-2 p-2"  action="{{route('invoice')}}" method="get">
                @csrf
                <div class=" mt-2">
                    <button class="{{Cart::total() <= 0 ? 'disabled':''}} btn btn-primary " type="submit">Invoice</button>
                </div>
              </form>
      
              <form id="new_sale" class="mt-2 p-2" onsubmit="confirmAndSubmit(this)" action="{{route('pos.remove.all')}}" method="post">
                @csrf
                <div class=" mt-2 ">
                    <button class="{{$i >= 1 ? '':'disabled'}} btn btn-primary " type="submit">New Sales</button>
                </div>
              </form>
      
                <form id="suspend_bill" class="mt-2 p-2" onsubmit="confirmAndSubmit(this)" action="{{route('pos.suspend')}}" method="post">
                  @csrf
                  <input type="hidden" name="qty" value="{{$i}}">
                  <div class=" mt-2">
                    <button class="{{$i >= 1 ? '':'disabled'}} btn btn-primary " type="submit">Suspend Bill</button>
                  </div>
                </form>
      
                <form id="suspend_view" class="mt-2 p-2" onsubmit="confirmAndSubmit(this)" action="{{route('pos.suspend.list')}}" method="get">
                  @csrf
                  <input type="hidden" name="qty" value="{{$i}}">
                  <div class=" mt-2">
                    <button class="{{$u >= 1 ? '':'disabled'}} btn btn-primary " type="submit">Resume Suspend Bill</button>
                  </div>
                </form>

                <form  class="mt-2 p-2"  action="{{route('pos.quick.order.page')}}" method="get">
                    @csrf
                    
                    <div class=" mt-2">
                      <button class="{{$i < 1 ? '':'disabled'}} btn btn-primary " type="submit">Quick Order</button>
                    </div>
                  </form>
        </div>
        







    </div>
</div>

<script>
    document.addEventListener('keydown', function(event) {
        if (event.key === 'F1') {
            event.preventDefault();
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, ',
                cancelButtonText: 'cancel, '
            }).then((result) => {
                if (result.isConfirmed) {
                    // Place your custom code here
                    document.getElementById('new_sale').submit();
                }

            });//end sweet alert

        }//end if condition
    });//end keydown


    document.addEventListener('keydown', function(event) {
        if (event.key === 'F2') {
            event.preventDefault();
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, ',
                cancelButtonText: 'cancel, '
            }).then((result) => {
                if (result.isConfirmed) {
                    // Place your custom code here
                    document.getElementById('suspend_bill').submit();
                }

            });//end sweet alert

        }//end if condition
    });//end keydown


    document.addEventListener('keydown', function(event) {
        if (event.key === 'F3') {
            event.preventDefault();
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, ',
                cancelButtonText: 'cancel, '
            }).then((result) => {
                if (result.isConfirmed) {
                    // Place your custom code here
                    document.getElementById('suspend_view').submit();
                }

            });//end sweet alert

        }//end if condition
    });//end keydown




    document.addEventListener('keydown', function(event) {
        if (event.key === 'F8') {
            event.preventDefault();
            
            // Place your custom code here
            document.getElementById('search_page').submit();

        }//end if condition
    });//end keydown



</script>

@endsection