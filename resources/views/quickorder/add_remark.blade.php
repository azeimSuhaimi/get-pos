@extends('layouts.quickorder_layout')
 
@section('title', 'add remark page')
 
@section('content')

@include('partials.popup')


<div class="container">
    <div class="card mb-4 mt-5">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Add Remark On Item
        </div>
        <div class="card-body">
            <form onsubmit="confirmAndSubmit(this)" action="{{route('quick.update_remark').'?user_id='.$validated['user_id']}}" method="post">
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
</div>





@endsection