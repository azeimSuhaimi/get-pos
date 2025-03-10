@extends('layouts.main_layout')
 
@section('title', 'create expense page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('expense')}}">All expense</a></li>
        <li class="breadcrumb-item active"><a href="{{route('expense.create')}}">Create expense</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

<div class="card text-bg-light mb-3">

    <div class="card-body">

        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Create New Expenses</h5>
            <p class="text-center small">Register New Expense Here</p>
        </div>
  
        <a href="{{route('expense')}}" class="btn btn-primary mb-4">BACK</a>

        <form class="submit" onsubmit="confirmAndSubmit(this)" action="{{route('expense.store')}}" method="post">
            @csrf

            <div class="form-floating mb-3 mb-md-4">
                <input class="form-control @error('description') is-invalid @enderror" name="description" id="description" type="text" value="{{ old('description') }}" />
                <label for="description">Description <span class="text-danger">*</span></label>
                @error('description')
                    <span class=" invalid-feedback mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-floating mb-3 mb-md-4">

                <input class="form-control @error('notes') is-invalid @enderror" name="notes" id="notes" type="text" value="{{ old('notes') }}" />
                <label for="notes">Notes</label>
                @error('notes')
                    <span class=" invalid-feedback mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-floating mb-3 mb-md-4">
                <input class="form-control @error('receipt') is-invalid @enderror" name="receipt" id="receipt" type="text" value="{{ old('receipt') }}" />
                <label for="receipt">Receipt</label>
                @error('receipt')
                    <span class=" invalid-feedback mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0 ">
                        <input class="form-control @error('date') is-invalid @enderror" name="date" id="date" type="date" value="{{ old('date') }}" />
                        <label for="date">Date Expense <span class="text-danger">*</span></label>
                        @error('date')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('amount') is-invalid @enderror" name="amount" id="amount" type="text" value="{{ old('amount') }}" />
                        <label for="amount">amount <span class="text-danger">*</span></label>
                        @error('amount')
                            <span class=" invalid-feedback mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                    
                </div>
            </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
        </form>

    </div>
</div>



@endsection