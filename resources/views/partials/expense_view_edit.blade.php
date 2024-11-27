<div class="pagetitle">
    <h1>All Expense</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('expense')}}">All Expense</a></li>
        @if (Request::is('expense_view'))
                
            <li class="breadcrumb-item">view</li>
    
        @endif

        @if (Request::is('expense_edit'))
        
            <li class="breadcrumb-item">Edit</li>
        
        @endif
      </ol>
    </nav>
  </div><!-- End Page Title -->



  <div class="card">

    <div class="card-header">


        
    </div>

    <div class="card-body">

        <form class="row g-3" onsubmit="confirmAndSubmit(this)" action="{{route('expense.update')}}" method="post">

            @csrf

            @if (Request::is('expense_edit'))
                <input type="hidden" name="id" value="{{$expense->id}}">
            @endif

            @if (Request::is('expense_view'))
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <p class="text-danger text-uppercase">{{ $expense->description }}</p>
                    </div>
                </div>
            @endif
            @if (Request::is('expense_edit'))
                <div class="col-md-12">
                    <label for="description" class="form-label">description</label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" value="{{ $expense->description }}" name="description" id="description">
                    @error('description')
                        <span class=" invalid-feedback mt-2">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            
            @if (Request::is('expense_view'))
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <p class="text-danger text-uppercase">{{ $expense->notes }}</p>
                    </div>
                </div>
            @endif
            @if (Request::is('expense_edit'))
                <div class="col-md-12">
                    <label for="notes" class="form-label">Notes</label>
                    <input type="text" class="form-control @error('notes') is-invalid @enderror" value="{{ $expense->notes }}" name="notes" id="notes">
                    @error('notes')
                        <span class=" invalid-feedback mt-2">{{ $message }}</span>
                    @enderror
                </div>
            @endif

                            
            @if (Request::is('expense_view'))
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="receipt" class="form-label">receipt</label>
                        <p class="text-danger text-uppercase">{{ $expense->receipt }}</p>
                    </div>
                </div>
            @endif
            @if (Request::is('expense_edit'))
                <div class="col-md-12">
                    <label for="receipt" class="form-label">receipt</label>
                    <input type="text" class="form-control @error('receipt') is-invalid @enderror" value="{{ $expense->receipt }}" name="receipt" id="receipt">
                    @error('receipt')
                        <span class=" invalid-feedback mt-2">{{ $message }}</span>
                    @enderror
                </div>
            @endif

                            
            @if (Request::is('expense_view'))
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="date" class="form-label">date Expense</label>
                        <p class="text-danger text-uppercase">{{ $expense->date }}</p>
                    </div>
                </div>
            @endif
            @if (Request::is('expense_edit'))
                <div class="col-md-6">
                    <label for="date" class="form-label">date expense</label>
                    <input type="date" class="form-control @error('date') is-invalid @enderror" value="{{ $expense->date }}" name="date" id="date">
                    @error('date')
                        <span class=" invalid-feedback mt-2">{{ $message }}</span>
                    @enderror
                </div>
            @endif



                            
            @if (Request::is('expense_view'))
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="amount" class="form-label">amount</label>
                        <p class="text-danger text-uppercase">{{ $expense->amount }}</p>
                    </div>
                </div>
            @endif
            @if (Request::is('expense_edit'))
                <div class="col-md-6">
                    <label for="amount" class="form-label">amount</label>
                    <input type="text" class="form-control @error('amount') is-invalid @enderror" value="{{ $expense->amount }}" name="amount" id="amount">
                    @error('amount')
                        <span class=" invalid-feedback mt-2">{{ $message }}</span>
                    @enderror
                </div>
            @endif


                                                            


                                            












            @if (Request::is('expense_edit'))
            
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Edit details</button>
                    
                </div>
            
            @endif


        </form>




    </div>
</div>