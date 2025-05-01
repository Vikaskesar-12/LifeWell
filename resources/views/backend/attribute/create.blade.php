@extends('backend.layouts.master')
@section('title', 'LifeWell || Create Attribute')
@section('main-content')







    <div class="container mt-5">
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
                                <label>Attribute Type <span class="text-danger">*</span></label>
                                <select name="type" class="form-control" id="attributeType" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="text">Text</option>
                                    <option value="select">Select</option>
                                    <option value="multiselect">Multiselect</option>
                                    <option value="boolean">Boolean</option>
                                    <option value="textarea">Textarea</option>
                                    <option value="price">Price</option>
                                    <option value="datetime">Datetime</option>
                                    <option value="date">Date</option>
                                    <option value="file">File</option>
                                    <option value="checkbox">Checkbox</option>
                                </select>
                            </div>



                            <!-- Option List (Dynamic) -->
                            <div class="form-group mb-3" id="options-section" style="display: none;">
                                <label class="fw-bold">Options</label>
                                <div id="options-wrapper">
                                    <div class="input-group mb-2 option-row">
                                        <input type="text" name="options[]" class="form-control"
                                            placeholder="Enter option">
                                        <button type="button" class="btn btn-danger remove-option"><i
                                                class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-success mt-2" id="add-option"><i
                                        class="bi bi-plus-lg"></i> Add Option</button>
                            </div>

                            <div class="form-group mb-2">
                                <label>Default Value</label>
                                <input type="text" name="default_value" class="form-control" placeholder="Default Value">
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
                                <input type="checkbox" name="value_per_locale" class="form-check-input" id="valuePerLocale">
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
                                <input type="checkbox" name="is_comparable" class="form-check-input" id="comparable">
                                <label class="form-check-label" for="comparable">Attribute is comparable</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="use_in_navigation" class="form-check-input" id="layered">
                                <label class="form-check-label" for="layered">Use in Layered Navigation</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-primary">Save Attribute</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS (Optional but useful) -->

    <!-- JavaScript for Dynamic Option Handling -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('attributeType');
            const optionsSection = document.getElementById('options-section');
            const addOptionBtn = document.getElementById('add-option');
            const optionsWrapper = document.getElementById('options-wrapper');

            function toggleOptionsSection() {
                const selectedType = typeSelect.value;
                const showTypes = ['select', 'multiselect', 'checkbox'];
                if (showTypes.includes(selectedType)) {
                    optionsSection.style.display = 'block';
                } else {
                    optionsSection.style.display = 'none';
                }
            }

            typeSelect.addEventListener('change', toggleOptionsSection);
            toggleOptionsSection();

            addOptionBtn.addEventListener('click', function() {
                const newOption = document.createElement('div');
                newOption.classList.add('input-group', 'mb-2', 'option-row');
                newOption.innerHTML = `
            <input type="text" name="options[]" class="form-control" placeholder="Enter option">
            <button type="button" class="btn btn-danger remove-option"><i class="fas fa-plus"></i></button>
        `;
                optionsWrapper.appendChild(newOption);
            });

            optionsWrapper.addEventListener('click', function(e) {
                if (e.target.closest('.remove-option')) {
                    e.target.closest('.option-row').remove();
                }
            });
        });
    </script>

@endsection
