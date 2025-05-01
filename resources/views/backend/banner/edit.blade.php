@extends('backend.layouts.master')
@section('title','LifeWell || Banner Edit')
@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Banner</h5>
    <div class="card-body">
      <form method="post" action="{{route('banner.update',$banner->id)}}" enctype="multipart/form-data">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="title" placeholder="Enter title"  value="{{$banner->title}}" class="form-control">
        @error('title')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Url <span class="text-danger">*</span></label>
          <input id="inputTitle" type="url" name="url" placeholder="Enter url"  value="{{old('url',$banner->url)}}" class="form-control">
          @error('url')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="parent_id">Position</label>
          <select name="position" class="form-control">
              <option value="">--Select postion --</option>
              <option value="top" {{$banner->position == 'top' ? 'selected' : ''}}>top</option>
              <option value="bottom" {{$banner->position == 'bottom' ? 'selected' : ''}}>bottom</option>
          </select>
          @error('position')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputDesc" class="col-form-label">Description</label>
          <textarea class="form-control" id="description" name="description">{{$banner->description}}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
       

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Button Text <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="button_text" placeholder="Enter button text"  value="{{old('button_text',$banner->button_text)}}" class="form-control">
          @error('button_text')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
        <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
        <div class="input-group">
          <input id="thumbnail" class="form-control" type="file" name="photo" value="{{$banner->photo}}">
        </div>
       
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        @if($banner->photo)
          <div class="field item form-group" >
              <label class="col-form-label col-md-3 col-sm-3 label-align"><span class="required"></span></label>
              <div class="col-md-6 col-sm-6">
                  <div class="image-preview mt-3" id="imagePreview">
                      <div class="image-container" style="position: relative; display: inline-block; margin: 5px;">
                          <img src="{{ asset($banner->photo) }}" id="testimonial-preview" class="ml-2" style="height:100px; width:100px;">
                      </div>
                  </div>
              </div>

          </div>
          @endif
          <div id="holder" style="margin-top:15px;max-height:100px;"></div>
        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
            <option value="active" {{(($banner->status=='active') ? 'selected' : '')}}>Active</option>
            <option value="inactive" {{(($banner->status=='inactive') ? 'selected' : '')}}>Inactive</option>
          </select>
          @error('status')
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
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
    $('#description').summernote({
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
    });
</script>
<script>
    $(document).on('change', '#thumbnail', function(event) {
    const files = Array.from(event.target.files);
    console.log('files', files);

    if (files.length > 0) {
        const file = files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            $('#testimonial-preview').attr('src', e.target.result);
        };

        reader.readAsDataURL(file);
    }
});
</script>
@endpush