@extends('backend.layouts.master')
@section('title', 'LifeWell || Products')
@section('main-content')


    <div class="card shadow mb-4">




        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>



        <div class="card-header py-3 d-flex flex-column flex-md-row justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Product Lists</h6>

            <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data"
                    class="d-flex align-items-center mr-2">
                    @csrf
                    <input type="file" name="file" required class="form-control-file form-control-sm mr-2">
                    <button class="btn btn-success btn-sm">Import</button>
                </form>


                <a href="{{ route('products.export') }}" class="btn btn-info btn-sm mr-2" data-toggle="tooltip"
                    data-placement="bottom" title="Export Products">
                    <i class="fas fa-file-export"></i> Export
                </a>

                <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm" data-toggle="tooltip"
                    data-placement="bottom" title="Add Product">
                    <i class="fas fa-plus"></i> Add Product
                </a>
            </div>
        </div>






        <div class="card-body">
            <div style="display: flex; justify-content: flex-end; margin-bottom: 10px;">
                <form id="searchingForm" method="GET" style="width: 300px;">
                    <div class="input-group">
                        <input type="text" class="form-control searching" name="query" placeholder="Search Titles..."
                            aria-label="Search" />
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">

                <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Is Featured</th>
                            <th>Brand</th>
                            <th>Photo</th>
                            <th>On Sale</th>
                            <th>Today Sale</th>
                            <th>Variants</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>S.N.</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Is Featured</th>
                            <th>Brand</th>
                            <th>Photo</th>
                            <th>On Sale</th>
                            <th>Today Sale</th>
                            <th>Variants</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody id="datatable-buttons">

                    </tbody>
                </table>
                <div class="d-flex justify-content-between mt-3">
                    <div id="pagination-info">
                    </div>
                    <div id="pagination-links">
                        <!-- Pagination links will be loaded here dynamically -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="specificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header specification-header">
                    <h5 class="modal-title" id="exampleModalLabel"><b>Specification</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <th></th>
                            <th></th>
                        </thead>
                        <tbody id="specificationData">

                        </tbody>
                    </table>
                    <!-- Full description will be displayed here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Use event delegation for dynamically added .dltBtn elements
            $(document).on('click', '.dltBtn', function(e) {
                e.preventDefault(); // Prevent default form submission
                var form = $(this).closest('form'); // Find closest form element
                var dataID = $(this).data('id'); // Get the data-id attribute value

                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this data!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit(); // Submit the form if user confirms
                        } else {
                            swal("Your data is safe!"); // Show safe message if user cancels
                        }
                    });
            });
        });
    </script>
    <script>
        var value = '';

        $(document).ready(function() {
            function fetch_data(search, page = 1) {

                $.ajax({
                    url: '{{ route('product.display') }}',
                    type: 'get',
                    data: {
                        search: search,
                        page: page // Send the current page number
                    },
                    success: function(response) {
                        if (response.status) {
                            $('#datatable-buttons').empty(); // Clear the table
                            console.log(response.data);
                            // Append the paginated data into the table
                            if (response.data.length > 0) {
                                var htmlData = '';
                                $.each(response.data, function(index, data) {
                                    let image = data.product_image ? assetUrl + data
                                        .product_image.image : null;
                                    htmlData += `<tr>
                                <td>${(response.currentPage - 1) * response.perPage + (index + 1)  }</td>
                                <td>${data.title_en}
                                </td>
                                <td>${data.cat_info ? data.cat_info.title_en : ''}
                                <sub>${data.sub_cat_info ? data.sub_cat_info.title_en : ''}</sub>
                                </td>
                                <td>${data.is_featured == 1 ? 'Yes' : 'No'}</td>
                                <td>${data.brand ? data.brand.title : ''}</td>
                                <td>${image ? `<img src="${image}" class="img-fluid" style="max-width:80px" alt="${image}">` : ''}</td>
                                <td>
                                    <label class="toggle-switch">
                                       <input type="checkbox" data-id="${data.id}" class="toggle-input" ${data.on_sale ? 'checked' : ''} />

                                        <span class="slider"></span>
                                    </label>
                                </td>
                                 <td>
                                    <label class="toggle-switch">
                                       <input type="checkbox" data-id="${data.id}" class="toggle-today_deal" ${data.deal_of_the_day ? 'checked' : ''} />

                                        <span class="slider"></span>
                                    </label>
                                </td>
                                <td>
                                    <div class="text-center">
                                    <a href="{{ url('admin/product-variant') }}/${data.id}" style="color: #007bff;" class="specification-link">
                                        View
                                    </a>
                                    </div>
                                </td>
                                <td>
                                 ${data.status == 'active'
                                      ? `<span class="badge badge-success">${data.status}</span>`
                                      : `<span class="badge badge-warning">${data.status}</span>`}
                                </td>
                                <td>
                                    <a href="{{ url('admin/product/') }}/${data.id}/edit" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="{{ url('admin/product') }}/${data.id}">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm dltBtn" data-id=${data.id} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>`;
                                });


                                // Build custom pagination links
                                generate_pagination(response.currentPage, response.totalPages, response
                                    .perPage, response.total);
                            } else {
                                htmlData = `<td>
                                         No Product found!!! Please create Product
                                      </td>`;
                            }
                            $('#datatable-buttons').append(htmlData);
                        }
                    }
                });

            }

            $(document).on('keyup', '.searching', function() {
                value = $(this).val();
                fetch_data(value, 1)

            })

            // Function to generate custom pagination links
            function generate_pagination(currentPage, totalPages, perPage, total) {
                $('#pagination-links').empty(); // Clear existing pagination links
                $('#pagination-info').empty();
                let paginationHtml = '<ul class="pagination">';

                // Previous button
                if (currentPage > 1) {
                    paginationHtml +=
                        `<li><a href="javascript:void(0);" class="pagination-link" data-page="${currentPage - 1}">Previous</a></li>`;
                } else {
                    paginationHtml += `<li class="disabled"><span>Previous</span></li>`;
                }

                // Page number buttons
                for (let i = 1; i <= totalPages; i++) {
                    if (i == currentPage) {
                        paginationHtml += `<li class="active"><span>${i}</span></li>`;
                    } else {
                        paginationHtml +=
                            `<li><a href="javascript:void(0);" class="pagination-link" data-page="${i}">${i}</a></li>`;
                    }
                }

                // Next button
                if (currentPage < totalPages) {
                    paginationHtml +=
                        `<li><a href="javascript:void(0);" class="pagination-link" data-page="${parseInt(currentPage) + 1}">Next</a></li>`;
                } else {
                    paginationHtml += `<li class="disabled"><span>Next</span></li>`;
                }

                paginationHtml += '</ul>';
                var startRecord = (currentPage - 1) * perPage + 1;
                var endRecord = Math.min(currentPage * perPage,
                    total); // Ensures the last record doesn't exceed total
                var info = `Showing ${startRecord} to ${endRecord} of ${total}`;
                $('#pagination-info').html(info);
                if (total > perPage) {
                    $('#pagination-links').html(paginationHtml);
                }
            }

            // Event delegation for pagination links
            $(document).on('click', '.pagination-link', function() {
                var page = $(this).data('page');
                fetch_data(value, page);
            });

            $(document).ready(function() {

                fetch_data(value, 1);
            });

        });
        $(document).ready(function() {

            $(document).on('change', '.toggle-input', function() {
                var status = $(this).is(':checked') ? 1 : 0;
                var id = $(this).data('id');
                $.ajax({
                    url: '{{ route('update.Sales') }}',
                    type: 'get',
                    data: {
                        status: status,
                        id: id, // Send the current page number
                    },
                    success: function(response) {

                    },
                    error: function() {

                    }
                });
            });
            $(document).on('change', '.toggle-today_deal', function() {
                var today_deal = $(this).is(':checked') ? 1 : 0;
                var id = $(this).data('id');
                $.ajax({
                    url: '{{ route('update.Sales') }}',
                    type: 'get',
                    data: {
                        today_deal: today_deal,
                        id: id, // Send the current page number
                    },
                    success: function(response) {

                    },
                    error: function() {

                    }
                });
            });
        });
        // $(document).on('click', '.specification-link', function() {
        //         let specification = $(this).data('specification');
        //         $('#specificationData').empty();
        //         var html_data = "";
        //         $.each(specification, function(index, data) {
        //             var type = data.type ? data.type.split(',') : []; // Ensure 'type' is an array even if null
        //             html_data += `<tr><td>${data.name}</td><td>`;

        //             type.forEach(function(item) {
        //                 html_data += `<div class="amenity-tab m-1">${item.trim()}</div>`;
        //             });

        //             html_data += `</td></tr>`;
        //         });

        //         $('#specificationData').append(html_data);

        //         $('#specificationModal').modal('show');
        //     });
        $(document).on('submit', '#searchingForm', function(e) {
            e.preventDefault();
        })
    </script>
@endpush
