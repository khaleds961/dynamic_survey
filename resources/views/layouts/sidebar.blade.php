<!-- Sidebar Start -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('index') }}" class="text-nowrap logo-img mx-2">
                <img src="{{ asset('images/logos/logo.jpg') }}" class="dark-logo my-2" width="180" alt="" />
                {{-- <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/light-logo.svg"
                    class="light-logo" width="180" alt="" /> --}}
            </a>
            <div class="close-btn d-lg-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar mt-3" data-simplebar>
            <ul id="sidebarnav">
                <x-sidebar-item :routes="['index','users.index', 'users.edit', 'users.create', 'users.show','users.create']" icon="ti ti-users" title="Users" />
                <x-sidebar-item :routes="['surveys.index', 'surveys.edit', 'surveys.create', 'surveys.show','surveysections.create']" icon="ti ti-gauge" title="Surveys" />
                <x-sidebar-item :routes="['sections.index', 'sections.edit', 'sections.create','sections.show']" icon="ti ti-box-model" title="Sections" />
                <x-sidebar-item :routes="['questions.index', 'questions.edit', 'questions.create','questions.show']" icon="ti ti-message-question" title="Questions" />
                <x-sidebar-item :routes="['options.index', 'options.edit', 'options.create']" icon="ti ti-circles-relation" title="Options" />
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!--  Sidebar End -->
