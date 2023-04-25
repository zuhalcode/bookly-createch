<!-- Header Start -->
@if (request()->is('products/*') || request()->is('orders') || request()->is('order-success'))
    <header class="header-common ">
    @else
        <header class="header-common header4 header4LogoChange">
@endif
<div class="container-lg">
    <div class="nav-wrap">
        <!-- Navigation Start -->
        <nav class="navigation">
            <div class="nav-section">
                <div class="header-section">
                    <div class="navbar navbar-expand-xl navbar-light navbar-sticky p-0">
                        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#primaryMenu" aria-controls="primaryMenu">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <a href={{ url('/') }} class="logo-link">
                            <img class="logo" src={{ asset($logo) }} alt="logo" />
                        </a>

                        <div class="offcanvas offcanvas-collapse order-lg-2" id="primaryMenu">
                            <div class="offcanvas-header navbar-shadow">
                                <h5 class="mt-1 mb-0">Menu</h5>
                                <button class="btn-close lead" type="button" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <!-- Menu-->
                                <ul class="navbar-nav">
                                    <!-- Home -->
                                    <li class="nav-item">
                                        <a class="nav-link" href={{ url('/') }}>Home</a>
                                    </li>

                                    @if (auth()->check())
                                        @if (auth()->user()->role->name === 'admin' || auth()->user()->role->name === 'super-admin')
                                            <li class="nav-item">
                                                <a class="nav-link" href={{ url('/dashboard') }}>Dashboard</a>
                                            </li>
                                        @else
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    href={{ url('/dashboard/order-detail') }}>Dashboard</a>
                                            </li>
                                        @endif

                                        <li class="nav-item" style="cursor: pointer">
                                            <form id="logout-form-nav" action={{ url('/auth/logout') }} method="post">
                                                @csrf
                                                <div class="nav-link" onclick="handleLogout('logout-form-nav')">
                                                    Logout
                                                </div>
                                            </form>
                                        </li>
                                    @else
                                        <!-- Auth -->
                                        <li class="nav-item">
                                            <a class="nav-link" href={{ url('/auth/login') }}>Login</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href={{ url('/auth/register') }}>Register</a>
                                        </li>
                                        {{-- End Auth --}}
                                    @endif

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Navigation End -->
    </div>
</div>
</header>
<!-- Header End -->
