@extends('layouts.master')
@section('title', 'Permissions')
@section('content')

    {{-- BreadCrumbs --}}
    <nav aria-label="breadcrumb" class="mb-1">
        <ol class="breadcrumb border border-warning px-3 py-2 rounded">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}" class="text-warning d-flex align-items-center"><i
                        class="ti ti-home fs-4 mt-1"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('roles.index') }}" class="text-warning d-flex align-items-center">
                    Roles
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="#" class="text-warning">{{ $role_title }}</a>
            </li>
        </ol>
    </nav>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>
                    <h6 class="fs-4 fw-semibold mb-0 text-uppercase">Roles</h6>
                </th>
                <th>
                    <h6 class="fs-4 fw-semibold mb-0 text-uppercase">all permissions</h6>
                </th>
                <th>
                    <h6 class="fs-4 fw-semibold mb-0 text-uppercase">read</h6>
                </th>
                <th>
                    <h6 class="fs-4 fw-semibold mb-0 text-uppercase">write</h6>
                </th>
                <th>
                    <h6 class="fs-4 fw-semibold mb-0 text-uppercase">update</h6>
                </th>
                <th>
                    <h6 class="fs-4 fw-semibold mb-0 text-uppercase">delete</h6>
                </th>
            </tr>
        </thead>
        <form  method="post" id="permission_form" action="{{ route('roles.update_store') }}">
            @csrf
            <tbody>
                @foreach ($permissions as $index => $permission)
                    <tr>
                        <td>{{ $permission->title }}</td>
                        <td>
                            <span class="d-flex">
                                <span class="mx-2">All</span>
                                <input type="checkbox" class="form-check-input all_checkbox" data-id="{{ $index }}"
                                    id="all{{ $index }}" 
                                    {{ $permission->read && $permission->write && $permission->update && $permission->delete ? 'checked' : '' }}/>
                            </span>
                        </td>
                        <td>
                            <span class="d-flex">
                                <span class="mx-2">Read</span>
                                <input type="hidden" name="role_id" value="{{ $id }}">
                                <input type="hidden" name="id[{{ $index }}]" value="{{ $permission->permission_id ? $permission->permission_id : $permission->id }}">
                                <input type="checkbox" name="read[{{ $index }}]" class="form-check-input"
                                    id="read{{ $index }}" {{ $permission->read ? 'checked' : '' }} />
                            </span>
                        </td>
                        <td>   
                            <span class="d-flex">
                                <span class="mx-2">Write</span>
                                <input type="checkbox" name="write[{{ $index }}]" class="form-check-input"
                                    id="write{{ $index }}" {{ $permission->write ? 'checked' : '' }} />
                            </span>
                        </td>
                        <td>
                            <span class="d-flex">
                                <span class="mx-2">Update</span>
                                <input type="checkbox" name="update[{{ $index }}]" class="form-check-input"
                                    id="update{{ $index }}" {{ $permission->update ? 'checked' : '' }} />
                            </span>
                        </td>
                        <td>
                            <span class="d-flex">
                                <span class="mx-2">Delete</span>
                                <input type="checkbox" name="delete[{{ $index }}]" class="form-check-input"
                                    id="delete{{ $index }}" {{ $permission->delete ? 'checked' : '' }} />
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
    </table>

    <div class="my-3 d-md-flex justify-content-end">
        <button class="btn btn-success" type="submit" id="save">Update</button>
    </div>
    </form>

@endsection


@push('after-scripts')
    <script>
        $(document).ready(function() {

            $(document).on('click', '.all_checkbox', function(e) {
                var index = $(this).data('id');
                if ($(this).is(':checked')) {
                    $(`#read${index}, #write${index}, #update${index},#delete${index}`).prop('checked',
                        true);
                } else {
                    $(`#read${index}, #write${index}, #update${index},#delete${index}`).prop('checked',
                        false);
                }
            });

        });
    </script>
@endpush
