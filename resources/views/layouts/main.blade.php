<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    {{-- <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/datepicker.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    {{-- this is a cdn of ck editor --}}
    <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
    {{-- this is our own custom css --}}
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/spinner.css') }}">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('dist/css/custom.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('dist/css/icons.min.css') }}"> --}}
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

</head>

<body class="hold-transition sidebar-mini layout-fixed text-sm">
    @include('sweetalert::alert')
    {{-- @livewireStyles --}}
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user"></i> <span
                            class="px-2">{{ auth()->user() == null ? 'ADMIN' : auth()->user()->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item"
                            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> <span class="px-3">{{ __('Logout') }}</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-link" target="_blank">
                <img src="{{ asset('everest-phone-logo.png') }}" alt="Neuro Hospital, Logo "
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span style="color:#fff; letter-spacing:1px;     text-transform: uppercase;"
                    class="brand-text font-weight-bold ">{{ config('app.name', 'Laravel') }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    @if (!auth()->user()->hasRole(config('CONSTANT.USER_ROLE')))
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ url('home') }}" class="nav-link @yield('is_active_home')">
                                    <i class='bx bx-home-circle nav-icon'></i>
                                    <p>
                                        {{ __('Home') }}
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('product.index') }}" class="nav-link @yield('is_active_product')">
                                    <i class="fa-brands fa-product-hunt nav-icon"></i>
                                    <p>
                                        {{ __('Product') }}
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('stock.index') }}" class="nav-link @yield('is_active_stock')">
                                    <i class="fa-solid fa-store nav-icon"></i>
                                    <p>
                                        {{ __('Stock') }}
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('order_history.index') }}" class="nav-link @yield('is_active_order_history')">
                                    <i class="fa-solid fa-dollar-sign nav-icon"></i>
                                    <p>
                                        {{ __('Order History') }}
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('offer.index') }}" class="nav-link @yield('is_active_offer')">
                                    <i class="fa-solid fa-hand-holding-dollar nav-icon"></i>
                                    <p>
                                        {{ __('Offer') }}
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('upload.excel') }}" class="nav-link @yield('is_active_upload_excel')">
                                    <i class="fa-solid fa-file-excel nav-icon"></i>
                                    <p>
                                        {{ __('Upload excel') }}
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview @yield('menu_show') ">
                                <a href="#" class="nav-link">
                                    <i class="fa-solid fa-sliders nav-icon"></i>
                                    <p class="px-2 font-weight-bold">
                                        {{ __('Setting') }}
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview " style="display: @yield('s_child_grade')">
                                    <li class="nav-item">
                                        <a href="{{ route('warehouse.index') }}" class="nav-link @yield('setting_warehouse')">
                                            <i class="fa-solid fa-warehouse nav-icon"></i>
                                            <p class="px-1">{{ __('warehouse') }}</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('shipping.index') }}" class="nav-link @yield('setting_shipping')">
                                            <i class="fa-solid fa-truck-fast nav-icon"></i>
                                            <p class="px-1">{{ __('shipping') }}</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('shipping-method.index') }}"
                                            class="nav-link @yield('setting_shipping_method')">
                                            <i class="fa-solid fa-truck-fast nav-icon"></i>
                                            <p class="px-1">{{ __('shipping Method') }}</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('insurance.index') }}" class="nav-link @yield('setting_insurance')">
                                            <i class="fa-solid fa-book-medical nav-icon"></i>
                                            <p class="px-1">{{ __('insurance') }}</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('grade.index') }}" class="nav-link @yield('setting_grade')">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p class="px-1">{{ __('Grade') }}</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('grade-scale.index') }}"
                                            class="nav-link @yield('setting_grade_scale')">
                                            <i class="fa-solid fa-ruler-vertical nav-icon"></i>
                                            <p class="px-1">{{ __('Grade scale') }}</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('carrier.index') }}" class="nav-link @yield('setting_vendor')">
                                            <i class="fa-brands fa-sellsy nav-icon"></i>
                                            <p class="px-1">{{ __('Carrier') }}</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('vendor.index') }}" class="nav-link @yield('setting_vendors')">
                                            <i class="fa-brands fa-intercom nav-icon"></i>
                                            <p class="px-1">{{ __('Vendor') }}</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('color.index') }}" class="nav-link @yield('setting_color')">
                                            <i class="fa-solid fa-palette nav-icon"></i>
                                            <p class="px-1">{{ __('Color') }}</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('status.index') }}" class="nav-link @yield('setting_status')">
                                            <i class="fa-solid fa-lock nav-icon"></i>
                                            <p class="px-1">{{ __('Status') }}</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('manufacturer.index') }}"
                                            class="nav-link @yield('setting_manufacturer')">
                                            <i class="fa-solid fa-industry nav-icon"></i>
                                            <p class="px-1">{{ __('Manufacturer') }}</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    @else
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ url('home') }}" class="nav-link @yield('is_active_user_dashboard')">
                                    <i class='bx bx-home-circle nav-icon'></i>
                                    <p>
                                        {{ __('Dashboard') }}
                                    </p>
                                </a>
                            </li>
                        </ul>
                    @endif
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content" style="position: relative;">
                <div class="container-fluid" id="content" style="display: none;">
                    {{-- breadcrum --}}

                    <div class="row">
                        <div class="col-md-12">
                            @yield('main_content')
                        </div>
                    </div>
                </div>
                <div class="container-fluid" id="loader"
                    style="    position: absolute;
                top: 60px;
                max-height:100vh;
                background: #fff;">
                    <div class="col-12">
                        <div align="center" class="fond">
                            <div class="contener_general">
                                <div class="contener_mixte">
                                    <div class="ballcolor ball_1">&nbsp;</div>
                                </div>
                                <div class="contener_mixte">
                                    <div class="ballcolor ball_2">&nbsp;</div>
                                </div>
                                <div class="contener_mixte">
                                    <div class="ballcolor ball_3">&nbsp;</div>
                                </div>
                                <div class="contener_mixte">
                                    <div class="ballcolor ball_4">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        </section>
        <!-- Main content -->
        <!-- /.content -->
    </div>
    </div>
    </div>
    <!-- ./wrapper -->
    {{-- @livewireScripts --}}
    <script>
        document.onreadystatechange = function() {
            if (document.readyState !== "complete") {
                document.querySelector("#loader").style.display = "block";
                document.querySelector("#content").style.display = "none";
            } else {
                document.querySelector("#loader").style.display = "none";
                document.querySelector("#content").style.display = "block";
            }
        };
    </script>
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <!-- JQVMap -->
    {{-- <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script> --}}
    <!-- jQuery Knob Chart -->
    {{-- <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script> --}}
    <!-- daterangepicker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="{{ asset('dist/js/demo.js') }}"></script> --}}
    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/datepicker.js') }}"></script>
    <script src="{{ asset('js/land.js') }}"></script>
    @yield('scripts')
</body>

</html>
