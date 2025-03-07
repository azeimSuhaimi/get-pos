@extends('layouts.main_layout')
 
@section('title', 'list quick order page')
 
@section('content')

@include('partials.popup')


<div class="pagetitle">
    <h1>All Item</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('item')}}">All Items</a></li>
        <li class="breadcrumb-item active"><a href="{{route('item')}}">list quickorder Items</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card text-bg-light">
          <div class="card-body">
            <h5 class="card-title"></h5>

            <a href="{{route('item')}}" class="btn btn-primary mb-3">back </a>

            <!-- Table with stripped rows -->
            <table class="table datatable table-hover ">
              <thead >
                <tr>
                    <th>No</th>
                    <th>Image</th>
                    <th>Shortcode</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>quickorder status</th>
                    
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $item)
                  
                  <tr>
                      <td>{{$loop->iteration}}</td>
                      <td><img src="{{asset('items/'.$item->picture)}}" style="width:50px; height: 40px;"></td>
                      <td>{{$item->shortcode}}</td>
                      <td>{{$item->name}}</td>

                      <td><span class="badge rounded-pill bg-{{$item->status == true ? 'success':'danger'}}">{{$item->status == true ? 'Active':'Deactive'}}</span></td>
                      <td>
                        <a href="{{route('item.list_quickorder.status',['id' => $item->id])}}" class="btn btn-{{$item->quickorder_status == 'true' ? 'success':'danger'}} ">{{$item->quickorder_status == 'true' ? 'open':'close'}}</a>    
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