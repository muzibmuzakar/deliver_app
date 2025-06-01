<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Deliver App</title>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.3/css/buttons.dataTables.css">
</head>

<body>
    @php
        use Illuminate\Support\Facades\Auth;
    @endphp
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    @if (Auth::user()->role === 'admin')
                    <a class="text-nowrap logo-img" href="{{ route('admin.dashboard') }}">
                    @else
                    <a class="text-nowrap logo-img" href="{{ route('kurir.dashboard') }}">
                    @endif
                        {{-- <img src="../assets/images/logos/dark-logo.svg" width="180" alt="" /> --}}
                        
                        <h4 class="hide-menu">LOGO</h4>
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Home</span>
                        </li>
                        @auth
                            <li class="sidebar-item">
                                @if (Auth::user()->role === 'admin')
                                <a class="sidebar-link" href="{{ route('admin.dashboard') }}" aria-expanded="false">
                                @else
                                <a class="sidebar-link" href="{{ route('kurir.dashboard') }}" aria-expanded="false">
                                @endif
                                    <span>
                                        <i class="ti ti-layout-dashboard"></i>
                                    </span>
                                    <span class="hide-menu">Dashboard</span>
                                </a>
                            </li>
                            @if (in_array(Auth::user()->role, ['admin', 'operator']))
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="{{ route('surat.index') }}" aria-expanded="false">
                                        <span><i class="ti ti-mail"></i></span>
                                        <span class="hide-menu">Surat</span>
                                    </a>
                                </li>
                            @endif

                            {{-- User: Hanya admin --}}
                            @if (Auth::user()->role === 'admin')
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="{{ route('users.index') }}" aria-expanded="false">
                                        <span><i class="ti ti-users"></i></span>
                                        <span class="hide-menu">User</span>
                                    </a>
                                </li>
                            @endif

                            {{-- surat kurir --}}
                            @if (Auth::user()->role === 'kurir')
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="{{ route('penugasan.index') }}" aria-expanded="false">
                                        <span><i class="ti ti-mail"></i></span>
                                        <span class="hide-menu">Penugasan</span>
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        @php
                            $notifications = auth()->user()->unreadNotifications()->take(5)->get(); // ambil 5 notifikasi terbaru
                        @endphp
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                <i class="ti ti-bell"></i>
                                @if ($notifications->count() > 0)
                                    <div class="notification bg-primary rounded-circle"></div>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-animate-up" aria-labelledby="drop1"
                                data-bs-popper="static">
                                <div class="message-body">
                                    @forelse ($notifications as $notification)
                                        <a href="{{ route('surat.index') }}"
                                            class="dropdown-item d-flex align-items-start">
                                            <div>
                                                <strong>{{ $notification->data['title'] }}</strong><br>
                                                <small>{{ $notification->data['message'] }}</small><br>
                                                <small
                                                    class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                            </div>
                                        </a>
                                    @empty
                                        <a href="javascript:void(0)" class="dropdown-item">
                                            Tidak ada notifikasi baru.
                                        </a>
                                    @endforelse
                                </div>
                            </div>
                        </li>

                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="" width="35"
                                        height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <form action="{{ route('logout') }}" method="POST">@csrf
                                            <button class="btn btn-outline-danger mx-3 mt-2 d-block">Logout</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->
            <!-- Begin Page Content -->
            @yield('content')
            <!-- /.container-fluid -->
        </div>
    </div>
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>

</body>

</html>
