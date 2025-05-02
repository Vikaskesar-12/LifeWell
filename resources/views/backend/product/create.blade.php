@extends('backend.layouts.master')
@section('title', 'LIFWEL || Add Product')
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
    <div class="card">
        <h5 class="card-header">Add Product</h5>
        <div class="card-body">
            <form method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}

                <!-- Title Fields -->


                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white d-flex align-items-center">
                        <i class="fas fa-tag mr-2"></i>
                        <h5 class="mb-0">Product Basic Details</h5>
                    </div>

                    <div class="form-row m-4">
                        <div class="form-group col-md-6">
                            <label for="inputTitle" class="col-form-label">Title (English) <span
                                    class="text-danger">*</span></label>
                            <input id="inputTitle" type="text" name="title_en" placeholder="Enter title in English"
                                value="{{ old('title_en') }}" class="form-control">
                            @error('title_en')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputTitleFr" class="col-form-label">Title (French)</label>
                            <input id="inputTitleFr" type="text" name="title_fr" placeholder="Enter title in French"
                                value="{{ old('title_fr') }}" class="form-control">
                            @error('title_fr')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <!-- Summary Fields -->
                    <div class="form-group m-4">
                        <label for="summary" class="col-form-label">Summary (English) <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control" id="summary" name="summary_en">{{ old('summary_en') }}</textarea>
                        @error('summary_en')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group m-4">
                        <label for="summaryFr" class="col-form-label">Summary (French)</label>
                        <textarea class="form-control" id="summaryFr" name="summary_fr">{{ old('summary_fr') }}</textarea>
                        @error('summary_fr')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description Fields -->
                    <div class="form-group m-4">
                        <label for="description" class="col-form-label">Description (English)</label>
                        <textarea class="form-control" id="description" name="description_en">{{ old('description_en') }}</textarea>
                        @error('description_en')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group m-4">
                        <label for="descriptionFr" class="col-form-label">Description (French)</label>
                        <textarea class="form-control" id="descriptionFr" name="description_fr">{{ old('description_fr') }}</textarea>
                        @error('description_fr')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Return Policy Fields -->
                    <div class="form-group m-4">
                        <label for="return_policy" class="col-form-label">Return Policy (English)</label>
                        <textarea class="form-control" id="return" name="return_policy_en">{{ old('return_policy_en') }}</textarea>
                        @error('return_policy_en')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group m-4">
                        <label for="returnPolicyFr" class="col-form-label">Return Policy (French)</label>
                        <textarea class="form-control" id="returnPolicyFr" name="return_policy_fr">{{ old('return_policy_fr') }}</textarea>
                        @error('return_policy_fr')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white d-flex align-items-center">
                        <i class="fas fa-tag mr-2"></i>
                        <h5 class="mb-0">Pricing Details</h5>
                    </div>
                    <div class="card-body">

                        <!-- Price Type Selection -->
                        <div class="form-group">
                            <label for="price_type" class="col-form-label">
                                <i class="fas fa-dollar-sign mr-1"></i> Price Type
                            </label>
                            <select id="price_type" name="price_type" class="form-control">
                                <option value="" disabled selected>Select Price Type</option>
                                <option value="0">B2B</option>
                                <option value="1">B2C</option>
                                <option value="2">Both</option>
                            </select>
                            @error('price_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- B2B Price -->
                        <div id="b2b_price_div" class="form-group" style="display:none;">
                            <label for="b2b_price" class="col-form-label">
                                <i class="fas fa-rupee-sign mr-1"></i> B2B Price
                            </label>
                            <input type="number" name="b2b_price" id="b2b_price" class="form-control"
                                placeholder="Enter B2B Price" />
                            @error('b2b_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- B2C Price -->
                        <div id="b2c_price_div" class="form-group" style="display:none;">
                            <label for="b2c_price" class="col-form-label">
                                <i class="fas fa-hand-holding-usd mr-1"></i> B2C Price
                            </label>
                            <input type="number" name="b2c_price" id="b2c_price" class="form-control"
                                placeholder="Enter B2C Price" />
                            @error('b2c_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Country Ability -->
                        <div class="form-group">
                            <label for="country_ability" class="col-form-label">
                                <i class="fas fa-globe-asia mr-1"></i> Country Ability
                            </label>
                            <select id="country_ability" name="country_ability" class="form-control" required>
                                <option value="0">India</option>
                                <option value="1">Other</option>
                                <option value="2">All</option>
                            </select>
                            @error('country_ability')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>


                <!-- Flash Sales & Promotions -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white d-flex align-items-center">
                        <i class="fas fa-tag mr-2"></i>
                        <h5 class="mb-0">Flash sales, promotions</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Discount Price</label>
                            <input type="text" name="discount_price" class="form-control"
                                value="{{ old('discount_price', $product->discount_price ?? '') }}">
                        </div>
                        <div class="form-row ">
                            <div class="form-group col-md-6">
                                <label for="discount_start_date">Discount Start Date</label>
                                <input type="datetime-local" id="discount_start_date" name="discount_start_date"
                                    class="form-control"
                                    value="{{ old('discount_start_date', isset($product) ? $product->discount_start_date->format('Y-m-d\TH:i') : '') }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="discount_end_date">Discount End Date</label>
                                <input type="datetime-local" id="discount_end_date" name="discount_end_date"
                                    class="form-control"
                                    value="{{ old('discount_end_date', isset($product) ? $product->discount_end_date->format('Y-m-d\TH:i') : '') }}">
                            </div>
                        </div>

                    </div>
                </div>





                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white d-flex align-items-center">
                        <i class="fas fa-tag mr-2"></i>
                        <h5 class="mb-0">Minimum Allowed Quantity (MAQ) for B2B Sellers</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="minimum_order_quantity">Minimum Order Quantity</label>
                            <input type="number" name="minimum_order_quantity" id="minimum_order_quantity"
                                class="form-control"
                                value="{{ old('minimum_order_quantity', isset($product) ? $product->minimum_order_quantity : '') }}"
                                min="1" required>
                        </div>
                    </div>
                </div>






                <div class="form-group">
                    <label for="is_featured">Is Featured</label><br>
                    <input type="checkbox" name='is_featured' id='is_featured' value='1' checked> Yes
                </div>
                {{-- {{$categories}} --}}

                <div class="form-group">
                    <label for="cat_id">Category <span class="text-danger">*</span></label>
                    <select name="cat_id" id="cat_id" class="form-control">
                        <option value="">--Select any category--</option>
                        @foreach ($categories as $key => $cat_data)
                            <option value='{{ $cat_data->id }}'>{{ $cat_data->title_en }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group d-none" id="child_cat_div">
                    <label for="child_cat_id">Sub Category</label>
                    <select name="child_cat_id" id="child_cat_id" class="form-control">
                        <option value="">--Select any category--</option>
                        {{-- @foreach ($parent_cats as $key => $parent_cat)
                  <option value='{{$parent_cat->id}}'>{{$parent_cat->title}}</option>
              @endforeach --}}
                    </select>
                </div>




                <div class="form-group">
                    <label for="is_featured">Top Rated</label><br>
                    <input type="checkbox" name='top_rated' id='top_rated' value='1'> Yes
                </div>

                <div class="form-group">
                    <label for="best_seller">Best Seller</label><br>
                    <input type="checkbox" name='best_seller' id='best_seller' value='1'> Yes
                </div>


                <div class="form-group">
                    <label for="brand_id">Brand</label>
                    {{-- {{$brands}} --}}

                    <select name="brand_id" id="brand_id" class="form-control">
                        <option value="">--Select Brand--</option>
                    </select>
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
                <hr>

                <div class="product-variant col-md-12" id="product-variant">
                    <p>Add Product Variant:</p>
                    <!-- <div class="add-button col-md-12 offset-11">
                                                                                                                                                                                                                                                                                                  <button class="btn btn-success ms-auto" id="add_variant" type="button">Add Variant</button>
                                                                                                                                                                                                                                                                                              </div> -->

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="price" class="col-form-label">Variant Title <span
                                    class="text-danger">*</span></label>
                            <input id="variant_title" type="text" name="variant_title" placeholder="Enter old price"
                                value="{{ old('variant_title') }}" class="form-control">
                            @error('variant_title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="discount" class="col-form-label">Discount(%)</label>
                            <input id="discount" type="number" name="discount" min="0" max="100"
                                placeholder="Enter discount" value="{{ old('discount') }}" class="form-control">
                            @error('discount')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="condition">Collection</label>
                            <select name="condition" class="form-control">
                                <option value="">--Select Condition--</option>
                                <option value="default">Default</option>
                                <option value="new">New</option>
                                <option value="hot">Hot</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="price" class="col-form-label">Old Price(NRS) <span
                                    class="text-danger">*</span></label>
                            <input id="base_price" type="number" name="base_price" placeholder="Enter old price"
                                value="{{ old('base_price') }}" class="form-control">
                            @error('base_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="price" class="col-form-label">Price(NRS) <span
                                    class="text-danger">*</span></label>
                            <input id="price" type="number" name="price" placeholder="Enter price"
                                value="{{ old('price') }}" class="form-control">
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="stock">Quantity (Stock Avilable Product) <span
                                    class="text-danger">*</span></label>
                            <input id="quantity" type="number" name="stock" min="0"
                                placeholder="Enter quantity" value="{{ old('stock') }}" class="form-control">
                            @error('stock')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="first-specification">
                    </div>

                    <div class="form-group">
                        <label for="inputPhoto" class="col-form-label">Photo (Max size: 1MB, dimensions: 800x1000 min,
                            1600x2000 max, formats: JPG, JPEG) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input class="form-control" type="file" name="photo[]" accept="image/*" multiple
                                id="imageInput">
                        </div>
                        <div id="previewContainer" style="margin-top: 10px;">
                            <!-- Image previews will be displayed here -->
                        </div>
                        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                        @foreach ($errors->get('photo.*') as $key => $error)
                            <span class="text-danger">{{ $error[0] }}</span>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                        <select name="variant_status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script>
        // File Manager Integration for Image Upload
        $('#lfm').filemanager('image');

        $(document).ready(function() {
            // Summernote Editor for English Summary
            $('#summary').summernote({
                placeholder: "Write short description in English.....",
                tabsize: 2,
                height: 100
            });

            // Summernote Editor for French Summary
            $('#summaryFr').summernote({
                placeholder: "Write short description in French.....",
                tabsize: 2,
                height: 100
            });

            // Summernote Editor for English Description
            $('#description').summernote({
                placeholder: "Write detailed description in English.....",
                tabsize: 2,
                height: 150
            });

            // Summernote Editor for French Description
            $('#descriptionFr').summernote({
                placeholder: "Write detailed description in French.....",
                tabsize: 2,
                height: 150
            });

            // Summernote Editor for English Return Policy
            $('#return').summernote({
                placeholder: "Write return policy in English.....",
                tabsize: 2,
                height: 150
            });

            // Summernote Editor for French Return Policy
            $('#returnPolicyFr').summernote({
                placeholder: "Write return policy in French.....",
                tabsize: 2,
                height: 150
            });

            // Uncomment if you have dropdowns or select fields with bootstrap selectpicker
            // $('select').selectpicker();
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#price_type').change(function() {
                var type = $(this).val();

                // Pehle sabko hide karo
                $('#b2b_price_div').hide();
                $('#b2c_price_div').hide();

                $('#b2b_price').val('');
                $('#b2c_price').val('');

                $('#b2b_price').prop('required', false);
                $('#b2c_price').prop('required', false);

                if (type == '0') {
                    $('#b2b_price_div').show();
                    $('#b2b_price').prop('required', true);
                } else if (type == '1') {
                    $('#b2c_price_div').show();
                    $('#b2c_price').prop('required', true);
                } else if (type == '2') {
                    $('#b2b_price_div').show();
                    $('#b2c_price_div').show();
                    $('#b2b_price').prop('required', true);
                    $('#b2c_price').prop('required', true);
                }
            });
        });
    </script>


















    <script>
        $('#cat_id').change(function() {
            var cat_id = $(this).val();
            // alert(cat_id);
            if (cat_id != null) {
                $('.specification').empty();
                // Ajax call
                $.ajax({
                    url: "/admin/category/" + cat_id + "/child",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: cat_id
                    },
                    type: "POST",
                    success: function(response) {
                        if (typeof(response) != 'object') {
                            response = $.parseJSON(response)
                        }
                        // console.log(response);
                        var html_option = "<option value=''>----Select sub category----</option>"
                        if (response.status) {
                            // alert(data);
                            var data = response.data;
                            if (response.data) {
                                $('#child_cat_div').removeClass('d-none');
                                $.each(data, function(id, title_en) {
                                    html_option += "<option value='" + id + "'>" + title_en +
                                        "</option>"
                                });
                            } else {}
                        } else {
                            $('#child_cat_div').addClass('d-none');
                        }
                        $('#child_cat_id').html(html_option);

                    }
                });


            } else {}

        })
    </script>
    <script>
        $('#child_cat_id').change(function() {
            var cat_id = $(this).val();
            if (cat_id != null) {
                // Ajax call
                $.ajax({
                    url: "/admin/specification/" + cat_id + "/data",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: cat_id
                    },
                    type: "POST",
                    success: function(response) {
                        if (typeof(response) != 'object') {
                            response = $.parseJSON(response)
                        }
                        // console.log(response);
                        var html_option = `<div><p>Product Specification : </p></div>`;
                        if (response.status && response.data) {
                            var data = response.data;
                            let html_option = ''; // Initialize your html_option variable
                            $.each(data, function(index, value) {
                                // Start a new row every three items
                                if (index % 3 === 0) {
                                    if (index !== 0) {
                                        html_option += `</div>`; // Close the previous row
                                    }
                                    html_option += `<div class="row">`; // Start a new row
                                }

                                html_option += `
                      <div class="col-md-4"> <!-- One column -->
                          <div class="form-group">
                              <label for="${value.name}">${value.name}</label>
                              <input type="hidden" name="specification[]" value="${value.name}">
                              <input type="text" name="${value.name}" required class="form-control">
                          </div>
                      </div>`;
                            });

                            // Close the last row
                            html_option += `</div>`;


                            // Append the generated HTML to the .specification container
                            $('.first-specification').append(html_option);

                            // Reinitialize the selectpicker for the newly added elements
                            $('.selectpicker').selectpicker('refresh');
                        } else {
                            $('.specification').empty();
                        }
                    }
                });
                $.ajax({
                    url: "{{ route('product.brand') }}",
                    data: {
                        id: cat_id
                    },
                    type: "get",
                    success: function(response) {
                        if (typeof(response) != 'object') {
                            response = $.parseJSON(response)
                        }
                        // console.log(response);
                        var html_option = "<option value=''>----Select brand----</option>"
                        if (response.status) {
                            // alert(data);
                            var data = response.data;
                            if (response.data) {

                                $.each(data, function(id, data) {
                                    html_option +=
                                        `<option value='${data.id}'>${data.title}</option>`
                                });
                            } else {}
                        } else {}
                        $('#brand_id').html(html_option);
                    }
                });
            } else {}
        })
    </script>




    <script>
        $(document).ready(function() {
            let selectedFiles = [];

            $('#imageInput').on('change', function(event) {
                const previewContainer = $('#previewContainer');
                previewContainer.empty(); // Clear previous previews

                const files = Array.from(event.target.files);
                selectedFiles = files; // Store selected files in an array

                renderPreviews(selectedFiles, previewContainer);
            });

            function renderPreviews(files, container) {
                container.empty(); // Clear previous previews

                $.each(files, function(index, file) {
                    // Ensure the file is an image
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const previewDiv = $('<div>').css({
                                position: 'relative',
                                display: 'inline-block',
                                marginRight: '10px'
                            });
                            const img = $('<img>')
                                .attr('src', e.target.result)
                                .css({
                                    'width': '100px', // Adjust as needed
                                    'height': 'auto', // Maintain aspect ratio
                                });

                            const removeIcon = $('<span>&times;</span>') // Cross icon (×)
                                .css({
                                    position: 'absolute',
                                    top: '0',
                                    right: '0',
                                    color: 'red',
                                    cursor: 'pointer',
                                    fontSize: '15px',
                                    background: 'white',
                                    borderRadius: '50%',
                                    padding: '1px',
                                })
                                .data('fileIndex', index) // Store the index of the file
                                .on('click', function() {
                                    const fileIndex = $(this).data('fileIndex');
                                    selectedFiles.splice(fileIndex, 1); // Remove from array
                                    previewDiv.remove(); // Remove image from preview

                                    // Update the input's files
                                    updateInputFiles();
                                });

                            previewDiv.append(img).append(removeIcon);
                            container.append(previewDiv);
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }

            function updateInputFiles() {
                const newFileList = new DataTransfer(); // Create a new DataTransfer object
                selectedFiles.forEach(file => newFileList.items.add(file)); // Add remaining files
                $('#imageInput')[0].files = newFileList.files; // Update the input's files

                // Re-render previews to update the displayed index
                renderPreviews(selectedFiles, $('#previewContainer'));
            }
        });
    </script>
    <script>
        $(document).on('change', '#is_featured', function() {
            var status = $(this).is(':checked') ? 1 : 0;
            $(this).val(status);
        });
        $(document).on('change', '#top_rated', function() {
            var status = $(this).is(':checked') ? 1 : 0;
            $(this).val(status);
        });
        $(document).on('change', '#best_seller', function() {
            var status = $(this).is(':checked') ? 1 : 0;
            $(this).val(status);
        });
    </script>
    <script></script>
@endpush
