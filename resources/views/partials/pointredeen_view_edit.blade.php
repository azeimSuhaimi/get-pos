<div class="pagetitle">
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('pointredeen')}}">All Items</a></li>
        @if (Request::is('pointredeen_view'))
                
            <li class="breadcrumb-item">view</li>
    
        @endif

        @if (Request::is('pointredeen_edit'))
        
            <li class="breadcrumb-item">Edit</li>
        
        @endif
      </ol>
    </nav>
  </div><!-- End Page Title -->

    <div class="card text-bg-light">

        <div class="card-header">

            <div class="row">
                <div class="col-10">
                  <h1 class="card-title text fs-3">{{ $items->name }}</h1>
                </div>
                <div class="col-2 mt-3">
                  <a href="{{route('pointredeen')}}" class="btn btn-primary ">BACK</a>
                </div>
              </div>

              <!-- 
            @if (Request::is('pointredeen_edit'))
                
                <form  class="submit" onsubmit="confirmAndSubmit(this)" action="" method="post" enctype="multipart/form-data">
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

                <form id="remove_image" onsubmit="confirmAndSubmit(this)" action="" method="post" >
                    @csrf
                    <input type="hidden" name="id" value="{{$items->id}}">
                </form>
            @endif

            @if (Request::is('pointredeen_view'))
                <h3 class="text-center font-weight-light my-4">
                    <img id="image-preview" src="/items/{{$items->picture}} " style="width:200px; height: 160px;" alt="..." class=" img-thumbnail ">
                </h3>
            @endif
-->
            
        </div>

        <div class="card-body">

            <form id="priceForm" class="row g-3" onsubmit="confirmAndSubmit(this)" action="{{route('pointredeen.update')}}" method="post">

                @csrf

                @if (Request::is('pointredeen_edit'))
                    <input type="hidden" name="id" value="{{$items->id}}">
                @endif

                @if (Request::is('pointredeen_view'))
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="firstname" class="form-label">items Name</label>
                            <p class="text-danger text-uppercase">{{ $items->name }}</p>
                        </div>
                    </div>
                @endif
                @if (Request::is('pointredeen_edit'))
                    <div class="col-md-12">
                        <label for="name" class="form-label">items Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $items->name }}" name="name" id="name">
                        @error('name')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                                
                @if (Request::is('pointredeen_view'))
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="point" class="form-label">items Point</label>
                            <p class="text-danger text-uppercase">{{ $items->point }}</p>
                        </div>
                    </div>
                @endif
                @if (Request::is('pointredeen_edit'))
                    <div class="col-md-6">
                        <label for="point" class="form-label">items point <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('point') is-invalid @enderror" value="{{ $items->point }}" name="point" id="point">
                        @error('point')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
            
                @if (Request::is('pointredeen_view'))
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">items Description</label>
                            <p class="text-danger text-uppercase">{{ $items->description }}</p>
                        </div>
                    </div>
                @endif
                @if (Request::is('pointredeen_edit'))
                    <div class="col-md-12">
                        <label for="descriptions" class="form-label">items Description <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('descriptions') is-invalid @enderror" value="{{ $items->description }}" name="descriptions" id="descriptions">
                        @error('descriptions')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                @endif


                                                
                @if (Request::is('pointredeen_view'))
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">items Status</label>
                            <p class="text-danger text-uppercase">{{$items->status == true ? 'Active':'deactive'}}</p>
                        </div>
                    </div>
                @endif

 
                @if (Request::is('pointredeen_edit'))
                
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Edit details</button>
                        <button form="item_status" type="submit" class="btn btn-danger">{{$items->status == false ? 'Active Back':'Deactive'}}</button>
                        <button form="item_delete" type="submit" class="btn btn-danger">Delete</button>
                    </div>
                
                @endif


            </form>

            @if (Request::is('pointredeen_edit'))
                <form id="item_status" onsubmit="confirmAndSubmit(this)" action="{{route('pointredeen.status')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$items->id}}">
                </form>

                <form id="item_delete" onsubmit="confirmAndSubmit(this)" action="{{route('pointredeen.delete')}}" method="post">
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