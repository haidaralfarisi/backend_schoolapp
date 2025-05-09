@php
    $user = Auth::user();
    $isSuperAdmin = $user->level === 'SUPERADMIN';
@endphp

<!-- Sidebar Start -->
<aside class="left-sidebar" style="background-color: #fbfbfb">

    <!-- Sidebar scroll-->
    <div class="p-2">
        <div class="d-flex align-items-center justify-content-between">
            <!-- Logo dan Brand -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('superadmin.dashboard') }}">
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

                <!-- Dashboard -->
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('superadmin.dashboard') }}" aria-expanded="false">
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
                        'superadmin.schools.index',
                        'superadmin.students.index',
                        'students.search',
                        'superadmin.lsplans.index',
                        'superadmin.kelas.index', // contoh lainnya
                    ]);
                @endphp

                <!-- Schools -->
                <li class="sidebar-item {{ $isActive ? 'nav-active' : '' }}">
                    <a class="sidebar-link" href="{{ route('superadmin.schools.index') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:layers-minimalistic-bold-duotone"
                                class="fs-6 {{ $isActive ? 'text-white' : '' }}"></iconify-icon>
                        </span>
                        <span class="hide-menu {{ $isActive ? 'text-white' : '' }}">Schools</span>
                    </a>
                </li>


                <!-- Users -->
                @php
                    $isUserActive = request()->routeIs('superadmin.users.index') || request()->routeIs('users.search');
                @endphp

                <li class="sidebar-item {{ $isUserActive ? 'nav-active' : '' }}">
                    <a class="sidebar-link {{ $isUserActive ? 'active' : '' }}"
                        href="{{ route('superadmin.users.index') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:user-plus-rounded-bold-duotone"
                                class="fs-6 {{ $isUserActive ? 'text-white' : '' }}"></iconify-icon>
                        </span>
                        <span class="hide-menu {{ $isUserActive ? 'text-white' : '' }}">Teachers</span>
                    </a>
                </li>


                @php
                    $isParentActive =
                        request()->routeIs('superadmin.parent.index') || request()->routeIs('parents.search');
                @endphp

                <li class="sidebar-item {{ $isParentActive ? 'nav-active' : '' }}">
                    <a class="sidebar-link" href="{{ route('superadmin.parent.index') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="material-symbols:supervised-user-circle-outline"
                                class="fs-6 {{ $isParentActive ? 'text-white' : '' }}"></iconify-icon>
                        </span>
                        <span class="hide-menu {{ $isParentActive ? 'text-white' : '' }}">Parents</span>
                    </a>
                </li>

                

                <!-- Manage User School (Hanya untuk SUPERADMIN) -->
                @if ($isSuperAdmin)
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('superadmin.manage-userschools') ? 'active' : '' }}"
                            href="{{ route('superadmin.manage-userschools') }}" aria-expanded="false">

                            {{-- <a class="sidebar-link" href="{{ route('superadmin.manage-userschools') }}"
                            aria-expanded="false"> --}}
                            <span>
                                <iconify-icon icon="mdi:settings" class="fs-6"></iconify-icon>
                            </span>
                            <span class="hide-menu">Manage</span>
                        </a>
                    </li>
                @endif

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('superadmin.ereports.index') ? 'active' : '' }}"
                        href="{{ route('superadmin.ereports.index') }}" aria-expanded="false">

                        {{-- <a class="sidebar-link" href="{{ route('superadmin.parent.index') }}" aria-expanded="false"> --}}
                        <span>
                            <iconify-icon icon="material-symbols:book-2-outline" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">E-reports</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('superadmin.thajaran.index') ? 'active' : '' }}"
                        href="{{ route('superadmin.thajaran.index') }}" aria-expanded="false">

                        {{-- <a class="sidebar-link" href="{{ route('superadmin.parent.index') }}" aria-expanded="false"> --}}
                        <span>
                            <iconify-icon icon="material-symbols:calendar-month-outline" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">School Years</span>
                    </a>
                </li>

                <!-- Users -->
                {{-- <li class="sidebar-item">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:user-plus-rounded-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Classes</span>
                    </a>
                </li> --}}

                <!-- Menu Content -->
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-6"
                        class="fs-6"></iconify-icon>
                    <span class="hide-menu">Content</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('superadmin.photos.index') ? 'active' : '' }} d-flex align-items-center gap-2"
                        href="{{ route('superadmin.photos.index') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:gallery-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Photos</span>
                    </a>
                </li>


                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('superadmin.videos.index') ? 'active' : '' }}"
                        href="{{ route('superadmin.videos.index') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:play-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Videos</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('superadmin.schoolInfo.index') ? 'active' : '' }}"
                        href="{{ route('superadmin.schoolInfo.index') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="mdi:building" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">School Info</span>
                    </a>
                </li>

                <li class="sidebar-item mb-5">
                    <a class="sidebar-link {{ request()->routeIs('superadmin.delight.index') ? 'active' : '' }}"
                        href="{{ route('superadmin.delight.index') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:user-plus-rounded-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Delight</span>
                    </a>
                </li>
            </ul>

        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!--  Sidebar End -->
