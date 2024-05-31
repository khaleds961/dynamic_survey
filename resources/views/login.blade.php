<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/main/authentication-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 23 May 2023 12:21:19 GMT -->

<head>
    <!--  Title -->
    <title>Dynamic Surveys</title>

    <!--  Required Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Mordenize" />
    <meta name="author" content="" />
    <meta name="keywords" content="Mordenize" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!--  Favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon/icon.png') }}" />
    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href="{{ asset('dist/css/style.css') }}" />
    <!-- App Css -->
    <link id="themeColors" rel="stylesheet" href="{{ asset('css/app.css') }}" />
</head>

<body>

    <!-- Preloader -->
    <div class="preloader">
        {{-- <img src="{{ asset('images/logos/logo-black.png') }}" alt="loader" class="lds-ripple img-fluid" /> --}}
        <div class="spinner-grow lds-ripple img-fluid text-info" style="width: 5rem; height: 5rem" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <!-- Preloader -->
    <div class="preloader">
        {{-- <img src="{{ asset('images/logos/logo-black.png') }}" alt="loader" class="lds-ripple img-fluid" /> --}}
        <div class="spinner-grow lds-ripple img-fluid text-info" style="width: 5rem; height: 5rem" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100">
            <div class="position-relative z-index-5">
                <div class="row">
                    <div class="col-xl-7 col-xxl-8">

                        <div class="d-none d-xl-flex align-items-center justify-content-center"
                            style="height: calc(100vh - 80px);">
                            <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/backgrounds/login-security.svg"
                                alt="" class="img-fluid" width="500">
                        </div>
                    </div>
                    <div class="col-xl-5 col-xxl-4">
                        <div
                            class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">

                            <div class="d-flex justify-content-center">
                                {{-- <img src="{{ asset('images/logos/logo.jpg') }}" alt="" class="img-fluid"
                                    width="400"> --}}
                            </div>

                            <div class="col-sm-8 col-md-6 col-xl-9">
                                <h2 class="mb-3 fs-7 fw-bolder">Welcome to Surveys</h2>
                                <p class=" mb-9">Your Admin Dashboard</p>

                                <form class="mt-16" action="{{ route('login') }}" method="post">
                                    @method('POST') @csrf
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Username" type="text"
                                            name="email" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>



                                    {{-- <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1"
                                            placeholder="Password" name="password" value="{{ old('password') }}">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div> --}}

                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="exampleInputPassword1"
                                                placeholder="Password" name="password" value="{{ old('password') }}">
                                            <button class="btn btn-outline-primary" type="button"
                                                id="loginTogglePassword">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                    </div>
                                    <button type="submit" class="btn button_style w-100 py-8 mb-4 rounded-2">Sign
                                        In</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!--  Import Js Files -->
    @include('layouts.foot')

</body>

<!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/main/authentication-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 23 May 2023 12:21:19 GMT -->

</html>
