@extends('layouts.auth_layout')
 
@section('title', 'select shop page')
 
@section('content')

@include('partials.popup')

<style>
    /* Simple styling for autocomplete suggestions */
    .autocomplete-suggestions {
        border: 1px solid #ccc;
        max-height: 150px;
        overflow-y: auto;
        position: absolute;
        background-color: #fff;
        width: 300px;
    }
    .autocomplete-suggestion {
        padding: 10px;
        cursor: pointer;
    }
    .autocomplete-suggestion:hover {
        background-color: #f0f0f0;
    }
</style>


<div class="card text-bg-light">
    <div class="card-body">
      <h5 class="card-title">find your shops</h5>

      <!-- Multi Columns Form -->
      <form class="row g-3" method="get" onsubmit="confirmAndSubmit(this)" action="{{route('quick.list')}}">

        @csrf
        <div class="row mb-3">
            <label for="user_email" class="col-md-4 col-lg-3 col-form-label"> Search Shop Name <span class="text-danger">*</span></label>
            <div class="col-md-8 col-lg-9">

              <input type="hidden" name="user_id" id="email">
             
                <input type="text" id="search-input" name="search" class="form-control" autocomplete="off">
                <div id="autocomplete-suggestions" class="autocomplete-suggestions" style="display: none;"></div>


              <!-- 
                <select name="user_email" id="user_email" class="form-select col-form-control  @error('user_email') is-invalid @enderror">
                    <option selected>Open This Select Menu</option>
                    @foreach($company as $row )
                        <option value="{{$row->user_email}}" @selected(old('user_email') === $row->user_email)>{{$row->shop_name}}</option>
                    @endforeach
                </select>
              -->
              @error('user_id')
                  <span class=" invalid-feedback mt-2">{{ $message }}</span>
              @enderror
            </div>
          </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
      </form><!-- End Multi Columns Form -->

    </div>
</div>



<script>
    $(document).ready(function() {
        $('#search-input').on('keyup', function() {
            let query = $(this).val(); // Get the input value
            if (query.length > 0) { // Trigger search only if length of query > 1
                $.ajax({
                    url: "{{ route('quick.list.company') }}", // Laravel route to handle the AJAX request
                    method: 'GET',
                    data: { query: query },
                    success: function(data) {
                        // Show suggestions
                        $('#autocomplete-suggestions').empty().show();
                        if (data.length > 0) {
                            data.forEach(function(item) {
                                $('#autocomplete-suggestions').append(
                                    `<div class="autocomplete-suggestion" data-id="${item.user_id}" data-email="${item.user_id}">${item.shop_name}</div>`
                                );
                            });
                        } else {
                            $('#autocomplete-suggestions').html('<div>No results found</div>');
                        }
                    },
                    error: function() {
                        $('#autocomplete-suggestions').html('<div>Error fetching results</div>');
                    }
                });
            } else {
                $('#autocomplete-suggestions').hide(); // Hide suggestions if input is empty
            }
        });

        // Handle clicking on a suggestion
        $(document).on('click', '.autocomplete-suggestion', function() {
            let selectedText = $(this).text();
            let email = $(this).data('email');

            $('#search-input').val(selectedText); // Set input to selected suggestion
            $('#email').val(email);
            $('#autocomplete-suggestions').hide(); // Hide the suggestions
        });
    });
</script>


@endsection