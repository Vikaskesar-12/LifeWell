@extends('backend.layouts.master')

@section('main-content')
    <div class="row">

        {{-- LEFT CARD + RIGHT CARD MERGED INTO SINGLE FORM --}}
        <div class="col-md-12">
            <div class="card shadow p-4 mb-4">

                <div class="card-header bg-primary text-white d-flex align-items-center">

                    <h5 class="mb-0"><i class="fas fa-cogs"></i> Website Settings</h5>
                </div>
                {{-- <h4 class="card-title mb-4"><i class="fas fa-cogs"></i> Website Settings</h4> --}}

                <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id ?? '' }}">

                    <div class="row">
                        {{-- Logo --}}
                        <div class="col-md-6 form-group">
                            <label><i class="fas fa-image"></i> Logo <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="logo" accept="image/*">
                            @if ($data && $data->logo)
                                <img src="{{ asset($data->logo) }}" alt="Logo" class="mt-2" style="height: 50px;">
                            @endif
                            @error('logo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Favicon --}}
                        <div class="col-md-6 form-group">
                            <label>Favicon</label>
                            <input type="file" class="form-control" name="favicon" accept="image/x-icon,image/png">
                            @if ($data && $data->favicon)
                                <img src="{{ asset($data->favicon) }}" alt="Favicon" class="mt-2" style="height: 30px;">
                            @endif
                            @error('favicon')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Website Title --}}
                        <div class="col-md-6 form-group">
                            <label>Website Title</label>
                            <input type="text" name="site_title" class="form-control"
                                value="{{ $data->site_title ?? '' }}" required>
                            @error('site_title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Meta Title --}}
                        <div class="col-md-6 form-group">
                            <label>Meta Title</label>
                            <input type="text" name="meta_title" class="form-control"
                                value="{{ $data->meta_title ?? '' }}" placeholder="Enter website meta title">
                            @error('meta_title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Meta Description --}}
                        <div class="col-md-12 form-group">
                            <label>Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3" placeholder="Short meta description for SEO">{{ $data->meta_description ?? '' }}</textarea>
                            @error('meta_description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Meta Keywords --}}
                        <div class="col-md-12 form-group">
                            <label>Meta Keywords</label>
                            <input name="meta_keywords" class="form-control tagify-input"
                                placeholder="e.g. university, admission, abroad" value="{{ $data->meta_keywords ?? '' }}">
                            @error('meta_keywords')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Address --}}
                        <div class="col-md-6 form-group">
                            <label>Address <span class="text-danger">*</span></label>
                            <input type="text" name="address" class="form-control" value="{{ $data->address ?? '' }}"
                                required>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6 form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ $data->email ?? '' }}"
                                required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-6 form-group">
                            <label>Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" value="{{ $data->phone ?? '' }}"
                                required>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Social Media Section --}}
                        <div class="col-md-12 mt-4">

                            <div class="card-header bg-primary text-white d-flex align-items-center">

                                <h5 class="mb-0"> Social Media</h5>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Facebook</label>
                            <input type="url" name="facebook" class="form-control"
                                placeholder="https://facebook.com/yourpage" value="{{ $data->facebook ?? '' }}">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Twitter</label>
                            <input type="url" name="twitter" class="form-control"
                                placeholder="https://twitter.com/yourprofile" value="{{ $data->twitter ?? '' }}">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Instagram</label>
                            <input type="url" name="instagram" class="form-control"
                                placeholder="https://instagram.com/yourhandle" value="{{ $data->instagram ?? '' }}">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>LinkedIn</label>
                            <input type="url" name="linkedin" class="form-control"
                                placeholder="https://linkedin.com/in/yourprofile" value="{{ $data->linkedin ?? '' }}">
                        </div>
                    </div>

                    <div class="form-group mt-3 text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- Tagify CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" />

    <!-- Tagify JS -->
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var input = document.querySelector('.tagify-input');
            if (input) {
                new Tagify(input);
            }
        });
    </script>
@endsection
