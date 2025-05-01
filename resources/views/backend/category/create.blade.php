@extends('backend.layouts.master')
@section('title', 'LifeWell || Category Create')
@section('main-content')

    <div class="card">
        <h5 class="card-header">Add Category</h5>
        <div class="card-body">
            <form method="post" action="{{ route('category.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}


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
                        value="{{ old('title_en') }}" class="form-control">
                    @error('title_en')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputTitle_fr" class="col-form-label">Title (French) <span
                            class="text-danger">*</span></label>
                    <input id="inputTitle_fr" type="text" name="title_fr" placeholder="Enter title in French"
                        value="{{ old('title_fr') }}" class="form-control">
                    @error('title_fr')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="summary_en" class="col-form-label">Summary (English)</label>
                    <textarea class="form-control" id="summary_en" name="summary_en">{{ old('summary_en') }}</textarea>
                    @error('summary_en')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="summary_fr" class="col-form-label">Summary (French)</label>
                    <textarea class="form-control" id="summary_fr" name="summary_fr">{{ old('summary_fr') }}</textarea>
                    @error('summary_fr')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>







                <div class="form-group">
                    <label for="is_parent">Is Parent</label><br>
                    <input type="checkbox" name='is_parent' id='is_parent' value='1' checked> Yes
                </div>
                {{-- {{$parent_cats}} --}}

                <div class="form-group d-none" id='parent_cat_div'>
                    <label for="parent_id">Parent Category</label>
                    <select name="parent_id" class="form-control">
                        <option value="">--Select any category--</option>
                        @foreach ($parent_cats as $key => $parent_cat)
                            <option value='{{ $parent_cat->id }}'>{{ $parent_cat->title_en }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Price Filter <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="price_filter" placeholder="Enter title"
                        value="{{ old('price_filter') }}" class="form-control">
                    @error('price_filter')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="hot_sale">Hot Sale</label><br>
                    <input type="checkbox" name='hot_sale' id='hot_sale'> Yes
                </div>
                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">banner</label>
                    <div class="input-group">
                        <input class="form-control" type="file" name="banner" accept="image/*"
                            value="{{ old('banner') }}">
                    </div>
                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>

                    @error('banner')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Photo</label>
                    <div class="input-group">
                        <input class="form-control" type="file" name="photo" accept="image/*"
                            value="{{ old('photo') }}">
                    </div>
                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>

                    @error('photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Icon</label>
                    <div class="input-group">
                        <input class="form-control" type="file" name="icon" accept="image/*"
                            value="{{ old('icon') }}">
                    </div>
                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                    @error('icon')
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
