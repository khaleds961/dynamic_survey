@extends('layouts.master')
@section('title', 'Surveys')
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
                    <a href="#" class="text-info">Surveys</a>
                </li>
            </ol>


            <div class="mx-2">
                <a type="button" class="btn mb-1 waves-effect waves-light btn-light text-dark fs-4 mx-0 mx-md-2"
                    href="{{ route('surveys.create') }}">
                    <i class="ti ti-circle-plus"></i>
                    <span>Add New Survey</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="row mt-4">
        <div class="col-12">
            {{-- <div class="row">
                <div class="col-md-2">
                    <div class="mb-3 has-success">
                        <label class="control-label">FROM</label>
                        <input type="date" class="form-control" id="start_date">
                        <span id="start_date_error"></span>
                    </div>
                </div>
                <!--/span-->
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="control-label">TO</label>
                        <input type="date" class="form-control" id="end_date">
                        <span id="end_date_error"></span>
                    </div>
                </div>
                <!--/span-->

                <div class="col-md-6">
                    <button class="btn btn-dark margin_top_responsive" id="search_bookings">
                        <i class="ti ti-search"></i>
                        <span>Search</span>
                    </button>

                    <button class="btn btn-primary margin_top_responsive mx-2" id="clear_bookings">
                        <i class="ti ti-brush"></i>
                        <span>Clear Dates</span>
                    </button>
                </div>
            </div> --}}

            <div class="card">

                <div class="card-body">


                </div>

                <div class="table-responsive rounded-2 my-2">
                    <div class="table-responsive mx-4">
                        <table id="surveys-list" class="table border table-striped table-bordered display text-nowrap">
                            <thead>
                                <!-- start row -->
                                <tr>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">#</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">date</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">logo</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">title</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">language</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">main color</h6>
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

            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });


            var table = $('#surveys-list').DataTable({
                processing: true,
                serverSide: true,
                scrollY: '100%',
                scrollCollapse: true,
                paging: true,
                responsive: true,
                ajax: "{{ route('surveys.index') }}",
                columns: [{
                        data: 'id',
                        id: 'id'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: "logo",
                        name: 'logo',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: "title",
                        name: 'title'
                    },
                    {
                        data: 'language',
                        name: 'language'
                    },
                    {
                        data: 'mainColor',
                        name: 'mainColor'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active'
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

        });
    </script>
@endpush
