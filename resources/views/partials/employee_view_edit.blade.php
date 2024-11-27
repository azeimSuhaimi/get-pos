<div class="pagetitle">
    <h1>All Employee</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('employee')}}">All Employee</a></li>
        @if (Request::is('employee_view'))
                
            <li class="breadcrumb-item">view</li>
    
        @endif

        @if (Request::is('employee_edit'))
        
            <li class="breadcrumb-item">Edit</li>
        
        @endif
      </ol>
    </nav>
  </div><!-- End Page Title -->

    <div class="card">

        <div class="card-header">

            @if (Request::is('employee_edit'))
                
                <form class="submit" onsubmit="confirmAndSubmit(this)" action="{{route('employee.update.image')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$employee->id}}">

                    <h3 class="text-center font-weight-light my-4">
                        <img id="image-preview" src="/profile/{{$employee->picture}} " style="width:200px; height: 160px;" alt="..." class=" img-thumbnail ">
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

                <form id="remove_image" onsubmit="confirmAndSubmit(this)" action="{{route('employee.remove.image')}}" method="post" >
                    @csrf
                    <input type="hidden" name="id" value="{{$employee->id}}">
                </form>
            @endif

            @if (Request::is('employee_view'))
                <h3 class="text-center font-weight-light my-4">
                    <img id="image-preview" src="/profile/{{$employee->picture}} " style="width:200px; height: 160px;" alt="..." class=" img-thumbnail ">
                </h3>
            @endif

            
        </div>

        <div class="card-body">

            <form class="row g-3" onsubmit="confirmAndSubmit(this)" action="{{route('employee.update')}}" method="post">

                @csrf

                @if (Request::is('employee_edit'))
                    <input type="hidden" name="id" value="{{$employee->id}}">
                    <input type="hidden" name="email_hidden" value="{{$employee->email}}">
                    <input type="hidden" name="work_id_hidden" value="{{$employee->work_id}}">
                    <input type="hidden" name="ic_hidden" value="{{$employee->ic}}">
                    
                @endif

                @if (Request::is('employee_view'))
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="firstname" class="form-label">Employee Name</label>
                            <p class="text-danger text-uppercase">{{ $employee->name }}</p>
                        </div>
                    </div>
                @endif
                @if (Request::is('employee_edit'))
                    <div class="col-md-12">
                        <label for="name" class="form-label">Employee Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $employee->name }}" name="name" id="name">
                        @error('name')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                
                @if (Request::is('employee_view'))
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="firstname" class="form-label">Employee Email</label>
                            <p class="text-danger text-uppercase">{{ $employee->email }}</p>
                        </div>
                    </div>
                @endif
                @if (Request::is('employee_edit'))
                    <div class="col-md-6">
                        <label for="email" class="form-label">Employee Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" value="{{ $employee->email }}" name="email" id="email">
                        @error('email')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                                
                @if (Request::is('employee_view'))
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label">Employee Phone</label>
                            <p class="text-danger text-uppercase">{{ $employee->phone }}</p>
                        </div>
                    </div>
                @endif
                @if (Request::is('employee_edit'))
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Employee Phone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ $employee->phone }}" name="phone" id="phone">
                        @error('phone')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                                
                @if (Request::is('employee_view'))
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="ic" class="form-label">Employee I.C</label>
                            <p class="text-danger text-uppercase">{{ $employee->ic }}</p>
                        </div>
                    </div>
                @endif
                @if (Request::is('employee_edit'))
                    <div class="col-md-6">
                        <label for="ic" class="form-label">Employee I.C</label>
                        <input type="text" class="form-control @error('ic') is-invalid @enderror" value="{{ $employee->ic }}" name="ic" id="ic">
                        @error('ic')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                                
                @if (Request::is('employee_view'))
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="firstname" class="form-label">Employee Work I.D</label>
                            <p class="text-danger text-uppercase">{{ $employee->work_id }}</p>
                        </div>
                    </div>
                @endif
                @if (Request::is('employee_edit'))
                    <div class="col-md-6">
                        <label for="work_id" class="form-label">Employee Work I.D</label>
                        <input type="text" class="form-control @error('work_id') is-invalid @enderror" value="{{ $employee->work_id }}" name="work_id" id="work_id">
                        @error('work_id')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                                
                @if (Request::is('employee_view'))
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="address" class="form-label">Employee Address</label>
                            <p class="text-danger text-uppercase">{{ $employee->address }}</p>
                        </div>
                    </div>
                @endif
                @if (Request::is('employee_edit'))
                    <div class="col-md-12">
                        <label for="address" class="form-label">Employee Address</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" value="{{ $employee->address }}" name="address" id="address">
                        @error('address')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                                
                @if (Request::is('employee_view'))
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="address2" class="form-label">Employee Second Address</label>
                            <p class="text-danger text-uppercase">{{ $employee->address2 }}</p>
                        </div>
                    </div>
                @endif
                @if (Request::is('employee_edit'))
                    <div class="col-md-12">
                        <label for="address2" class="form-label">Employee Second Address</label>
                        <input type="text" class="form-control @error('address2') is-invalid @enderror" value="{{ $employee->address2 }}" name="address2" id="address2">
                        @error('address2')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                                                
                @if (Request::is('employee_view'))
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="birthday" class="form-label">Employee Birthday</label>
                            <p class="text-danger text-uppercase">{{ $employee->birthday }}</p>
                        </div>
                    </div>
                @endif
                @if (Request::is('employee_edit'))
                    <div class="col-md-6">
                        <label for="birthday" class="form-label">Employee Birthday</label>
                        <input type="date" class="form-control @error('birthday') is-invalid @enderror" value="{{ $employee->birthday  }}" name="birthday" id="birthday">
                        @error('birthday')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                                                                
                @if (Request::is('employee_view'))
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="gender" class="form-label">Employee Gender</label>
                            <p class="text-danger text-uppercase">{{ $employee->gender }}</p>
                        </div>
                    </div>
                @endif
                @if (Request::is('employee_edit'))
                    <div class="col-md-6">
                        <label for="gender" class="form-label">Gender</label>
                        <div class="form-check">
                            <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="gender" value="male"  {{$employee->gender === 'male' ? 'checked' : ''}}>
                            <label class="form-check-label" for="gender">
                            Male
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="gender" value="female" {{$employee->gender === 'female' ? 'checked' : ''}}>
                            <label class="form-check-label" for="gender">
                                Female
                            </label>
                        </div>
                        @error('gender')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                                                
                @if (Request::is('employee_view'))
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="position" class="form-label">Employee Position</label>
                            <p class="text-danger text-uppercase">{{ $employee->position }}</p>
                        </div>
                    </div>
                @endif
                @if (Request::is('employee_edit'))
                    <div class="col-md-6">
                        <label for="inputState" class="form-label">Position</label>
                        <select name="position" class="form-select @error('position') is-invalid @enderror">
                            <option value="" selected>Choose...</option>
                            <option value="staff" @selected($employee->position === 'staff')>Staff</option>
                            <option value="cashier" @selected($employee->position === 'cashier')>Cashier</option>
                            <option value="retail" @selected($employee->position === 'retail')>Retail</option>
                            <option value="supervisor" @selected($employee->position === 'supervisor')>supervisor</option>
                        </select>
                        @error('position')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                                                
                @if (Request::is('employee_view'))
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="firstname" class="form-label">Employee Status</label>
                            <p class="text-danger text-uppercase">{{$employee->status == true ? 'Active':'Resign'}}</p>
                        </div>
                    </div>
                @endif


                                                
                @if (Request::is('employee_view'))
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="date_register" class="form-label">Employee Date Register</label>
                            <p class="text-danger text-uppercase">{{ $employee->date_register }}</p>
                        </div>
                    </div>
                @endif





                @if (Request::is('employee_edit'))
                
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Edit details</button>
                        <button form="employee_status" type="submit" class="btn btn-danger">{{$employee->status == false ? 'Active Back':'Resign'}}</button>
                        
                    </div>
                
                @endif


            </form>

            @if (Request::is('employee_edit'))
                <form id="employee_status" onsubmit="confirmAndSubmit(this)" action="{{route('employee.status')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$employee->id}}">
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