@extends('layouts.main_layout')
 
@section('title', 'view waste page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('waste')}}">All WASTE</a></li>        
        <li class="breadcrumb-item">VIEW</li>
    

      </ol>
    </nav>
  </div><!-- End Page Title -->

    <div class="card text-bg-light">

        <div class="card-header">

            <div class="row">

                <div class="col-2 mt-3">
                  <a href="{{route('waste')}}" class="btn btn-primary ">BACK</a>
                </div>
              </div>
  
        </div>

        <div class="card-body">



                <form class="row g-3">

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="firstname" class="form-label">WASTE Name Item</label>
                            <p class="text-danger text-uppercase">{{ $waste->name }}</p>
                        </div>
                    </div>

                
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="items" class="form-label">items Shortcode</label>
                            <p class="text-danger text-uppercase">{{ $waste->shortcode }}</p>
                        </div>
                    </div>

                                

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">items Quantity</label>
                            <p class="text-danger text-uppercase">{{ $waste->quantity }}</p>
                        </div>
                    </div>
                


                                

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="cost" class="form-label">items cost</label>
                            <p class="text-danger text-uppercase">{{ $waste->cost }}</p>
                        </div>
                    </div>
                


                                

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="price" class="form-label">items retail price</label>
                            <p class="text-danger text-uppercase">{{ $waste->price }}</p>
                        </div>
                    </div>


                                

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="description" class="form-label">items Description</label>
                            <p class="text-danger text-uppercase">{{ $waste->description }}</p>
                        </div>
                    </div>



                                                                

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category" class="form-label">category</label>
                            <p class="text-danger text-uppercase">{{ $waste->category }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="items" class="form-label">Reason</label>
                            <p class="text-danger text-uppercase">{{ $waste->reason }}</p>
                        </div>
                    </div>

                                

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Remark</label>
                            <p class="text-danger text-uppercase">{{ $waste->remark }}</p>
                        </div>
                    </div>





                </form>









        </div>
    </div>





























    <script>
        const fileInput = document.getElementById('file-input');
        const imagePreview = document.getElementById('image-preview');
        
        fileInput.addEventListener('change', function () {
          const file = fileInput.files[0];
          if (file) {
            const reader = new FileReader();
            reader.onload = function () {
              imagePreview.src = reader.result;
              //imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
          } else {
            //imagePreview.style.display = 'none';
          }
        });
        
        
        
    </script>

@endsection