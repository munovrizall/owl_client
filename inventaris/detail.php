<?php

include "../includes/connection.php";

$username = $_SESSION['username'];

$query = "SELECT * FROM client WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$rowClient = $result->fetch_assoc();
$namaPT = $rowClient['nama_client'];

if ($namaPT == '') {
    header("Location: /owl_client");
}

if (isset($_GET['id'])) {
    $getId = $_GET['id'];

    $queryInventaris = "SELECT * FROM inventaris_produk WHERE id = ?";
    $stmt = $conn->prepare($queryInventaris);
    $stmt->bind_param("i", $getId);
    $stmt->execute();

    $resultInventaris = $stmt->get_result();
    $row = mysqli_fetch_assoc($resultInventaris);
    $namaClientInventaris = $row['nama_client'];

    if ($namaPT != $namaClientInventaris) {
        header("Location: device");
    }
} else {
    echo "ID not provided.";
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Produk</title>

    <?php
    $rootPath = $_SERVER['DOCUMENT_ROOT'];
    include $rootPath . "/owl_client/includes/stylesheet.html";
    ?>
    
    <style>
        #successMessage {
            display: none;
            /* Hide the success message initially */
        }

        .gray-italic-text {
            color: #808080;
            font-style: italic;
        }

        .table-container {
            display: flex;
            flex-direction: row;
            width: 100%;
            overflow-x: auto;
        }

        .thead-column {
            flex: 0 0 20%;
            font-weight: bold;
        }

        .tr-column {
            flex: 1;
        }

        .table-head {
            width: 240px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border: none;
            /* menghilangkan garis pada sel tabel */
        }
    </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4 fixed">
            <!-- Brand Logo -->
            <a href="../homepage" class="brand-link">
                <img src="../assets/adminlte/dist/img/OWLlogo.png" alt="OWL Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-heavy">OWL RnD</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../assets/adminlte/dist/img/user.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a class="d-block"><?php echo $rowClient['nama_korespondensi'] ?></a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="../homepage" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Homepage</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../monitoring/maintenance" class="nav-link">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>Monitoring Maintenance</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../inventaris/device" class="nav-link active">
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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Detail Produk</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../homepage">Home</a></li>
                                <li class="breadcrumb-item active"><a href="device">Inventaris Device</a></li>
                                <li class="breadcrumb-item active">Detail</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Detail Produk <?php echo " #{$row["id"]}" ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="produkForm" method="post">
                            <!-- Added method="post" -->
                            <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
                            <!-- Hidden input to pass client_id -->
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="table-container">
                                        <div class="tr-column">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td class="table-head" style="min-width: 160px"><b>Nama Perusahaan :</b></td>
                                                        <td style="min-width: 140px">
                                                            <?php
                                                            $nama_client = $row["nama_client"];
                                                            echo $nama_client !== null ? $nama_client : '-';
                                                            ?>
                                                        </td>
                                                        <td class="table-head" style="min-width: 160px"><b>Free RAM :</b></td>
                                                        <td style="min-width: 140px">
                                                            <?php
                                                            $free_ram = $row["free_ram"];
                                                            echo "{$free_ram}";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Nama Produk :</b></td>
                                                        <td>
                                                            <?php
                                                            $produk = $row["produk"];
                                                            echo "{$produk}";
                                                            ?>
                                                        </td>
                                                        <td><b>Min RAM :</b></td>
                                                        <td>
                                                            <?php
                                                            $min_ram = $row["min_ram"];
                                                            echo "{$min_ram}";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Tipe Produk :</b></td>
                                                        <td>
                                                            <?php
                                                            $type_produk = $row["type_produk"];
                                                            echo "{$type_produk}";
                                                            ?>
                                                        </td>
                                                        <td class="table-head"><b>Battery Low :</b></td>
                                                        <td>
                                                            <?php
                                                            $batt_low = $row["batt_low"];
                                                            echo "{$batt_low}";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-head"><b>Nomor SN :</b></td>
                                                        <td>
                                                            <?php
                                                            $no_sn = $row["no_sn"];
                                                            echo "{$no_sn}";
                                                            ?>
                                                        </td>
                                                        <td><b>Battery High :</b></td>
                                                        <td>
                                                            <?php
                                                            $batt_high = $row["batt_high"];
                                                            echo "{$batt_high}";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Chip ID :</b></td>
                                                        <td>
                                                            <?php
                                                            $chip_id = $row["chip_id"];
                                                            echo "{$chip_id}";
                                                            ?>
                                                        </td>
                                                        <td><b>Temperature :</b></td>
                                                        <td>
                                                            <?php
                                                            $temperature = $row["temperature"];
                                                            echo "{$temperature}";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Garansi Awal :</b></td>
                                                        <td>
                                                            <?php
                                                            $garansi_awal = $row["garansi_awal"];
                                                            $formatted_date = $garansi_awal !== null ? date("d/m/Y", strtotime($garansi_awal)) : '-';
                                                            echo $formatted_date;
                                                            ?>
                                                        </td>
                                                        <td><b>Status Error :</b></td>
                                                        <td>
                                                            <?php
                                                            $status_error = $row["status_error"];
                                                            echo "{$status_error}";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Garansi Akhir :</b></td>
                                                        <td>
                                                            <?php
                                                            $garansi_akhir = $row["garansi_akhir"];
                                                            $formatted_date = $garansi_awal !== null ? date("d/m/Y", strtotime($garansi_akhir)) : '-';
                                                            echo $formatted_date;
                                                            ?>
                                                        </td>
                                                        <td><b>GPS Latitude :</b></td>
                                                        <td>
                                                            <?php
                                                            $gps_latitude = $row["gps_latitude"];
                                                            echo "{$gps_latitude}";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Garansi Void :</b></td>
                                                        <td>
                                                            <?php
                                                            $voidClass = 'badge bg-success';
                                                            $voidText = 'Tidak Void';

                                                            if ($row["garansi_void"] == 1) {
                                                                $voidClass = "badge bg-danger";
                                                                $voidText = "Void";
                                                            }
                                                            ?>

                                                            <div class="<?php echo $voidClass; ?>"><?php echo $voidText; ?></div>

                                                        </td>
                                                        <td><b>GPS Longitude :</b></td>
                                                        <td>
                                                            <?php
                                                            $gps_longitude = $row["gps_longitude"];
                                                            echo "{$gps_longitude}";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Keterangan Void:</b></td>
                                                        <td>
                                                            <?php
                                                            $keterangan_void = $row["keterangan_void"];
                                                            echo "{$keterangan_void}";
                                                            ?>
                                                        </td>
                                                        <td><b>Status QC Sensor 1 :</b></td>
                                                        <td>
                                                            <?php
                                                            $status_qc_sensor_1 = $row["status_qc_sensor_1"];
                                                            echo "{$status_qc_sensor_1}";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Status Garansi :</b></td>
                                                        <td>
                                                            <?php
                                                            $statusClass = 'badge bg-success'; // Default class
                                                            $statusText = 'Ya'; // Default text

                                                            if (strtotime($row["garansi_akhir"]) < strtotime('today') || $row["garansi_void"] == 1) {
                                                                $statusClass = 'badge bg-danger';
                                                                $statusText = 'Tidak';
                                                            }
                                                            ?>
                                                            <div class="<?php echo $statusClass; ?>"><?php echo $statusText; ?></div>
                                                        </td>
                                                        <td><b>Status QC Sensor 2 :</b></td>
                                                        <td>
                                                            <?php
                                                            $status_qc_sensor_2 = $row["status_qc_sensor_2"];
                                                            echo "{$status_qc_sensor_2}";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>IP Address :</b></td>
                                                        <td>
                                                            <?php
                                                            $ip_address = $row["ip_address"];
                                                            echo "{$ip_address}";
                                                            ?>
                                                        </td>
                                                        <td><b>Status QC Sensor 3 :</b></td>
                                                        <td>
                                                            <?php
                                                            $status_qc_sensor_3 = $row["status_qc_sensor_3"];
                                                            echo "{$status_qc_sensor_3}";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>MAC Address WIFI :</b></td>
                                                        <td>
                                                            <?php
                                                            $mac_wifi = $row["mac_wifi"];
                                                            echo "{$mac_wifi}";
                                                            ?>
                                                        </td>
                                                        <td><b>Status QC Sensor 4 :</b></td>
                                                        <td>
                                                            <?php
                                                            $status_qc_sensor_4 = $row["status_qc_sensor_4"];
                                                            echo "{$status_qc_sensor_4}";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>MAC Address Bluetooth:</b></td>
                                                        <td>
                                                            <?php
                                                            $mac_bluetooth = $row["mac_bluetooth"];
                                                            echo "{$mac_bluetooth}";
                                                            ?>
                                                        </td>
                                                        <td><b>Status QC Sensor 5 :</b></td>
                                                        <td>
                                                            <?php
                                                            $status_qc_sensor_5 = $row["status_qc_sensor_5"];
                                                            echo "{$status_qc_sensor_5}";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Versi Firmware :</b></td>
                                                        <td>
                                                            <?php
                                                            $firmware_version = $row["firmware_version"];
                                                            echo "{$firmware_version}";
                                                            ?>
                                                        </td>
                                                        <td><b>Status QC Sensor 6 :</b></td>
                                                        <td>
                                                            <?php
                                                            $status_qc_sensor_6 = $row["status_qc_sensor_6"];
                                                            echo "{$status_qc_sensor_6}";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Versi Hardware :</b></td>
                                                        <td>
                                                            <?php
                                                            $hardware_version = $row["hardware_version"];
                                                            echo "{$hardware_version}";
                                                            ?>
                                                        </td>
                                                        <td><b>Last Online :</b></td>
                                                        <td>
                                                            <?php
                                                            $last_online = $row["last_online"];
                                                            echo "{$last_online}";
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                                <!-- /.card-body -->
                        </form>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button id="backButton" class="btn btn-info" onclick="goBack()"><i class="fas fa-arrow-left" style="padding-right: 8px"></i>Kembali</button>
                    </div>
                    <!-- general form elements -->
                    <!-- /.card -->

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../assets/adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="../assets/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/adminlte/dist/js/adminlte.min.js"></script>
    <!-- SweetAlert2 Toast -->
    <script src="../assets/adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Page specific script -->
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>