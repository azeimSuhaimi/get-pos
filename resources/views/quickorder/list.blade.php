@extends('layouts.quickorder_layout')
 
@section('title', 'list item page')
 
@section('content')

@include('partials.popup')



        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    
                    @foreach ($item as $row )
                        <div class="col mb-5">
                            <div class="card h-100">
                                <!-- Product image-->
                                <img class="card-img-top" src="{{asset('/items/'.$row->picture)}}" alt="..." />
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder">{{$row->name}}</h5>
                                        <!-- Product price-->
                                        RM {{$row->price}}
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto mb-2" href="{{route('quick.view').'?user_email='.$validated['user_email'].'&shortcode='.$row->shortcode}}">View Item</a></div>
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="{{route('quick.add.item').'?user_email='.$validated['user_email'].'&shortcode='.$row->shortcode}}">Add to cart</a></div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>


@endsection