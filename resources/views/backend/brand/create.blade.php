@extends('backend.layouts.master')
@section('title', 'LIFWEL || Brand Create')
@section('main-content')

    <div class="card">
        <h5 class="card-header">Add Brand</h5>
        <div class="card-body">
            <form method="post" action="{{ route('brand.store') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Enter title"
                        value="{{ old('title') }}" class="form-control">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- <div class="form-group">
                      <label for="cat_id">Category <span class="text-danger">*</span></label>
                      <select name="category_id" id="cat_id" class="form-control">
                          <option value="">--Select any category--</option>
                          @foreach ($category as $key => $cat_data)
    <option value='{{ $cat_data->id }}'>{{ $cat_data->title_en }}</option>
    @endforeach
                      </select>
                      @error('category_id')
        <span class="text-danger">{{ $message }}</span>
    @enderror
                    </div> -->

                <div class="form-group">
                    <label for="size">Category</label>
                    <select name="category_id[]" class="form-control selectpicker" multiple data-live-search="true">
                        <option value="">--Select any Category--</option>
                        @foreach ($category as $key => $cat_data)
                            <option value='{{ $cat_data->id }}'>{{ $cat_data->title_en }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
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
@endpush
