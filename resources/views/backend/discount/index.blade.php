@extends('backend.layouts.master')
@section('title', 'LIFWEL || Discount')
@section('main-content')

    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>

        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Discount Code List</h6>
            <a href="{{ route('discount.create') }}" class="btn btn-success btn-sm" data-toggle="tooltip"
                title="Add New Discount Code">
                <i class="fas fa-plus"></i> Add Discount
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
                            <th>#</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($discounts as $key => $d)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $d->code }}</td>


                                <td>{{ ucfirst($d->type) }}</td>
                                <td>{{ $d->value }}</td>

                                <td>{{ \Carbon\Carbon::parse($d->start_date)->format('d M, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($d->end_date)->format('d M, Y') }}</td>
                                <td>
                                    <a href="{{ route('discount.status', $d->id) }}"
                                        class="badge badge-{{ $d->is_active ? 'success' : 'danger' }}">
                                        {{ $d->is_active ? 'Active' : 'Inactive' }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('discount.edit', $d->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="{{ route('discount.delete', $d->id) }}" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this discount code?')">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        @if ($discounts->isEmpty())
                            <tr>
                                <td colspan="8" class="text-center">No discount codes found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
