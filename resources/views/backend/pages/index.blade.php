@extends('backend.layouts.master')
@section('title', 'LIFWEL || Pages')
@section('main-content')

    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>

        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Page List</h6>
            <a href="{{ route('pages.create') }}" class="btn btn-success btn-sm" data-toggle="tooltip" title="Add New Page">
                <i class="fas fa-plus"></i> Add Page
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pages as $key => $page)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $page->title }}</td>
                                <td>{{ $page->slug }}</td>
                                <td>
                                    <span class="badge badge-{{ $page->status ? 'success' : 'danger' }}">
                                        {{ $page->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('pages.destroy', $page->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No pages found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
