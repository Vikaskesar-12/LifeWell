@extends('backend.layouts.master')
@section('title', 'LifeWell || Discount')
@section('main-content')

    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>

        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary"> All Attribute List</h6>
            <a href="{{ route('admin.attributes.create') }}" class="btn btn-success btn-sm" data-toggle="tooltip"
                title="Add New Discount Code">
                <i class="fas fa-plus"></i> Add Attribute
            </a>
        </div>

        <div class="card-body">
            <!-- Search Bar -->
            <div class="mb-3 d-flex justify-content-end">
                <form id="searchForm" class="form-inline" style="max-width: 300px;">
                    <input type="text" class="form-control w-100" id="searchInput"
                        placeholder="Search discount codes..." />
                </form>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Values</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attributes as $attribute)
                            <tr>
                                <td>{{ $attribute->id }}</td>
                                <td>{{ $attribute->name }}</td>
                                <td>{{ $attribute->code }}</td>
                                <td>{{ $attribute->type }}</td>
                                <td>
                                    <ul>
                                        @foreach ($attribute->values as $val)
                                            <li>{{ $val->value }}</li>
                                        @endforeach
                                    </ul>
                                </td>

                                <td>
                                    <a href="{{ route('admin.attributes.edit', $attribute->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('admin.attributes.destroy', $attribute->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this attribute?');"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>


                                </td>




                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
