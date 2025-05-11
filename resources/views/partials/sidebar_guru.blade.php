<!-- Sidebar Start -->
<aside class="left-sidebar" style="background-color: #fbfbfb">
    <div class="p-3">
        <div class="d-flex align-items-center justify-content-between">
            <!-- Logo dan Brand -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('guru.dashboard') }}">
                <img src="{{ asset('assets/images/logos/logo.png') }}" height="60" class="me-2 mt-2 ps-2" alt="">
                <div class="fw-bolder fs-6">Dian Didaktika</div>
            </a>

            <!-- Tombol Close di sebelah logo, muncul hanya di layar kecil -->
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-7"></i>
            </div>
        </div>

        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">

                <!-- String HOME -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                    <span class="hide-menu">Home</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}"
                        href="{{ route('guru.dashboard') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:home-smile-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <!-- String Daily Use -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                    <span class="hide-menu">Daily Use</span>
                </li>

                <!-- Menu Dashboard -->

                @php
                    $isActive = in_array(Route::currentRouteName(), [
                        'guru.classes.index',
                        'guru.students.index',
                        'guru.lsplans.index',
                    ]);
                @endphp

                <!-- Schools -->
                <li class="sidebar-item {{ $isActive ? 'nav-active' : '' }}">
                    <a class="sidebar-link" href="{{ route('guru.classes.index') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:layers-minimalistic-bold-duotone"
                                class="fs-6 {{ $isActive ? 'text-white' : '' }}"></iconify-icon>
                        </span>
                        <span class="hide-menu {{ $isActive ? 'text-white' : '' }}">Classes</span>
                    </a>
                </li>


                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('guru.photos.index') ? 'active' : '' }}"
                        href="{{ route('guru.photos.index') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:home-smile-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Photos</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('guru.ereports.index') ? 'active' : '' }}"
                        href="{{ route('guru.ereports.index') }}" aria-expanded="false">

                        {{-- <a class="sidebar-link" href="{{ route('superadmin.parent.index') }}" aria-expanded="false"> --}}
                        <span>
                            <iconify-icon icon="material-symbols:book-2-outline" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">E-Raport</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!--  Sidebar End -->
