@extends('layouts.main_layout')
 
@section('title', 'expense page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <h1>All expense</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{route('expense')}}">All expense</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card text-bg-light">
          <div class="card-body">
            <h5 class="card-title">All Expense</h5>

            <a href="{{route('expense.create')}}" class="btn btn-primary ">Create</a>

            <!-- Table with stripped rows -->
            <table class="table datatable table-hover">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Date Expense</th>
                    <th>Description.</th>
                    <th>Amount</th>
                    <th>Action</th>
                    <th></th>
                    <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($expense as $exp)
                  
                  <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$exp->date}}</td>
                      <td>{{$exp->description}}</td>
                      <td>{{$exp->amount}}</td>
                      <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                          <a href="{{route('expense.edit')}}?id={{$exp->id}}" class="btn btn-primary ">Edit Details</a>
                          <a href="{{route('expense.view')}}?id={{$exp->id}}" class="btn btn-info ">view Details</a>
                          <form onsubmit="confirmAndSubmit(this)"  action="{{route('expense.remove')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$exp->id}}">
                            <button type="submit" class="btn btn-danger ">Remove</button>
                          </form>
                        </div>
                            
                      </td>
                      <td>
                        
                      </td>
                      <td>

                      </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <!-- End Table with stripped rows -->

          </div>
        </div>

      </div>
    </div>
  </section>

@endsection