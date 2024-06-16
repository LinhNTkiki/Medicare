<nav class="navbar navbar-expand fixed-top be-top-header">
    <div class="container-fluid">
        <div class="be-navbar-header">
            <a href="http://localhost/Medicare/index.php?controller=home&action=home_admin" class="ml-5">
                <img src="assets/img/Medicare.png" alt="logo" width="150">
            </a>
        </div>
        <div class="page-title"><span>Bảng điều khiển</span></div>
        <div class="be-right-navbar">
            <!--            tai khoan-->
            <ul class="nav navbar-nav float-right be-user-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                                                 role="button" aria-expanded="false">
                        <img src="<?php echo $_SESSION['admin_avt'] ?? 'http://localhost/Medicare/assets/img/doctors/doctor_default.png' ?>" alt="Avatar">
                        <span class="user-name"><?php echo $_SESSION['admin_name'] ?></span>
                    </a>
                    <div class="dropdown-menu" role="menu">
                        <div class="user-info">
                            <div class="user-name"><?php echo $_SESSION['admin_name'] ?></div>
                            <div class="user-position online">Hoạt động</div>
                        </div>
                        <a class="dropdown-item" href="http://localhost/Medicare/index.php?controller=employee&action=profile">
                            <span class="icon mdi mdi-face"></span>Tài khoản
                        </a>
                        <a class="dropdown-item" href="http://localhost/Medicare/index.php?controller=auth&action=logout">
                            <span class="icon mdi mdi-power"></span>Đăng xuất
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>