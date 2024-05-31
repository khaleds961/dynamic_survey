<head>
    <!--  Title -->
    <title>Dynamic Survey | @yield('title')</title>

    <!--  Required Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Mordenize" />
    <meta name="author" content="" />
    <meta name="keywords" content="Mordenize" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">

    <!--  Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon/icon.jpg') }}" />

    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="{{ asset('dist/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}">

    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href="{{ asset('dist/css/style.css') }}" />

    {{-- Select 2 --}}
    <link rel="stylesheet" href="{{ asset('dist/libs/select2/dist/css/select2.min.css') }}">

    <!-- Prism Js -->
    <link rel="stylesheet" href="{{ asset('dist/libs/prismjs/themes/prism.min.css') }}">

    {{-- Switch --}}
    <link rel="stylesheet"
        href="{{ asset('dist/libs/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}">

    {{-- Dropify --}}
    <link rel="stylesheet" href="{{ asset('dist/libs/dropify/css/dropify.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/libs/dropify/css/dropify.min.css') }}">

    {{-- SweetAlert --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.7/css/intlTelInput.css" rel="stylesheet">

    {{-- App Css --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    
    <!-- RowReorder CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.3/css/rowReorder.dataTables.min.css">
</head>
