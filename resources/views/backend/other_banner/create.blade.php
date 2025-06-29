@extends('backend.layouts.master')

@section('title', 'LIFWEL || Banner Create')

@section('main-content')

    <div class="card">
        <h5 class="card-header">Add Banner</h5>
        <div class="card-body">
            <form method="post" action="{{ route('banners.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Enter title"
                        value="{{ old('title') }}" class="form-control">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Url <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="url" name="url" placeholder="Enter url" value="{{ old('url') }}"
                        class="form-control">
                    @error('url')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" id='parent_cat_div'>
                    <label for="parent_id">Category</label>
                    <select name="category_id" class="form-control">
                        <option value="">--Select any category--</option>
                        @foreach ($parent_cats as $key => $parent_cat)
                            <option value='{{ $parent_cat->id }}'>{{ $parent_cat->title }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="inputDesc" class="col-form-label">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Button Text <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="button_text" placeholder="Enter button text"
                        value="{{ old('button_text') }}" class="form-control">
                    @error('button_text')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input class="form-control" type="file" name="photo" value="{{ old('photo') }}">
                    </div>
                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                    @error('photo')
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
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
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
