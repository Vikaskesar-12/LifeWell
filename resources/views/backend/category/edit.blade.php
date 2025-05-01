@extends('backend.layouts.master')
@section('title', 'LifeWell || Category Edit')
@section('main-content')

    <div class="card">
        <h5 class="card-header">Edit Category</h5>
        <div class="card-body">
            <form method="post" action="{{ route('category.update', $category->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif



                <div class="form-group">
                    <label for="inputTitle_en" class="col-form-label">Title (English) <span
                            class="text-danger">*</span></label>
                    <input id="inputTitle_en" type="text" name="title_en" placeholder="Enter title in English"
                        value="{{ old('title_en', $category->title_en ?? '') }}" class="form-control">
                    @error('title_en')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputTitle_fr" class="col-form-label">Title (French) <span
                            class="text-danger">*</span></label>
                    <input id="inputTitle_fr" type="text" name="title_fr" placeholder="Enter title in French"
                        value="{{ old('title_fr', $category->title_fr ?? '') }}" class="form-control">
                    @error('title_fr')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="summary_en" class="col-form-label">Summary (English)</label>
                    <textarea class="form-control" id="summary_en" name="summary_en">{{ old('summary_en', $category->summary_en ?? '') }}</textarea>
                    @error('summary_en')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="summary_fr" class="col-form-label">Summary (French)</label>
                    <textarea class="form-control" id="summary_fr" name="summary_fr">{{ old('summary_fr', $category->summary_fr ?? '') }}</textarea>
                    @error('summary_fr')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>










                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Price Filter <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="price_filter" placeholder="Enter title"
                        value="{{ old('price_filter', $category->price_filter) }}" class="form-control">
                    @error('price_filter')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="is_parent">Is Parent</label><br>
                    <input type="checkbox" name='is_parent' id='is_parent' value='{{ $category->is_parent }}'
                        {{ $category->is_parent == 1 ? 'checked' : '' }}> Yes
                </div>
                {{-- {{$parent_cats}} --}}
                {{-- {{$category}} --}}

                <div class="form-group {{ $category->is_parent == 1 ? 'd-none' : '' }}" id='parent_cat_div'>
                    <label for="parent_id">Parent Category</label>
                    <select name="parent_id" class="form-control">
                        <option value="">--Select any category--</option>
                        @foreach ($parent_cats as $key => $parent_cat)
                            <option value='{{ $parent_cat->id }}'
                                {{ $parent_cat->id == $category->parent_id ? 'selected' : '' }}>{{ $parent_cat->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="hot_sale">Hot Sale</label><br>
                    <input type="checkbox" name='hot_sale' id='hot_sale' value='{{ $category->hot_sale }}'
                        {{ $category->hot_sale == 1 ? 'checked' : '' }}> Yes
                </div>
                @error('hot_sale')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Banner</label>
                    <div class="input-group">
                        <input id="banner" class="form-control" type="file" accept="image/*" name="banner"
                            value="{{ $category->photo }}">
                    </div>

                    @if ($category->category_banner)
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align"><span
                                    class="required"></span></label>
                            <div class="col-md-6 col-sm-6">
                                <div class="image-preview mt-3">
                                    <div class="image-container"
                                        style="position: relative; display: inline-block; margin: 5px;">
                                        <img src="{{ asset($category->category_banner) }}" id="banner-preview"
                                            class="ml-2" style="height:100px; width:100px;">
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endif
                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                    @error('banner')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Photo</label>
                    <div class="input-group">
                        <input id="thumbnail" class="form-control" type="file" accept="image/*" name="photo"
                            value="{{ $category->photo }}">
                    </div>

                    @if ($category->photo)
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align"><span
                                    class="required"></span></label>
                            <div class="col-md-6 col-sm-6">
                                <div class="image-preview mt-3">
                                    <div class="image-container"
                                        style="position: relative; display: inline-block; margin: 5px;">
                                        <img src="{{ asset($category->photo) }}" id="testimonial-preview" class="ml-2"
                                            style="height:100px; width:100px;">
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endif
                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                    @error('photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Icon</label>
                    <div class="input-group">
                        <input id="icon-thumbnail" class="form-control" type="file" accept="image/*" name="icon"
                            value="{{ old('icon') }}">
                    </div>
                    @if ($category->icon)
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align"><span
                                    class="required"></span></label>
                            <div class="col-md-6 col-sm-6">
                                <div class="image-preview mt-3">
                                    <div class="image-container"
                                        style="position: relative; display: inline-block; margin: 5px;">
                                        <img src="{{ asset($category->icon) }}" id="icon-preview" class="ml-2"
                                            style="height:100px; width:100px;">
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endif
                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                    @error('icon')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>Inactive
                        </option>
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
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script>
        // Initialize Summernote editor for both English and French summary fields
        $(document).ready(function() {
            $('#summary_en').summernote({
                height: 300, // Set the height of the editor
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear', 'fontsize',
                        'fontname'
                    ]], // Font-related options
                    ['color', ['color']], // Text color
                    ['para', ['ul', 'ol', 'paragraph']], // Paragraph-related options
                    ['table', ['table']], // Table options
                    ['insert', ['link', 'picture', 'video']], // Media and link options
                    ['view', ['fullscreen', 'codeview', 'help']] // View options
                ],
                fontNames: ['Arial', 'Times New Roman', 'Verdana', 'Courier New', 'Comic Sans MS'],
                fontNamesIgnoreCheck: ['Arial', 'Times New Roman', 'Verdana', 'Courier New',
                    'Comic Sans MS'
                ]
            });

            // Initialize Summernote for French summary field
            $('#summary_fr').summernote({
                height: 300, // Set the height of the editor
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear', 'fontsize',
                        'fontname'
                    ]], // Font-related options
                    ['color', ['color']], // Text color
                    ['para', ['ul', 'ol', 'paragraph']], // Paragraph-related options
                    ['table', ['table']], // Table options
                    ['insert', ['link', 'picture', 'video']], // Media and link options
                    ['view', ['fullscreen', 'codeview', 'help']] // View options
                ],
                fontNames: ['Arial', 'Times New Roman', 'Verdana', 'Courier New', 'Comic Sans MS'],
                fontNamesIgnoreCheck: ['Arial', 'Times New Roman', 'Verdana', 'Courier New',
                    'Comic Sans MS'
                ]
            });
        });
    </script>
    <script>
        $('#is_parent').change(function() {
            var is_checked = $('#is_parent').prop('checked');
            // alert(is_checked);
            if (is_checked) {
                $('#parent_cat_div').addClass('d-none');
                $('#parent_cat_div').val('');
            } else {
                $('#parent_cat_div').removeClass('d-none');
            }
        })
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
        $(document).on('change', '#icon-thumbnail', function(event) {
            // alert('hi');
            const files = Array.from(event.target.files);
            console.log('files', files);

            if (files.length > 0) {
                console.log($('#icon-preview'));
                const file = files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    $('#icon-preview').attr('src', e.target.result);
                };

                reader.readAsDataURL(file);
            }
        });

        $(document).on('change', '#banner', function(event) {
            // alert('hi');
            const files = Array.from(event.target.files);
            console.log('files', files);

            if (files.length > 0) {
                console.log($('#banner-preview'));
                const file = files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    $('#banner-preview').attr('src', e.target.result);
                };

                reader.readAsDataURL(file);
            }
        });
        $(document).on('change', '#hot_sale', function() {
            var status = $(this).is(':checked') ? 1 : 0;
            $(this).val(status);
        });
        $(document).on('change', '#top_rated', function() {
            var status = $(this).is(':checked') ? 1 : 0;
            $(this).val(status);
        });
    </script>
@endpush
