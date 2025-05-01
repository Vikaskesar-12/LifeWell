@extends('backend.layouts.master')
@section('title', 'LifeWell || Discount Create')
@section('main-content')

    <div class="container mt-4">
        <h4>Edit Attribute</h4>

        <form action="{{ route('admin.attributes.update', $attribute->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $attribute->name) }}" required>
            </div>

            <div class="form-group">
                <label for="code">Code</label>
                <input type="text" name="code" id="code" class="form-control"
                    value="{{ old('code', $attribute->code) }}" required>
            </div>

            <div class="form-group">
                <label for="type">Type</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="text" {{ old('type', $attribute->type) == 'text' ? 'selected' : '' }}>Text</option>
                    <option value="select" {{ old('type', $attribute->type) == 'select' ? 'selected' : '' }}>Select</option>
                    <option value="multiselect" {{ old('type', $attribute->type) == 'multiselect' ? 'selected' : '' }}>
                        Multiselect</option>
                </select>
            </div>

            <div class="form-group" id="values-container">
                <label for="values">Values (only for Select or Multiselect)</label>
                @foreach ($attribute->values as $value)
                    <input type="text" name="values[]" class="form-control mt-2" value="{{ $value->value }}">
                @endforeach
                <button type="button" id="add-value" class="btn btn-secondary mt-2">Add another value</button>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Attribute</button>
        </form>
    </div>

    <script>
        // JavaScript to add more value inputs dynamically
        document.getElementById('add-value').addEventListener('click', function() {
            const container = document.getElementById('values-container');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'values[]';
            input.classList.add('form-control', 'mt-2');
            input.placeholder = 'Enter value';
            container.insertBefore(input, this);
        });
    </script>
@endsection
