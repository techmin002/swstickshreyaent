<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        {{-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div> --}}

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <?php
                    // $newrequest = "SELECT COUNT(*) AS newrequest FROM tblbook Where status='Not Updated Yet' ";
                    // $new_result = $conn->query($newrequest);
                    // $new_row = $new_result->fetch_assoc();
                    ?>
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        {{-- <span class="badge badge-danger navbar-badge" style="margin-left: 5px">
                            7
                        </span> --}}
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">
                            <p><?php
                            //  echo $new_row['newrequest'];
                            ?></p> Notifications
                        </span>
                        <hr>
                        <a href="new-request.php" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fa-user"><span style="margin-left: 10px">{{ Auth::user()->name }}</span></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <h6 class="dropdown-header">Admin menu</h6>
                        <a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="fa fa-user text-primary"
                                style="margin-right: 20px;"></i>My
                            Profile</a>

                        <a class="dropdown-item" href=""><i class="fa fa-cog text-primary"
                                style="margin-right: 20px;"></i>Settings</a>
                        <hr>
                        <a class="dropdown-item" href="#"
                            onclick="if(confirmLogout()){ event.preventDefault(); document.getElementById('logout-form').submit(); }">
                            <i class="fa fa-sign-out-alt text-primary" style="margin-right: 20px;"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
