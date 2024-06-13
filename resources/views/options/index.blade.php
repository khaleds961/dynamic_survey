@extends('layouts.master')
@section('title', 'Options')
@section('content')


    <!-- Flash message -->
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
                    <a href="#" class="text-info">Options</a>
                </li>
            </ol>


            <div class="mx-2">
                @if((Helper::check_permission(config('permissions.options'), 'write')))
                <a type="button" class="btn mb-1 waves-effect waves-light btn-light text-dark fs-4 mx-0 mx-md-2"
                    href="{{ route('options.create') }}">
                    <i class="ti ti-circle-plus"></i>
                    <span>Add New Options</span>
                </a>
                @endif
            </div>
        </div>
    </nav>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive rounded-2 my-2">
                    <div class="table-responsive mx-4">
                        <table id="options-list" class="table border table-striped table-bordered display text-nowrap">
                            <thead>
                                <!-- start row -->
                                <tr>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">#</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">icon</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">Question Ar</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">Question en</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">Option text ar</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">Option text en</h6>
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

            var table = $('#options-list').DataTable({
                processing: true,
                serverSide: true,
                scrollY: '100%',
                scrollCollapse: true,
                paging: true,
                responsive: true,
                ajax: "{{ route('options.index') }}",
                columns: [{
                        data: "id",
                        name: 'id'
                    },
                    {
                        data: 'icon',
                        name: 'icon',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "question_ar",
                        name: 'question_ar',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "question_en",
                        name: 'question_en',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "option_text_ar",
                        name: 'option_text_ar'
                    },
                    {
                        data: "option_text_en",
                        name: 'option_text_en'
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
                order: [
                    [0, 'desc']
                ],
            });


        });
    </script>
@endpush
