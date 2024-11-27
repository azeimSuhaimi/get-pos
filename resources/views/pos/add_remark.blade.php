@extends('layouts.main_layout')
 
@section('title', 'POS page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <h1>POINT OF SALE</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('pos')}}">POS</a></li>
        <li class="breadcrumb-item active"><a href="">REMARK</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->


  <div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Add Remark On Item
    </div>
    <div class="card-body">
        <form onsubmit="confirmAndSubmit(this)" action="{{route('pos.update.remark')}}" method="post">
            @csrf
            <input type="hidden" name="rowid"  value="{{$rowid}}">
            <input type="hidden" name="description"  value="{{$remark->options->description}}">
            <input type="hidden" name="cost"  value="{{$remark->options->cost}}">
            <input type="hidden" name="category"  value="{{$remark->options->category}}">
            <div class="row mb-3">
                <label for="remark" class="col-sm-2 col-form-label">Remark</label>
                <div class="col-sm-10">
                    <textarea name="remark" class="form-control @error('remark') is-invalid @enderror" style="height: 100px">{{$remark->options->remark}}</textarea>
                    @error('remark')
                        <span class=" invalid-feedback mt-2">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">submit</button>
        </form>

    </div>
</div>



@endsection