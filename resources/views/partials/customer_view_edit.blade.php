<div class="pagetitle">
    <h1>All Customer</h1>
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

    <div class="card-header">


        
    </div>

    <div class="card-body">

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
                    <label for="name" class="form-label">Customer Name</label>
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
                    <label for="email" class="form-label">Customer Email</label>
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
                    <label for="phone" class="form-label">Customer Phone</label>
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
                    <label for="ic" class="form-label">Customer I.C</label>
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