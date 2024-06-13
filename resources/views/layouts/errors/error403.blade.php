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
    <link  id="themeColors"  rel="stylesheet" href="{{asset('dist/css/style.css')}}" />
  </head>
  <body>

    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" style="background-color: #332851">
      <div class="position-relative overflow-hidden min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
          <div class="row justify-content-center w-100">
            <div class="col-lg-4">
              <div class="text-center ">
                <img src="{{asset('images/error/error_403.png')}}" alt="" class="img-fluid my-3">
                <h1 class="fw-semibold mb-7 fs-9 text-white">Opps!!!</h1>
                <h4 class="fw-semibold mb-7 text-white">{{$message}}</h4>
                @if($route)
                <a class="btn btn-danger" style="background: #4c5b70;" href="{{$route}}" role="button">Go Back to Home</a>
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