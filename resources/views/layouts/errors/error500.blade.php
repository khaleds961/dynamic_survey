<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/main/authentication-error.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 23 May 2023 12:21:19 GMT -->

<head>
    <!--  Title -->
    <title>Error</title>
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
</head>

<body>

    <!--  Body Wrapper -->
    <div class="page-wrapper bg-warning" id="main-wrapper" data-layout="vertical" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-lg-4">
                        <div class="text-center ">
                            @if($route)
                            <a href="{{ $route }}">
                                <img src="{{ asset('/images/error/error_500.jpg') }}" alt=""
                                    class="img-fluid my-3">
                            </a>
                            @else
                            <h4 class="text-white">Error: Something goes wrong !</h4>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  Import Js Files -->
    @include('layouts.foot')
</body>

<!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/main/authentication-error.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 23 May 2023 12:21:19 GMT -->

</html>
