@extends('layouts.quickorder_layout')
 
@section('title', 'view item page')
 
@section('content')

@include('partials.popup')


        <!-- Product section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="{{asset('/items/'.$item->picture)}}" alt="..." /></div>
                    <div class="col-md-6">
                        <div class="small mb-1 text-uppercase">SKU: {{$item->shortcode}}</div>
                        <h1 class="display-5 fw-bolder text-capitalize">{{$item->name}}</h1>
                        <div class="fs-5 mb-5">
                            @if ($item->discount > 0)
                                <span class="text-decoration-line-through">RM {{$item->price}}</span>
                                <span>RM {{$item->price - ($item->price * $item->discount / 100)}}</span>
                            @else
                                <span class="text-decoration-line-through"></span>
                                <span>RM {{$item->price}}</span>
                            @endif

                        </div>
                        <p class="lead text-uppercase">{{$item->description}}</p>
                        <div class="d-flex">
                            <!-- 
                            <input class="form-control text-center me-3" id="inputQuantity" type="num" value="1" style="max-width: 3rem" />
                            -->
                            <a class="btn btn-outline-dark flex-shrink-0" href="{{route('quick.add.item').'?user_id='.$validated['user_id'].'&shortcode='.$item->shortcode}}">
                                <i class="bi-cart-fill me-1"></i>
                                Add to cart
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>





@endsection