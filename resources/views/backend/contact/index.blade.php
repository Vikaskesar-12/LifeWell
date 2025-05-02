@extends('backend.layouts.master')
@section('title', 'LIFWEL || Brand Page')
@section('main-content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left">Contact Us List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div style="display: flex; justify-content: flex-end; margin-bottom: 10px;">
                    <form id="searchingForm" method="GET" style="width: 300px;">
                        <div class="input-group">
                            <input type="text" class="form-control searching" name="query"
                                placeholder="Search title..." aria-label="Search" />
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>S.N.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
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
@endsection

@push('styles')
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
        let assetUrl = "{{ asset('') }}";
        var value = '';

        $(document).ready(function() {
            function fetch_data(search, page = 1) {

                $.ajax({
                    url: '{{ route('contact.display') }}',
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
                                    let image = assetUrl + data.photo;
                                    console.log(image);
                                    htmlData += `<tr>
                                <td>${index + 1}</td>
                                <td>${data.first_name + ' ' + data.last_name}
                                </td>
                                <td>${data.email}
                                </td>
                                <td>${data.message}
                                
                            </tr>`;
                                });


                                // Build custom pagination links
                                generate_pagination(response.currentPage, response.totalPages, response
                                    .perPage, response.total);
                            } else {
                                htmlData = `<td>
                                         No details found!!!
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
        $(document).on('submit', "#searchingForm", function(e) {
            e.preventDefault();
        })
    </script>
@endpush
