@extends('backend.layouts.master')
@section('title', 'LIFWEL || Brand Edit')
@section('main-content')

    <div class="card">
        <h5 class="card-header">Edit Brand</h5>
        <div class="card-body">
            <form method="post" action="{{ route('brand.update', $brand->id) }}">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Enter title"
                        value="{{ $brand->title }}" class="form-control">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="cat_id">Category <span class="text-danger">*</span></label>
                    @php
                        $categories = $brand->categories ? array_column($brand->categories->toArray(), 'id') : [];
                    @endphp

                    <select name="category_id[]" class="form-control selectpicker" multiple data-live-search="true">
                        <option value="">--Select any Category--</option>
                        @foreach ($category as $key => $cat_data)
                            <option value='{{ $cat_data->id }}'
                                {{ in_array($cat_data->id, $categories) ? 'selected' : '' }}>{{ $cat_data->title_en }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $brand->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $brand->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
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
