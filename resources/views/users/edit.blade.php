@extends('layouts.master')
@section('title', 'Edit')
@section('content')

    {{-- BreadCrumbs --}}
    <nav aria-label="breadcrumb" class="mb-1">
        <ol class="breadcrumb border border-warning px-3 py-2 rounded">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}" class="text-info d-flex align-items-center"><i
                        class="ti ti-home fs-4 mt-1"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}" class="text-info">Users</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#" class="text-info">Edit User</a>
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="my-4">
            <form action="{{ route('users.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="name">Name</label><span class="text-danger">*</span>
                        <input type='text' class="form-control resize-none" id="name" rows="3"
                            name="name" value="{{old('name',$user->name)}}" />
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="email">Email</label><span class="text-danger">*</span>
                        <input type='email' class="form-control resize-none" id="email" rows="3"
                            name="email" value="{{ old('email',$user->email) }}" />
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- hidden --}}
                    <input type="hidden" value="{{$user->id}}" name="id">

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" autocomplete="off"
                                placeholder="Password" name="password" value="{{ old('password') }}" >
                            <button class="btn btn-outline-primary" type="button"
                                id="loginTogglePassword">
                                <i class="ti ti-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label class="form-label" for="role_id">Roles</label><span class="text-danger">*</span>
                        <select class="form-control" id="role_id" name="role_id">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                </div>

                <button type="submit" class="btn btn-primary">Update</button>

            </form>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script>
        $(document).ready(function() {
            $("#loginTogglePassword").click(function() {
                var passwordInput = $("#password");
                var passwordIcon = $("#loginTogglePassword i");

                if (passwordInput.attr("type") === "password") {
                    passwordInput.attr("type", "text");
                    passwordIcon.removeClass("ti-eye").addClass("ti-eye-closed");
                } else {
                    passwordInput.attr("type", "password");
                    passwordIcon.removeClass("ti-eye-closed").addClass("ti-eye");
                }
            });
        });
    </script>
@endpush
