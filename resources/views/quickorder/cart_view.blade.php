@extends('layouts.quickorder_layout')
 
@section('title', 'view cart page')
 
@section('content')

@include('partials.popup')



<div class="container">

    <div class="row">
        <div class="div col-md-8">
            <div class="card mb-4 mt-5">
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
                                <th>#</th>
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
                                        <td>
                                            <div class="btn-group m-0 p-0" role="group">

                                                <form action="{{route('quick.update_quantity_page')}}" method="get">
                                                    @csrf
                                                    <input type="hidden" name="user_email"  value="{{$validated['user_email']}}">
                                                    <input type="hidden" name="id" value="{{$row->id}}">
                                                    <input type="hidden" name="rowid" value="{{$row->rowId}}">
                                                    <button type="submit" class="btn btn-warning"><i class="bi bi-plus"></i></button>
                                                </form>
                                                <form action="{{route('quick.add_remark')}}" method="get">
                                                    @csrf
                                                    <input type="hidden" name="user_email"  value="{{$validated['user_email']}}">
                                                    <input type="hidden" name="rowid"  value="{{$row->rowId}}">
                                                    
                                                    <button type="submit" class="btn btn-info"><i class="bi bi-pencil"></i></button>
                                                </form>
                                                <form  action="{{route('quick.remove.item').'?user_email='.$validated['user_email']}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="rowid"  value="{{$row->rowId}}">
                                                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </div>
                                            
                                        </td>
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
                <div class="card-footer text-center d-flex">

            
                    
                </div>
            </div>

        </div>
        <div class="div col-md-4 mb-5">
            <div class="card text-bg-light mt-5">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Bill Payment Method
                </div>
                <div class="card-body">
                  <h5 class="card-title">   </h5>
            
                  <!-- Multi Columns Form -->
                  <form class="" method="post" onsubmit="confirmAndSubmit(this)" action="{{route('quick.cart.checkout').'?user_email='.$validated['user_email']}}">
            
                    @csrf
                    <div class="row mb-3">
                        <label for="user_email" class="col-md-4 col-lg-3 col-form-label">your Email <span class="text-danger">*</span></label>
                        <div class="col-md-8 col-lg-9">
    
                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror " id="email" value="{{ old('email') }}" >
                            
                            @error('email')
                                <span class=" invalid-feedback mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                      </div>
            
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                  </form><!-- End Multi Columns Form -->
            
                </div>
            </div>
        </div>
    </div>
</div>




@endsection