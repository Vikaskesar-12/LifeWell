@extends('backend.layouts.master')

@section('main-content')
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
    <div class="card m-4">

        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="fas fa-tag mr-2"></i>
            <h5 class="mb-0">Add New Page</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('pages.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Title & Slug --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="title">Page Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control"
                            placeholder="Enter page title" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="slug">Slug (auto-generated)</label>
                        <div class="input-group">
                            <input type="text" name="slug" id="slug" class="form-control" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text" id="toggle-slug-edit" style="cursor: pointer;"
                                    title="Edit Slug">
                                    <i class="fas fa-lock"></i> {{-- Lock icon initially --}}
                                </span>
                            </div>
                        </div>
                        <small class="text-muted mt-1 d-block">URL: <span
                                id="urlPreview">{{ url('/page') }}/</span></small>
                    </div>







                </div>

                <div class="form-group">
                    <label for="description" class="col-form-label">content<span class="text-danger">*</span></label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>

                {{-- Meta Title --}}
                <div class="form-group mb-3">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" class="form-control"
                        placeholder="Enter meta title">
                </div>

                {{-- Meta Description --}}
                <div class="form-group mb-3">
                    <label for="meta_description">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" class="form-control" rows="3"
                        placeholder="Write meta description..."></textarea>
                </div>

                {{-- Meta Keywords --}}
                <div class="form-group mb-3">
                    <label for="meta_keywords">Meta Keywords</label>
                    <input type="text" name="meta_keywords" id="meta_keywords" class="form-control"
                        placeholder="Type and press Enter" title="Add keywords for SEO">
                </div>

                {{-- Status --}}
                <div class="form-group mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
@endpush

@push('scripts')
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>

    <script>
        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Write detailed privacy policy...",
                tabsize: 2,
                height: 250
            });

            // Tagify for meta keywords
            var input = document.querySelector('#meta_keywords');
            new Tagify(input);





            $(document).ready(function() {


                // Slug generation from title (only if slug is readonly)
                $('#title').on('input', function() {
                    if ($('#slug').prop('readonly')) {
                        let title = $(this).val().trim();
                        let slug = title.toLowerCase()
                            .replace(/[^a-z0-9\s-]/g, '')
                            .replace(/\s+/g, '-')
                            .replace(/-+/g, '-')
                            .replace(/^-|-$/g, '');
                        $('#slug').val(slug);
                        $('#urlPreview').text(`{{ url('/page') }}/${slug}`);
                    }
                });

                // Toggle lock/unlock of slug input
                $('#toggle-slug-edit').on('click', function() {
                    let input = $('#slug');
                    let icon = $(this).find('i');

                    if (input.prop('readonly')) {
                        input.prop('readonly', false).focus();
                        icon.removeClass('fa-lock').addClass('fa-lock-open'); // Unlock icon
                    } else {
                        input.prop('readonly', true);
                        icon.removeClass('fa-lock-open').addClass('fa-lock'); // Lock icon
                    }
                });

                // Update preview even when user edits slug manually
                $('#slug').on('input', function() {
                    let customSlug = $(this).val().trim();
                    $('#urlPreview').text(`{{ url('/page') }}/${customSlug}`);
                });
            });

        });
    </script>
@endpush
