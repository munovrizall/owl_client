<?php
$current_page = basename($_SERVER['PHP_SELF']);
$queryUsername = "SELECT * FROM client WHERE username = '$username'";
$resultUsername = mysqli_query($conn, $queryUsername);
$rowUsername = $resultUsername->fetch_assoc();
$namaKorespondensi = $rowUsername['nama_korespondensi'];
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 fixed">
    <!-- Brand Logo -->
    <a href="/owl_client/homepage" class="brand-link">
        <img src="/owl_client/assets/adminlte/dist/img/OWLlogo.png" alt="OWL Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-heavy">OWL RnD Client</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/owl_client/assets/adminlte/dist/img/user.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a class="d-block"><?php echo $namaKorespondensi ?></a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="/owl_client/homepage" class="nav-link <?php
                                                                    echo (strpos($current_page, 'homepage') !== false)
                                                                        ? 'active'
                                                                        : ''; ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Homepage</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/owl_client/monitoring/maintenance" class="nav-link <?php
                                                                                    echo (strpos($current_page, 'maintenance') !== false) ||
                                                                                        strpos($_SERVER['REQUEST_URI'], '/owl_client/monitoring/detail') !== false
                                                                                        ? 'active'
                                                                                        : ''; ?>">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Monitoring Maintenance</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/owl_client/inventaris/device" class="nav-link <?php
                                                                            echo (strpos($current_page, 'device') !== false) ||
                                                                                strpos($_SERVER['REQUEST_URI'], '/owl_client/inventaris/detail') !== false
                                                                                ? 'active'
                                                                                : ''; ?>">
                        <i class="nav-icon fas fa-toolbox"></i>
                        <p>Inventaris Device</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>