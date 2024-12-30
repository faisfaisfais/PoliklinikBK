<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>@yield('title')</title>

    @stack('prepend-style')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link href="/style/main.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css" />
    <link href="{{ url('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    @stack('addon-style')

    <style>
        .form-group.position-relative {
            position: relative;
        }

        .container-fluid {
            overflow: visible;
            /* Pastikan tidak memotong dropdown */
        }

        #obat-dropdown {
            position: absolute;
            /* Posisi absolut untuk menjaga posisi relatif terhadap input */
            z-index: 1050;
            /* Pastikan dropdown berada di atas elemen lain */
            background-color: #ffffff;
            /* Warna latar belakang dropdown */
            border: 1px solid #ced4da;
            /* Border dropdown */
            border-radius: 0.25rem;
            /* Membuat sudut dropdown melengkung */
            max-height: 200px;
            /* Maksimal tinggi dropdown */
            overflow-y: auto;
            /* Tambahkan scroll jika item banyak */
            width: 100%;
            /* Samakan lebar dropdown dengan input */
        }

        #obat-dropdown .dropdown-item {
            padding: 0.5rem 1rem;
            /* Padding untuk item dropdown */
            cursor: pointer;
            /* Ubah kursor saat hover */
        }

        #obat-dropdown .dropdown-item:hover {
            background-color: #f8f9fa;
            /* Warna latar belakang saat hover */
        }

        #obat-dipilih {
            margin-top: 10px;
            /* Beri sedikit jarak dari elemen di atasnya */
        }

        #obat-dipilih .obat-item {
            display: flex;
            /* Gunakan flexbox untuk tata letak horizontal */
            justify-content: space-between;
            /* Jarak antara teks obat dan tombol hapus */
            align-items: center;
            /* Ratakan secara vertikal */
            padding: 10px;
            /* Beri ruang dalam untuk item */
            margin-bottom: 10px;
            /* Jarak antar item */
            border: 1px solid #ced4da;
            /* Tambahkan border untuk memperjelas batas item */
            border-radius: 5px;
            /* Tambahkan sudut melengkung */
            background-color: #f8f9fa;
            /* Latar belakang item */
        }


        #obat-dipilih .obat-item .remove-obat-btn {
            color: #dc3545;
            /* Warna tombol hapus */
            cursor: pointer;
            /* Ubah kursor saat hover */
        }

        #obat-dipilih .obat-item .remove-obat-btn:hover {
            color: #a71d2a;
            /* Warna tombol saat di-hover */
        }
    </style>
</head>

<body>
    <div class="page-dashboard">
        <div class="d-flex" id="wrapper" data-aos="fade-right">
            <!-- Sidebar -->
            <div class="border-right" id="sidebar-wrapper">
                <div class="sidebar-heading text-center">
                    <img src="/images/logo_udinus.png" alt="" class="my-4" style="max-width: 150px;" />
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('dashboard-dokter') }}"
                        class="list-group-item list-group-item-action {{ request()->is('admin') ? 'active' : '' }} ">
                        Dashboard
                    </a>
                    <a href="{{ route('jadwal.index') }}"
                        class="list-group-item list-group-item-action {{ request()->is('admin/product') ? 'active' : '' }} ">
                        Jadwal
                    </a>
                    <a href="{{ route('periksa.index') }}"
                        class="list-group-item list-group-item-action {{ request()->is('admin/product-gallery*') ? 'active' : '' }} ">
                        Periksa
                    </a>
                    <a href="{{ route('history.index') }}"
                        class="list-group-item list-group-item-action {{ request()->is('admin/category*') ? 'active' : '' }} ">
                        History
                    </a>
                    <a href="{{ route('profile.index') }}" class="list-group-item list-group-item-action">
                        Profile
                    </a>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="list-group-item list-group-item-action">
                        Sign Out
                    </a>
                </div>
            </div>

            <!-- Page Content -->
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top" data-aos="fade-down">
                    <div class="container-fluid">
                        <button class="btn btn-secondary d-md-none mr-auto mr-2" id="menu-toggle">
                            &laquo; Menu
                        </button>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Desktop Menu -->
                            <ul class="navbar-nav d-none d-lg-flex ml-auto">
                                <li class="nav-item dropdown">
                                    <a href="#" class="nav-link" id="navbarDropdown" role="button"
                                        data-toggle="dropdown">
                                        <img src="/images/icon-user.png" alt=""
                                            class="rounded-circle mr-2 profile-picture" />
                                        Hi, {{ Auth::user()->username }}
                                    </a>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                            class="dropdown-item">
                                            Logout
                                        </a>
                                    </div>
                                </li>
                            </ul>

                            <ul class="navbar-nav d-block d-lg-none">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        Hi, {{ Auth::user()->username }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                {{-- Content --}}
                @yield('content')

            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    @stack('prepend-script')
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
    <script>
        $("#datatable").DataTable();
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
    @stack('addon-script')
</body>

</html>
