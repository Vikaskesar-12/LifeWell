@extends('backend.layouts.master')
@section('title', 'LIFWEL || Create Attribute')
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

    <div class="card shadow-sm m-4">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="fas fa-tag mr-2"></i>
            <h5 class="mb-0">Add Attribute</h5>
        </div>

        <div class="section m-5">
            <form action="{{ route('admin.attributes.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Left Section -->
                    <div class="col-md-8">
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">Label Name</h5>

                                <div class="form-group mb-3">
                                    <label for="name" class="fw-bold">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name') }}" placeholder="Enter attribute name" required>
                                </div>
                            </div>
                        </div>

                        <!-- Option Type -->
                        <div id="optionTypeContainer" class="form-group mb-3 p-3"
                            style="display: none; border:1px solid #ddd; border-radius: 6px;">
                            <label class="fw-bold mb-2">Option Type</label>
                            <select id="optionType" class="form-control">
                                <option value="dropdown">Dropdown</option>
                                <option value="color">Color Swatch</option>
                                <option value="image">Image Swatch</option>
                                <option value="text">Text Swatch</option>
                            </select>
                        </div>

                        <!-- Options Section -->
                        <div class="form-group mb-3" id="optionsSection" style="display: none;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="fw-bold">Options</label>
                                <button type="button" id="addOptionBtn" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus-circle me-1"></i> Add Option
                                </button>
                            </div>
                            <div id="options-wrapper"></div>
                        </div>

                    </div>

                    <!-- Right Section -->
                    <div class="col-md-4">
                        <!-- General -->
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">General</h6>
                                <div class="form-group mb-2">
                                    <label>Attribute Code <span class="text-danger">*</span></label>
                                    <input type="text" name="code" class="form-control" placeholder="Attribute Code"
                                        required>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Attribute Type</label>
                                    <select class="form-control" id="attributeType" name="type">
                                        <option value="">Select Type</option>
                                        <option value="text">Text</option>
                                        <option value="select">Select</option>
                                        <option value="multiselect">Multi Select</option>
                                        <option value="boolean">Boolean</option>
                                        <option value="textarea">Textarea</option>
                                        <option value="price">Price</option>
                                        <option value="datetime">Date Time</option>
                                        <option value="date">Date</option>
                                        <option value="image">Image</option>
                                        <option value="file">File</option>
                                        <option value="checkbox">Checkbox</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Validations -->
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Validations</h6>
                                <div class="form-check mb-1">
                                    <input type="checkbox" name="is_required" class="form-check-input" id="required">
                                    <label class="form-check-label" for="required">Is Required</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="is_unique" class="form-check-input" id="unique">
                                    <label class="form-check-label" for="unique">Is Unique</label>
                                </div>
                            </div>
                        </div>

                        <!-- Configuration -->
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Configuration</h6>
                                <div class="form-check">
                                    <input type="checkbox" name="value_per_locale" class="form-check-input"
                                        id="valuePerLocale">
                                    <label class="form-check-label" for="valuePerLocale">Value Per Locale</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="value_per_channel" class="form-check-input"
                                        id="valuePerChannel">
                                    <label class="form-check-label" for="valuePerChannel">Value Per Channel</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="is_configurable" class="form-check-input"
                                        id="configurable">
                                    <label class="form-check-label" for="configurable">Use To Create Configurable
                                        Product</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="visible_on_front" class="form-check-input"
                                        id="visibleFront">
                                    <label class="form-check-label" for="visibleFront">Visible on Product View Page on
                                        Front-end</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="is_comparable" class="form-check-input"
                                        id="comparable">
                                    <label class="form-check-label" for="comparable">Attribute is comparable</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="use_in_navigation" class="form-check-input"
                                        id="layered">
                                    <label class="form-check-label" for="layered">Use in Layered Navigation</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mb-4 text-end">
                    <button type="submit" class="btn btn-primary">Save Attribute</button>
                </div>
            </form>
        </div>

    </div>

    <!-- JavaScript for Dynamic Option Handling -->
    <script>
        const attributeType = document.getElementById('attributeType');
        const optionTypeContainer = document.getElementById('optionTypeContainer');
        const optionTypeSelect = document.getElementById('optionType');
        const optionsSection = document.getElementById('optionsSection');
        const addOptionBtn = document.getElementById('addOptionBtn');
        const optionsWrapper = document.getElementById('options-wrapper');

        attributeType.addEventListener('change', function() {
            const selected = this.value;
            if (selected === 'select' || selected === 'multiselect' || selected === 'checkbox') {
                optionsSection.style.display = 'block';
                optionTypeContainer.style.display = 'block';
            } else {
                optionsSection.style.display = 'none';
                optionTypeContainer.style.display = 'none';
                optionsWrapper.innerHTML = '';
            }
        });

        addOptionBtn.addEventListener('click', function() {
            const selectedOptionType = optionTypeSelect.value;

            let extraInput = ''; // for swatch inputs
            if (selectedOptionType === 'color') {
                extraInput =
                    `<input type="color" name="color[]" class="form-control form-control-color ms-2" title="Choose color">`;
            } else if (selectedOptionType === 'image') {
                extraInput = `<input type="file" name="image[]" class="form-control ms-2" accept="image/*">`;
            } else if (selectedOptionType === 'text') {
                extraInput =
                    `<input type="text" name="text_swatches[]" class="form-control ms-2" placeholder="Text Swatch">`;
            }

            const optionRow = document.createElement('div');
            optionRow.classList.add('input-group', 'mb-2', 'option-row');
            optionRow.innerHTML = ` 
<div class="input-group mb-2 option-row" style="border: 1px solid #ddd; border-radius: 5px; padding: 5px;">
    <input type="text" name="option_name_en[]" class="form-control" placeholder="Option Name (EN)">
    <input type="text" name="option_name_fr[]" class="form-control ms-2" placeholder="Option Name (FR)">
    ${extraInput}
    <button type="button" class="btn btn-danger remove-option ms-2">
        <i class="fas fa-trash"></i>
    </button>
</div>
`;
            optionsWrapper.appendChild(optionRow);
        });

        // Remove option row
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-option')) {
                e.target.closest('.option-row').remove();
            }
        });

        // Reset options when Option Type changes
        optionTypeSelect.addEventListener('change', function() {
            optionsWrapper.innerHTML = ''; // Clear all existing rows
        });
    </script>

@endsection
