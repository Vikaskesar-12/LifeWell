@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Post</h5>
    <div class="card-body">
    <form method="post" action="{{route('settings.update')}}" enctype="multipart/form-data">
        @csrf 
        {{-- @method('PATCH') --}}
        {{-- {{dd($data)}} --}}
        <input type="hidden" name="id" value="{{$data ? $data->id : ''}}">
        <div class="form-group">
          <label for="short_des" class="col-form-label"> About Us <span class="text-danger">*</span></label>
          <textarea class="form-control" id="quote" name="aboutUs">{{$data ? $data->about_us : ''}}</textarea>
          @error('short_des')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="description" class="col-form-label">privacy Policy <span class="text-danger">*</span></label>
          <textarea class="form-control" id="description" name="privacy_policy">{{$data ? $data->privacy_policy : ''}}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="description" class="col-form-label">Return Policy <span class="text-danger">*</span></label>
          <textarea class="form-control" id="terms" name="return_policy">{{$data ? $data->return_policy : ''}}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
       
        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Logo <span class="text-danger">*</span></label>
          <div class="input-group">
          <input id="thumbnail1" class="form-control" type="file" accept="image/*" name="logo">
        </div>
        @if($data && $data->logo)
          <div class="field item form-group" >
              <label class="col-form-label col-md-3 col-sm-3 label-align"><span class="required"></span></label>
              <div class="col-md-6 col-sm-6">
                  <div class="image-preview mt-3" id="imagePreview">
                      <div class="image-container" style="position: relative; display: inline-block; margin: 5px;">
                          <img src="{{ asset($data->logo) }}" id="logo-preview" class="ml-2" style="height:100px; width:100px;">
                      </div>
                  </div>
              </div>

          </div>
          @endif
        <div id="holder1" style="margin-top:15px;max-height:100px;"></div>

          @error('logo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        
       

        <div class="form-group">
          <label for="address" class="col-form-label">Address <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="address" required value="{{$data ? $data->address : ''}}">
          @error('address')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="email" class="col-form-label">Email <span class="text-danger">*</span></label>
          <input type="email" class="form-control" name="email" required value="{{$data ? $data->email : ''}}">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="phone" class="col-form-label">Phone Number <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="phone" required value="{{$data ? $data->phone : ''}}">
          @error('phone')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Update</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

@endpush
@push('scripts')
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $(document).ready(function() {
    $('#summary').summernote({
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
    });

    $(document).ready(function() {
      $('#quote').summernote({
        placeholder: "Write about us.....",
          tabsize: 2,
          height: 100
      });
    });
    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Write detail  pravicy policy.....",
          tabsize: 2,
          height: 150
      });
    });
    $(document).ready(function() {
      $('#terms').summernote({
        placeholder: "Write return policy.....",
          tabsize: 2,
          height: 150
      });
    });
</script>
<script>
    $(document).on('change', '#thumbnail1', function(event) {
    const files = Array.from(event.target.files);
    console.log('files', files);

    if (files.length > 0) {
        const file = files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            $('#logo-preview').attr('src', e.target.result);
        };

        reader.readAsDataURL(file);
    }
});
$(document).on('change', '#thumbnail2', function(event) {
    const files = Array.from(event.target.files);
    console.log('files', files);

    if (files.length > 0) {
        const file = files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            $('#photo-preview').attr('src', e.target.result);
        };

        reader.readAsDataURL(file);
    }
});
</script>
@endpush