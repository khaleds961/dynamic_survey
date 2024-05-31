@include('layouts.head')

<body id="foo">
    
    <!-- Preloader -->
    <div class="preloader">
        {{-- <img src="{{asset('images/logos/logo-black.png')}}" alt="loader" class="lds-ripple img-fluid" /> --}}
    <div class="spinner-grow lds-ripple img-fluid text-info" style="width: 5rem; height: 5rem" role="status">
        <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Preloader -->
    <div class="preloader">
        {{-- <img src="{{asset('images/logos/logo-black.png')}}" alt="loader" class="lds-ripple img-fluid" /> --}}
        <div class="spinner-grow lds-ripple img-fluid text-info" style="width: 5rem; height: 5rem" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
    </div>

    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-theme="blue_theme" data-layout="vertical" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <!-- Sidebar Start -->
        @include('layouts.sidebar')
        <!--  Sidebar End -->

        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            @include('layouts.header')
            <!--  Header End -->
            <div class="full-container" style="padding: 5rem 1rem;">
                @yield('content')
            </div>
        </div>
    </div>

    <!--  Shopping Cart -->
    {{-- @include('layouts.shopping_cart') --}}

    <!--  Mobilenavbar -->
    {{-- @include('layouts.mobilenav') --}}

    <!--  Search Bar -->
    @include('layouts.searchbar')

    <!--  Customizer setting button -->
    @include('layouts.setting_button')

    <!--  Customizer Foot -->
    @include('layouts.foot')

</body>

</html>
