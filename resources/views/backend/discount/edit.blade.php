@extends('backend.layouts.master')
@section('title', 'LIFWEL || Discount Edit')
@section('main-content')

    <div class="card">
        <h5 class="card-header">Edit Discount Code</h5>
        <div class="card-body">
            <form action="{{ route('discount.update', $discount->id) }}" method="POST">
                @csrf
                @method('POST') <!-- For updating -->

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
                    <label for="code" class="col-form-label">Discount Code <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="code" name="code"
                        value="{{ old('code', $discount->code) }}" placeholder="Enter the unique discount code" required>
                    @error('code')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type" class="col-form-label">Discount Type <span class="text-danger">*</span></label>
                    <select class="form-control" id="type" name="type" required>
                        <option value="percentage" {{ old('type', $discount->type) == 'percentage' ? 'selected' : '' }}>
                            Percentage</option>
                        <option value="fixed" {{ old('type', $discount->type) == 'fixed' ? 'selected' : '' }}>Fixed
                        </option>
                    </select>
                    @error('type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="value" class="col-form-label">Value <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="value" name="value"
                        value="{{ old('value', $discount->value) }}"
                        placeholder="Enter the discount value (e.g., 10 or 100)" required>
                    @error('value')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="start_date" class="col-form-label">Start Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="start_date" name="start_date"
                        value="{{ old('start_date', $discount->start_date->format('Y-m-d')) }}"
                        placeholder="Select the discount start date" required>
                    @error('start_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="end_date" class="col-form-label">End Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="end_date" name="end_date"
                        value="{{ old('end_date', $discount->end_date->format('Y-m-d')) }}"
                        placeholder="Select the discount end date" required>
                    @error('end_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="usage_limit" class="col-form-label">Usage Limit <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="usage_limit" name="usage_limit"
                        value="{{ old('usage_limit', $discount->usage_limit) }}"
                        placeholder="Enter the maximum number of uses allowed" required>
                    @error('usage_limit')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="is_active" class="col-form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-control" id="is_active" name="is_active" required>
                        <option value="1" {{ old('is_active', $discount->is_active) == 1 ? 'selected' : '' }}>
                            Active</option>
                        <option value="0" {{ old('is_active', $discount->is_active) == 0 ? 'selected' : '' }}>
                            Inactive</option>
                    </select>
                    @error('is_active')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Discount Code</button>
            </form>
        </div>
    </div>

@endsection
