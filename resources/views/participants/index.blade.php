@extends('layouts.master')
@section('title', 'Participants')
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
                    <a href="#" class="text-info">Participants</a>
                </li>
            </ol>
        </div>
    </nav>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive rounded-2 my-2">
                    <div class="table-responsive mx-4">
                        <table id="participants-list" class="table border table-striped table-bordered display text-nowrap">
                            <thead>
                                <!-- start row -->
                                <tr>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">#</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">name</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">email</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">survey</h6>
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

            var table = $('#participants-list').DataTable({
                processing: true,
                serverSide: true,
                scrollY: '100%',
                scrollCollapse: true,
                paging: true,
                responsive: true,
                ajax: "{{ route('participants.index') }}",
                columns: [
                    {
                        data: "id",
                        id: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: "email",
                        name: 'email'
                    },
                    {
                        data: "survey",
                        name: 'survey'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        orderable: false
                    },
                ],
            });

        });
    </script>
@endpush
