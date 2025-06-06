@extends('layouts.master')
@section('title', 'Fonts')
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
                    <a href="#" class="text-info">Fonts</a>
                </li>
            </ol>

            @if(Helper::check_permission(config('permissions.fonts'), 'write'))
            <div class="mx-2">
                <a type="button" class="btn mb-1 waves-effect waves-light btn-light text-dark fs-4 mx-0 mx-md-2"
                    href="{{ route('fonts.create') }}">
                    <i class="ti ti-circle-plus"></i>
                    <span>Add New Font</span>
                </a>
            </div>
            @endif

        </div>
    </nav>

    <div class="row mt-4">
        <div class="col-12">

            <div class="card">

                <div class="table-responsive rounded-2 my-2">
                    <div class="table-responsive mx-4">
                        <table id="fonts-list" class="table border table-striped table-bordered display text-nowrap">
                            <thead>
                                <!-- start row -->
                                <tr>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">#</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">title</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">normal</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">bold</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">light</h6>
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


            var table = $('#fonts-list').DataTable({
                processing: true,
                serverSide: true,
                scrollY: '100%',
                scrollCollapse: true,
                paging: true,
                responsive: true,
                ajax: "{{ route('fonts.index') }}",
                columns: [{
                        data: 'id',
                        id: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: "normal",
                        name: 'normal',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: "bold",
                        name: 'bold',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: "light",
                        name: 'light',
                        orderable: false,
                        searchable: false,
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
