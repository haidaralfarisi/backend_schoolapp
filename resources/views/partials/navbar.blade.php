<!--  Header Start -->

<header class="app-header bg-white border-bottom">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                    <i class="ti ti-bell-ringing"></i>
                    <div class="notification bg-primary rounded-circle"></div>
                </a>
            </li>
        </ul>


        <!-- Search Bar -->
        <form class="d-flex mx-auto w-25 position-relative">
            <input class="form-control rounded-pill px-4" type="search" placeholder="Search..." aria-label="Search">
            <button class="btn position-absolute end-0 top-50 translate-middle-y me-2" type="submit">
                <i class="ti ti-search"></i>
            </button>
        </form>
        <!-- End Search Bar -->

        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover d-flex align-items-center dropdown-toggle" href="#"
                        id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="" width="35"
                            height="35" class="rounded-circle">
                        <span class="ms-2">Hi! {{ Auth::user()->fullname }}</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="drop2">
                        <li>
                            <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-user fs-6"></i>
                                <p class="mb-0 fs-3">My Profile</p>
                            </a>
                        </li>
                        <li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                            <a href="javascript:void(0)" onclick="document.getElementById('logout-form').submit();"
                                class="dropdown-item text-danger">
                                <i class="ti ti-logout fs-6"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!--  Header End -->
