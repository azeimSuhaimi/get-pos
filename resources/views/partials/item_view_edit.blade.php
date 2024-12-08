<div class="pagetitle">
    <h1>All Items</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('item')}}">All Items</a></li>
        @if (Request::is('item_view'))
                
            <li class="breadcrumb-item">view</li>
    
        @endif

        @if (Request::is('item_edit'))
        
            <li class="breadcrumb-item">Edit</li>
        
        @endif
      </ol>
    </nav>
  </div><!-- End Page Title -->

    <div class="card">

        <div class="card-header">

            @if (Request::is('item_edit'))
                
                <form  class="submit" onsubmit="confirmAndSubmit(this)" action="{{route('item.update.image')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$items->id}}">

                    <h3 class="text-center font-weight-light my-4">
                        <img id="image-preview" src="/items/{{$items->picture}} " style="width:200px; height: 160px;" alt="..." class=" img-thumbnail ">
                    </h3>

                    <div class=" mb-3">
                        <label for="file-input" class="form-label @error('file') is-invalid @enderror">Select Files Here</label>
                        <input  class="form-control" name="file" id="file-input" type="file" placeholder="" />
                        
                    </div>
                        @error('file')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Edit Image</button>
                            <button form="remove_image" type="submit"  class="btn btn-danger">Remove Image</button>
                        </div>

                </form>

                <form id="remove_image" onsubmit="confirmAndSubmit(this)" action="{{route('item.remove.image')}}" method="post" >
                    @csrf
                    <input type="hidden" name="id" value="{{$items->id}}">
                </form>
            @endif

            @if (Request::is('item_view'))
                <h3 class="text-center font-weight-light my-4">
                    <img id="image-preview" src="/items/{{$items->picture}} " style="width:200px; height: 160px;" alt="..." class=" img-thumbnail ">
                </h3>
            @endif

            
        </div>

        <div class="card-body">

            <form id="priceForm" class="row g-3" onsubmit="confirmAndSubmit(this)" action="{{route('item.update')}}" method="post">

                @csrf

                @if (Request::is('item_edit'))
                    <input type="hidden" name="id" value="{{$items->id}}">
                    <input type="hidden" name="shortcode_hidden" value="{{$items->shortcode}}">
                    
                @endif

                @if (Request::is('item_view'))
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="firstname" class="form-label">items Name</label>
                            <p class="text-danger text-uppercase">{{ $items->name }}</p>
                        </div>
                    </div>
                @endif
                @if (Request::is('item_edit'))
                    <div class="col-md-12">
                        <label for="name" class="form-label">items Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $items->name }}" name="name" id="name">
                        @error('name')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                
                @if (Request::is('item_view'))
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="items" class="form-label">items Shortcode</label>
                            <p class="text-danger text-uppercase">{{ $items->shortcode }}</p>
                        </div>
                    </div>
                @endif
                @if (Request::is('item_edit'))
                    <div class="col-md-6">
                        <label for="shortcode" class="form-label">items shortcode</label>
                        <input type="text" class="form-control @error('shortcode') is-invalid @enderror" value="{{ $items->shortcode }}" name="shortcode" id="shortcode">
                        @error('shortcode')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                                
                @if (Request::is('item_view'))
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">items Quantity</label>
                            <p class="text-danger text-uppercase">{{ $items->quantity }}</p>
                        </div>
                    </div>
                @endif
                @if (Request::is('item_edit'))
                    <div class="col-md-6">
                        <label for="quantity" class="form-label">items quantity</label>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" value="{{ $items->quantity }}" name="quantity" id="quantity">
                        @error('quantity')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                                
                @if (Request::is('item_view'))
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="cost" class="form-label">items cost</label>
                            <p class="text-danger text-uppercase">{{ $items->cost }}</p>
                        </div>
                    </div>
                @endif
                @if (Request::is('item_edit'))
                    <div class="col-md-6">
                        <label for="cost" class="form-label">items cost</label>
                        <input type="text" class="form-control @error('cost') is-invalid @enderror" value="{{ $items->cost }}" name="cost" id="cost">
                        @error('cost')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                                
                @if (Request::is('item_view'))
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="price" class="form-label">items retail price</label>
                            <p class="text-danger text-uppercase">{{ $items->price }}</p>
                        </div>
                    </div>
                @endif
                @if (Request::is('item_edit'))
                    <div class="col-md-6">
                        <label for="price" class="form-label">items retail price</label>
                        <input type="text" class="form-control @error('price') is-invalid @enderror" value="{{ $items->price }}" name="price" id="price">
                        @error('price')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                                
                @if (Request::is('item_view'))
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">items Description</label>
                            <p class="text-danger text-uppercase">{{ $items->description }}</p>
                        </div>
                    </div>
                @endif
                @if (Request::is('item_edit'))
                    <div class="col-md-12">
                        <label for="descriptions" class="form-label">items Description</label>
                        <input type="text" class="form-control @error('descriptions') is-invalid @enderror" value="{{ $items->description }}" name="descriptions" id="descriptions">
                        @error('descriptions')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                                                                
                @if (Request::is('item_view'))
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category" class="form-label">category</label>
                            <p class="text-danger text-uppercase">{{ $items->category }}</p>
                        </div>
                    </div>
                @endif
                @if (Request::is('item_edit'))
                    <div class="col-md-6">
                        <label for="category" class="form-label">Category</label>
                        <div class="form-check">
                            <input class="form-check-input @error('category') is-invalid @enderror" type="radio" name="category" id="categoryretail" value="retail"  {{$items->category === 'retail' ? 'checked' : ''}}>
                            <label class="form-check-label" for="categoryretail">
                            retail
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input @error('category') is-invalid @enderror" type="radio" name="category" id="categorynonretail" value="nonretail" {{$items->category === 'nonretail' ? 'checked' : ''}}>
                            <label class="form-check-label" for="categorynonretail">
                                non retail
                            </label>
                        </div>
                        @error('category')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                @endif



                                                
                @if (Request::is('item_view'))
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">items Status</label>
                            <p class="text-danger text-uppercase">{{$items->status == true ? 'Active':'deactive'}}</p>
                        </div>
                    </div>
                @endif

 
                @if (Request::is('item_edit'))
                
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Edit details</button>
                        <button form="item_status" type="submit" class="btn btn-danger">{{$items->status == false ? 'Active Back':'Deactive'}}</button>
                    </div>
                
                @endif


            </form>

            <script>
                document.getElementById('priceForm').addEventListener('submit', function(event) {
                    // Get the values of cost and price
                    let cost = parseFloat(document.getElementById('cost').value);
                    let price = parseFloat(document.getElementById('price').value);
                    
                    // Check if cost is greater than price or price is less than cost
                    if (cost > price) {
                      Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Cost cannot be greater than price.",
                      });
                        event.preventDefault();  // Prevent form submission
                    } else if (price < cost) {
                      Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Price cannot be less than cost.",
                      });
                        alert('');
                        event.preventDefault();  // Prevent form submission
                    }
                });
            </script>

            @if (Request::is('item_edit'))
                <form id="item_status" onsubmit="confirmAndSubmit(this)" action="{{route('item.status')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$items->id}}">
                </form>
            @endif




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