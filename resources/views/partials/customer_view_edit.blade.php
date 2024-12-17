<div class="pagetitle">
    
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('customer')}}">All Customer</a></li>
        @if (Request::is('customer_view'))
                
            <li class="breadcrumb-item">view</li>
    
        @endif

        @if (Request::is('customer_edit'))
        
            <li class="breadcrumb-item">Edit</li>
        
        @endif
      </ol>
    </nav>
  </div><!-- End Page Title -->



  <div class="card">



    <div class="card-body text-bg-light">



        <div class="row">
            <div class="col-10">
              <h1 class="card-title text fs-3">{{ $customer->name }}</h1>
            </div>
            <div class="col-2 mt-3">
              <a href="{{route('customer')}}" class="btn btn-primary ">BACK</a>
            </div>
          </div>

        <form class="row g-3" onsubmit="confirmAndSubmit(this)" action="{{route('customer.update')}}" method="post">

            @csrf

            @if (Request::is('customer_edit'))
                <input type="hidden" name="id" value="{{$customer->id}}">
            @endif

            @if (Request::is('customer_view'))
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="name" class="form-label">Customer Name</label>
                        <p class="text-danger text-uppercase">{{ $customer->name }}</p>
                    </div>
                </div>
            @endif
            @if (Request::is('customer_edit'))
                <div class="col-md-12">
                    <label for="name" class="form-label">Customer Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $customer->name }}" name="name" id="name">
                    @error('name')
                        <span class=" invalid-feedback mt-2">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            
            @if (Request::is('customer_view'))
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">Customer Email</label>
                        <p class="text-danger text-uppercase">{{ $customer->email }}</p>
                    </div>
                </div>
            @endif
            @if (Request::is('customer_edit'))
                <div class="col-md-6">
                    <label for="email" class="form-label">Customer Email <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" value="{{ $customer->email }}" name="email" id="email">
                    @error('email')
                        <span class=" invalid-feedback mt-2">{{ $message }}</span>
                    @enderror
                </div>
            @endif

                            
            @if (Request::is('customer_view'))
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="phone" class="form-label">Customer Phone</label>
                        <p class="text-danger text-uppercase">{{ $customer->phone }}</p>
                    </div>
                </div>
            @endif
            @if (Request::is('customer_edit'))
                <div class="col-md-6">
                    <label for="phone" class="form-label">Customer Phone <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ $customer->phone }}" name="phone" id="phone">
                    @error('phone')
                        <span class=" invalid-feedback mt-2">{{ $message }}</span>
                    @enderror
                </div>
            @endif

                            
            @if (Request::is('customer_view'))
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="ic" class="form-label">Customer I.C</label>
                        <p class="text-danger text-uppercase">{{ $customer->ic }}</p>
                    </div>
                </div>
            @endif
            @if (Request::is('customer_edit'))
                <div class="col-md-6">
                    <label for="ic" class="form-label">Customer I.C <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('ic') is-invalid @enderror" value="{{ $customer->ic }}" name="ic" id="ic">
                    @error('ic')
                        <span class=" invalid-feedback mt-2">{{ $message }}</span>
                    @enderror
                </div>
            @endif



                            
            @if (Request::is('customer_view'))
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="address" class="form-label">Customer Address</label>
                        <p class="text-danger text-uppercase">{{ $customer->address }}</p>
                    </div>
                </div>
            @endif
            @if (Request::is('customer_edit'))
                <div class="col-md-12">
                    <label for="address" class="form-label">Customer Address</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" value="{{ $customer->address }}" name="address" id="address">
                    @error('address')
                        <span class=" invalid-feedback mt-2">{{ $message }}</span>
                    @enderror
                </div>
            @endif


                                                            


                                            


                                            
            @if (Request::is('customer_view'))
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">customer Point</label>
                        <p class="text-danger text-uppercase">{{$customer->point }}</p>
                    </div>
                </div>
            @endif









            @if (Request::is('customer_edit'))
            
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Edit details</button>
                    
                </div>
            
            @endif


        </form>




    </div>
</div>