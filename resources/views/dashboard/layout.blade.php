<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | WE Management</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/adminlte.min.css') }}">
    <!-- Select 2 -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/select2.css') }}">
    <!-- Main styles -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/styles.css') }}">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a href="{{ route('logout') }}" class="nav-link">
                    Logout
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/img/aside-logo.png') }}" alt="logo" class="brand-image img-circle elevation-3">
            <span class="brand-text font-weight-light">Management</span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <a href="{{ url(getProtocol() . auth()->user()->subdomain . '.' . getDomain() . '/profile') }}">
                        <img src="{{ auth()->user()->getAvatar() }}" class="img-circle elevation-2" alt="{{ auth()->user()->name }}">
                    </a>
                </div>
                <div class="info">
                    <a href="{{ url(getProtocol() . auth()->user()->subdomain . '.' . getDomain() . '/profile') }}">
                        <span class="d-block text-light">{{ auth()->user()->name }}</span>
                    </a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-user-tie"></i>
                                <p>
                                    Clients
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('clients.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon text-info"></i>
                                        <p>View all</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('clients.create') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon text-danger"></i>
                                        <p>Add new client</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-user"></i>
                            <p>
                                Users
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon text-info"></i>
                                    <p>View all</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon text-danger"></i>
                                    <p>Add new user</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fab fa-wpforms"></i>
                            <p>
                                Forms
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('forms.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon text-info"></i>
                                    <p>View all</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('forms.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon text-danger"></i>
                                    <p>Create form</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-newspaper"></i>
                            <p>
                                Pages
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('pages.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon text-info"></i>
                                    <p>View all</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pages.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon text-danger"></i>
                                    <p>Create page</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-th"></i>
                                <p>
                                    Content
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('texts') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon text-info"></i>
                                        <p>Texts</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('advantages.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon text-info"></i>
                                        <p>Advantages</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('slides.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon text-info"></i>
                                        <p>Slides</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('methods.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon text-info"></i>
                                        <p>Methods</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('isos.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon text-info"></i>
                                        <p>ISO standards</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-globe "></i>
                                    <p>
                                        Translations
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('languages.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon text-info"></i>
                                            <p>Languages</p>
                                        </a>
                                    </li>
                                   {{-- <li class="nav-item">
                                        <a href="{{ route('texts') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon text-info"></i>
                                            <p>Translations</p>
                                        </a>
                                    </li>--}}
                                </ul>
                            </li>

                        <li class="nav-item">
                            <a href="{{ route('settings') }}" class="nav-link">
                                <i class="fas fa-cog"></i>
                                <p>Settings</p>
                            </a>
                        </li>



                    @endif



                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- Axios -->
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<!-- jQuery -->
<script src="{{ asset('assets/dashboard/js/jquery.min.js') }}"></script>
<!-- jQuery UI -->
<script src="{{ asset('assets/dashboard/js/jquery-ui.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/dashboard/js/bootstrap.bundle.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('assets/dashboard/js/file.input.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/dashboard/js/adminlte.min.js') }}"></script>
<!-- Form Builder -->
<script src="{{ asset('assets/dashboard/js/form-builder.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/form-render.min.js') }}"></script>
<!-- TinyMCE -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.2/tinymce.min.js"></script>
<script>
  tinymce.init({
    extended_valid_elements : "iframe[src|width|height|name|align|frameborder]"
  });
</script>
<!-- Select 2 -->
<script src="{{ asset('assets/dashboard/js/select2.js') }}"></script>
<!-- Main scripts -->
<script src="{{ asset('assets/dashboard/js/scripts.js') }}"></script>

@yield('blade-scripts')
</body>
</html>
