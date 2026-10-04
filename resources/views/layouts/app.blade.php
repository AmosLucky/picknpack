<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title', 'Dashboard') - PICKnPACK
    </title>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <style>
        :root {
            --sidebar-width: 252px;
            --sidebar-collapsed-width: 72px;
            --sidebar-bg: #1f2a3a;
            --sidebar-hover: #2d394b;
            --sidebar-active: #4f46e5;
            --body-bg: #f4f6f9;
            --header-height: 64px;
            --footer-height: 52px;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            margin: 0;
            background: var(--body-bg);
            font-family:
                Inter,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
            color: #172033;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR
        |--------------------------------------------------------------------------
        */

        .app-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;

            width: var(--sidebar-width);

            background: var(--sidebar-bg);
            color: #fff;

            z-index: 1040;

            transition:
                width 0.25s ease,
                transform 0.25s ease;

            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            height: var(--header-height);

            display: flex;
            align-items: center;

            padding: 0 14px;

            border-bottom: 1px solid rgba(255,255,255,.10);

            flex-shrink: 0;
        }

        .sidebar-brand-text {
            font-size: 23px;
            font-weight: 800;
            letter-spacing: -0.5px;
            white-space: nowrap;
        }

        .sidebar-brand-icon {
            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-right: 10px;

            font-size: 22px;
        }

        .sidebar-menu {
            padding: 16px 12px;

            overflow-y: auto;
            overflow-x: hidden;

            flex: 1;
        }

        .sidebar-link {
            display: flex;
            align-items: center;

            min-height: 42px;

            padding: 0 13px;
            margin-bottom: 4px;

            border-radius: 8px;

            color: #dbe2ec;
            text-decoration: none;

            font-size: 14px;
            font-weight: 600;

            transition: all .15s ease;
        }

        .sidebar-link:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }

        .sidebar-link.active {
            background: var(--sidebar-active);
            color: #fff;
        }

        .sidebar-link i {
            width: 24px;

            margin-right: 10px;

            font-size: 16px;

            text-align: center;

            flex-shrink: 0;
        }

        .sidebar-link .menu-arrow {
            margin-left: auto;
            margin-right: 0;

            width: auto;

            transition: transform .2s ease;
        }

        .sidebar-link[aria-expanded="true"] .menu-arrow {
            transform: rotate(180deg);
        }

        .sidebar-submenu {
            padding-left: 34px;
        }

        .sidebar-submenu .sidebar-link {
            min-height: 38px;

            font-size: 13px;
            font-weight: 500;
        }

        .sidebar-footer {
            padding: 16px;

            border-top: 1px solid rgba(255,255,255,.10);

            color: #aeb8c7;
            font-size: 12px;

            text-align: center;

            flex-shrink: 0;
        }


        /*
        |--------------------------------------------------------------------------
        | MAIN AREA
        |--------------------------------------------------------------------------
        */

        .app-wrapper {
            min-height: 100vh;

            margin-left: var(--sidebar-width);

            display: flex;
            flex-direction: column;

            transition: margin-left .25s ease;
        }

        .app-header {
            height: var(--header-height);

            background: #fff;

            border-bottom: 1px solid #e5e7eb;

            display: flex;
            align-items: center;

            padding: 0 24px;

            position: sticky;
            top: 0;

            z-index: 1000;
        }

        .sidebar-toggle {
            border: 0;
            background: transparent;

            width: 40px;
            height: 40px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 8px;

            color: #334155;

            font-size: 20px;
        }

        .sidebar-toggle:hover {
            background: #f1f5f9;
        }

        .header-title {
            font-size: 16px;
            font-weight: 600;

            margin-left: 8px;

            color: #172033;
        }

        .header-user {
            margin-left: auto;
        }

        .header-user-button {
            border: 0;
            background: transparent;

            display: flex;
            align-items: center;
            gap: 8px;

            color: #334155;

            font-size: 14px;
            font-weight: 500;
        }

        .header-user-button:hover {
            color: #111827;
        }

        .user-avatar {
            width: 34px;
            height: 34px;

            border-radius: 50%;

            background: #eef2ff;
            color: #4f46e5;

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: 700;
        }


        /*
        |--------------------------------------------------------------------------
        | CONTENT
        |--------------------------------------------------------------------------
        */

        .app-content {
            flex: 1;

            padding: 28px;

            width: 100%;
        }

        .page-heading {
            margin-bottom: 24px;
        }

        .page-heading h1 {
            font-size: 24px;
            font-weight: 700;

            margin-bottom: 4px;
        }

        .page-heading p {
            color: #64748b;
            margin-bottom: 0;
        }


        /*
        |--------------------------------------------------------------------------
        | FOOTER
        |--------------------------------------------------------------------------
        */

        .app-footer {
            min-height: var(--footer-height);

            background: #fff;

            border-top: 1px solid #e5e7eb;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #64748b;

            font-size: 13px;
        }


        /*
        |--------------------------------------------------------------------------
        | CARDS
        |--------------------------------------------------------------------------
        */

        .dashboard-card {
            background: #fff;

            border: 1px solid #e2e8f0;

            border-radius: 9px;

            padding: 24px;

            height: 100%;

            box-shadow: 0 1px 2px rgba(0,0,0,.03);
        }

        .dashboard-card h5 {
            font-weight: 700;
        }


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR COLLAPSED
        |--------------------------------------------------------------------------
        */

        body.sidebar-collapsed .app-sidebar {
            width: var(--sidebar-collapsed-width);
        }

        body.sidebar-collapsed .app-wrapper {
            margin-left: var(--sidebar-collapsed-width);
        }

        body.sidebar-collapsed .sidebar-brand-text,
        body.sidebar-collapsed .sidebar-link span,
        body.sidebar-collapsed .sidebar-link .menu-arrow,
        body.sidebar-collapsed .sidebar-submenu,
        body.sidebar-collapsed .sidebar-footer {
            display: none;
        }

        body.sidebar-collapsed .sidebar-brand {
            justify-content: center;
            padding: 0;
        }

        body.sidebar-collapsed .sidebar-brand-icon {
            margin-right: 0;
        }

        body.sidebar-collapsed .sidebar-link {
            justify-content: center;
            padding: 0;
        }

        body.sidebar-collapsed .sidebar-link i {
            margin-right: 0;
        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 991.98px) {

            .app-sidebar {
                transform: translateX(-100%);

                width: var(--sidebar-width);
            }

            body.sidebar-mobile-open .app-sidebar {
                transform: translateX(0);
            }

            .app-wrapper {
                margin-left: 0 !important;
            }

            body.sidebar-collapsed .app-sidebar {
                width: var(--sidebar-width);
            }

            body.sidebar-collapsed .sidebar-brand-text,
            body.sidebar-collapsed .sidebar-link span,
            body.sidebar-collapsed .sidebar-link .menu-arrow,
            body.sidebar-collapsed .sidebar-submenu,
            body.sidebar-collapsed .sidebar-footer {
                display: block;
            }

            body.sidebar-collapsed .sidebar-brand {
                justify-content: flex-start;
                padding: 0 14px;
            }

            body.sidebar-collapsed .sidebar-brand-icon {
                margin-right: 10px;
            }

            body.sidebar-collapsed .sidebar-link {
                justify-content: flex-start;
                padding: 0 13px;
            }

            body.sidebar-collapsed .sidebar-link i {
                margin-right: 10px;
            }

            .app-content {
                padding: 20px 15px;
            }

            .app-header {
                padding: 0 15px;
            }

            .header-title {
                display: none;
            }

            .sidebar-overlay {
                display: none;

                position: fixed;
                inset: 0;

                background: rgba(0,0,0,.45);

                z-index: 1030;
            }

            body.sidebar-mobile-open .sidebar-overlay {
                display: block;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <!-- Mobile overlay -->
    <div
        class="sidebar-overlay"
        id="sidebarOverlay"
    ></div>


    <!-- ==========================================================
         SIDEBAR
    =========================================================== -->

    <aside class="app-sidebar" id="appSidebar">

        <!-- Brand -->
        <div class="sidebar-brand">

            <div class="sidebar-brand-icon">
                <i class="bi bi-boxes"></i>
            </div>

            <div class="sidebar-brand-text">
                PICKnPACK
            </div>

        </div>


        <!-- Menu -->
        <div class="sidebar-menu">

            <!-- Dashboard -->

            <a
                href="{{ url('/dashboard') }}"
                class="sidebar-link {{ request()->is('dashboard') ? 'active' : '' }}"
            >
                <i class="bi bi-grid-1x2"></i>
                <span>Dashboard</span>
            </a>


            <!-- Inventory -->

            <a
                href="{{ url('/inventory') }}"
                class="sidebar-link {{ request()->is('inventory*') ? 'active' : '' }}"
            >
                <i class="bi bi-box"></i>
                <span>Inventory</span>
            </a>


            <!-- Analytics -->

            <a
                href="#analyticsMenu"
                class="sidebar-link
                    {{ request()->is('qriff*') || request()->is('distribution*') ? 'active' : '' }}"
                data-bs-toggle="collapse"
                aria-expanded="{{ request()->is('qriff*') || request()->is('distribution*') ? 'true' : 'false' }}"
            >
                <i class="bi bi-bar-chart"></i>

                <span>Analytics</span>

                <i class="bi bi-chevron-down menu-arrow"></i>
            </a>


            <div
                id="analyticsMenu"
                class="collapse
                    {{ request()->is('qriff*') || request()->is('distribution*') ? 'show' : '' }}"
            >

                <div class="sidebar-submenu">

                    <a
                        href="{{ route('analytics.inventory') }}"
                        class="sidebar-link {{ request()->is('inventory*') ? 'active' : '' }}"
                    >
                        <i class="bi bi-boxes"></i>
                        <span>Inventory</span>
                    </a>


                    <a
                        href="{{ url('/qriff') }}"
                        class="sidebar-link {{ request()->is('qriff*') ? 'active' : '' }}"
                    >
                        <i class="bi bi-pie-chart"></i>
                        <span>QRIF</span>
                    </a>


                    <a
                        href="{{ url('/distribution') }}"
                        class="sidebar-link {{ request()->is('distribution*') ? 'active' : '' }}"
                    >
                        <i class="bi bi-graph-up"></i>
                        <span>Distribution</span>
                    </a>

                </div>

            </div>


            <!-- Orders -->

            <a
                href="{{ url('/orders') }}"
                class="sidebar-link {{ request()->is('orders*') ? 'active' : '' }}"
            >
                <i class="bi bi-truck"></i>
                <span>Orders</span>
            </a>


            <!-- Profile -->

            <a
                href="{{ route('profile.edit') }}"
                class="sidebar-link {{ request()->is('profile*') ? 'active' : '' }}"
            >
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>


            <!-- Settings -->

            <a
                href="{{ url('/settings') }}"
                class="sidebar-link {{ request()->is('settings*') ? 'active' : '' }}"
            >
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>

        </div>


        <!-- Footer inside sidebar -->

        <div class="sidebar-footer">
            © {{ date('Y') }} PICKnPACK
        </div>

    </aside>


    <!-- ==========================================================
         MAIN WRAPPER
    =========================================================== -->

    <div class="app-wrapper">


        <!-- ======================================================
             HEADER
        ======================================================= -->

        <header class="app-header">

            <button
                type="button"
                class="sidebar-toggle"
                id="sidebarToggle"
                aria-label="Toggle sidebar"
            >
                <i class="bi bi-layout-sidebar-inset"></i>
            </button>


            <div class="header-title">
                @yield('header', 'Dashboard')
            </div>


            <!-- User -->

            @auth

                <div class="header-user dropdown">

                    <button
                        class="header-user-button dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >

                        <span class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </span>

                        <span class="d-none d-md-inline">
                            {{ auth()->user()->name }}
                        </span>

                    </button>


                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <a
                                class="dropdown-item"
                                href="{{ route('profile.edit') }}"
                            >
                                <i class="bi bi-person me-2"></i>
                                Profile
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>

                            <form
                                method="POST"
                                action="{{ route('logout') }}"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="dropdown-item text-danger"
                                >
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Logout
                                </button>

                            </form>

                        </li>

                    </ul>

                </div>

            @endauth

        </header>


        <!-- ======================================================
             PAGE CONTENT
        ======================================================= -->

        <main class="app-content">

            @if(session('success'))

                <div class="alert alert-success alert-dismissible fade show">

                    {{ session('success') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                    ></button>

                </div>

            @endif


            @if(session('error'))

                <div class="alert alert-danger alert-dismissible fade show">

                    {{ session('error') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                    ></button>

                </div>

            @endif


            @if($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            @yield('content')

        </main>


        <!-- ======================================================
             FOOTER
        ======================================================= -->

        <footer class="app-footer">

            © {{ date('Y') }} PICKnPACK

        </footer>

    </div>


    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>


    <script>

        const sidebarToggle =
            document.getElementById('sidebarToggle');

        const sidebarOverlay =
            document.getElementById('sidebarOverlay');


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR TOGGLE
        |--------------------------------------------------------------------------
        */

        sidebarToggle.addEventListener('click', function () {

            if (window.innerWidth <= 991) {

                document.body.classList.toggle(
                    'sidebar-mobile-open'
                );

            } else {

                document.body.classList.toggle(
                    'sidebar-collapsed'
                );

                localStorage.setItem(
                    'sidebarCollapsed',
                    document.body.classList.contains('sidebar-collapsed')
                );

            }

        });


        /*
        |--------------------------------------------------------------------------
        | MOBILE OVERLAY
        |--------------------------------------------------------------------------
        */

        sidebarOverlay.addEventListener('click', function () {

            document.body.classList.remove(
                'sidebar-mobile-open'
            );

        });


        /*
        |--------------------------------------------------------------------------
        | REMEMBER DESKTOP SIDEBAR STATE
        |--------------------------------------------------------------------------
        */

        if (
            window.innerWidth > 991 &&
            localStorage.getItem('sidebarCollapsed') === 'true'
        ) {

            document.body.classList.add(
                'sidebar-collapsed'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | CLOSE MOBILE SIDEBAR AFTER CLICKING LINK
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll('.app-sidebar a')
            .forEach(function (link) {

                link.addEventListener('click', function () {

                    if (window.innerWidth <= 991) {

                        document.body.classList.remove(
                            'sidebar-mobile-open'
                        );

                    }

                });

            });

    </script>

    @stack('scripts')

</body>
</html>