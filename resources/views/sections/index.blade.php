@extends('layouts.master')
@section('title', 'Sections')
@section('content')

    @if (session('success'))
        <div id="flash-message" class="btn alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- BreadCrumbs --}}
    <nav aria-label="breadcrumb" class="mb-1">
        <div class="d-flex justify-content-between">
            <ol class="breadcrumb border border-warning px-3 py-2 rounded">
                <li class="breadcrumb-item">
                    <a href="{{ route('index') }}" class="text-info d-flex align-items-center"><i
                            class="ti ti-home fs-4 mt-1"></i></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#" class="text-info">Sections</a>
                </li>
            </ol>

            <div class="mx-2">
                <a type="button" class="btn mb-1 waves-effect waves-light btn-light text-dark fs-4 mx-0 mx-md-2"
                href="{{route('sections.create')}}">
                    <i class="ti ti-circle-plus"></i>
                    <span>Add New Section</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive rounded-2 my-2">
                    <div class="table-responsive mx-4">
                        <table id="sections-list" class="table border table-striped table-bordered display text-nowrap">
                            <thead>
                                <!-- start row -->
                                <tr>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">#</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">title ar</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">title en</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">description ar</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">description en</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">status</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">action</h6>
                                    </th>
                                </tr>
                                <!-- end row -->
                            </thead>
                            <tbody>
                                <!-- start row -->
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
    </div>
@endsection

@push('after-scripts')
    <script>
        $(document).ready(function() {

            var table = $('#sections-list').DataTable({
                processing: true,
                serverSide: true,
                scrollY: '100%',
                scrollCollapse: true,
                paging: true,
                responsive: true,
                ajax: "{{ route('sections.index') }}",
                columns: [{
                        data: 'id',
                        id: 'id'
                    },
                    {
                        data: "title_ar",
                        name: 'title_ar'
                    },
                    {
                        data: "title_en",
                        name: 'title_en'
                    },
                    {
                        data: "description_ar",
                        name: 'description_ar'
                    },
                    {
                        data: "description_en",
                        name: 'description_en'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        orderable: false
                    },
                ],
                order: [0, 'desc'],
            });

            //store section
            // $('#save_section').on('click', function(e) {
            //     e.preventDefault();
            //     var title = $('#title').val();
            //     var description = $('#description').val();

            //     if (title == undefined || title.length < 1) {
            //         $('#title_error').text('Title is required.').addClass('errors')
            //     } else {
            //         $('#title_error').text('').removeClass('errors')
            //     }

            //     if (description == undefined || description.length < 1) {
            //         $('#description_error').text('Description is required.').addClass('errors')
            //     } else {
            //         $('#description_error').text('').removeClass('errors')
            //     }

            //     if ($('.errors').length == 0) {
            //         $('#store_form').submit()
            //     }

            // })

            //show section
            // $(document).on('click', '.update-modal-button', function(e) {
            //     e.preventDefault();
            //     var title = $(this).data('title');
            //     var description = $(this).data('description');
            //     var section_id = $(this).data('id');
            //     console.log(title);
            //     console.log('hey');
            //     $('#section_id').val(section_id);
            //     $('#edit_title').val(title);
            //     $('#edit_description').val(description);
            // });

            // //update section
            // $(document).on('click', '#update_section', function(e) {
            //     e.preventDefault();
            //     var title = $('#edit_title').val();
            //     var description = $('#edit_description').val();

            //     if (title == undefined || title.length < 1) {
            //         $('#edit_title_error').text('Title is required.').addClass('edit_errors')
            //     } else {
            //         $('#edit_title_error').text('').removeClass('edit_errors')
            //     }

            //     if (description == undefined || description.length < 1) {
            //         $('#edit_description_error').text('Description is required.').addClass('edit_errors')
            //     } else {
            //         $('#edit_description_error').text('').removeClass('edit_errors')
            //     }

            //     if ($('.edit_errors').length == 0) {
            //         $('#update_form').submit()
            //     }

            // });


        });
    </script>
@endpush
