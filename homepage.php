<?php

include "includes/connection.php";

$rootPath = $_SERVER['DOCUMENT_ROOT'];
$username = $_SESSION['username'];

$query = "SELECT * FROM client WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$row = $result->fetch_assoc();
$namaPT = $row['nama_client'];

if ($namaPT == '') {
    header("Location: login.php");
}

$queryTransaksi = "SELECT * FROM transaksi_maintenance WHERE nama_client = '$namaPT' ORDER BY tanggal_terima DESC";
$resultTransaksi = mysqli_query($conn, $queryTransaksi);


$queryDevice = "SELECT * FROM inventaris_produk WHERE 
           id IS NOT NULL AND 
           type_produk IS NOT NULL AND 
           produk IS NOT NULL AND 
           chip_id IS NOT NULL AND 
           no_sn IS NOT NULL AND 
           nama_client IS NOT NULL AND 
           garansi_awal IS NOT NULL AND 
           garansi_akhir IS NOT NULL AND 
           garansi_void IS NOT NULL AND 
           keterangan_void IS NOT NULL AND 
           ip_address IS NOT NULL AND 
           mac_wifi IS NOT NULL AND 
           mac_bluetooth IS NOT NULL AND 
           firmware_version IS NOT NULL AND 
           hardware_version IS NOT NULL AND 
           free_ram IS NOT NULL AND 
           min_ram IS NOT NULL AND 
           batt_low IS NOT NULL AND 
           batt_high IS NOT NULL AND 
           temperature IS NOT NULL AND 
           status_error IS NOT NULL AND 
           gps_latitude IS NOT NULL AND 
           gps_longitude IS NOT NULL AND 
           status_qc_sensor_1 IS NOT NULL AND 
           status_qc_sensor_2 IS NOT NULL AND 
           status_qc_sensor_3 IS NOT NULL AND 
           status_qc_sensor_4 IS NOT NULL AND 
           status_qc_sensor_5 IS NOT NULL AND 
           status_qc_sensor_6 IS NOT NULL AND
           nama_client = '$namaPT'
           ORDER BY no_sn DESC";
$resultDevice = mysqli_query($conn, $queryDevice);

$queryDeviceCount = "SELECT COUNT(*) as total FROM inventaris_produk WHERE 
           id IS NOT NULL AND 
           type_produk IS NOT NULL AND 
           produk IS NOT NULL AND 
           chip_id IS NOT NULL AND 
           no_sn IS NOT NULL AND 
           nama_client IS NOT NULL AND 
           garansi_awal IS NOT NULL AND 
           garansi_akhir IS NOT NULL AND 
           garansi_void IS NOT NULL AND 
           keterangan_void IS NOT NULL AND 
           ip_address IS NOT NULL AND 
           mac_wifi IS NOT NULL AND 
           mac_bluetooth IS NOT NULL AND 
           firmware_version IS NOT NULL AND 
           hardware_version IS NOT NULL AND 
           free_ram IS NOT NULL AND 
           min_ram IS NOT NULL AND 
           batt_low IS NOT NULL AND 
           batt_high IS NOT NULL AND 
           temperature IS NOT NULL AND 
           status_error IS NOT NULL AND 
           gps_latitude IS NOT NULL AND 
           gps_longitude IS NOT NULL AND 
           status_qc_sensor_1 IS NOT NULL AND 
           status_qc_sensor_2 IS NOT NULL AND 
           status_qc_sensor_3 IS NOT NULL AND 
           status_qc_sensor_4 IS NOT NULL AND 
           status_qc_sensor_5 IS NOT NULL AND 
           status_qc_sensor_6 IS NOT NULL AND
           nama_client = '$namaPT'";
$resultDeviceCount = mysqli_query($conn, $queryDeviceCount);
$rowDeviceCount = mysqli_fetch_assoc($resultDeviceCount)['total'];

$queryMaintenanceDevice = "SELECT COUNT(*) as total
FROM detail_maintenance
INNER JOIN transaksi_maintenance ON detail_maintenance.transaksi_id = transaksi_maintenance.transaksi_id
WHERE (cek_barang = 0 OR berita_as = 0 OR administrasi = 0 OR pengiriman = 0)
AND nama_client = '$namaPT'";

$resultMaintenanceDevice = mysqli_query($conn, $queryMaintenanceDevice);
$rowMaintenanceDeviceCount = mysqli_fetch_assoc($resultMaintenanceDevice)['total'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Homepage</title>

    <?php
    $rootPath = $_SERVER['DOCUMENT_ROOT'];
    include $rootPath . "/owl_client/includes/stylesheet.html";
    ?>

    <style>
        .lebar-kolom1 {
            width: 5%;
        }

        .lebar-kolom2 {
            width: 15%;
        }

        .lebar-kolom3 {
            width: 48%;
        }

        .lebar-kolom4 {
            width: 10%;
        }

        .lebar-kolom5 {
            width: 22%;
        }

        .card-padding {
            padding: 10px 20px;
        }

      
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">
        
        <?php 
        include $rootPath . "/owl_client/includes/navbar.html"; 
        include $rootPath . "/owl_client/includes/sidebar.php"; 
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Selamat Datang
                                <?php echo $row['nama_client'] . ' - ' . $row['nama_korespondensi']; ?>
                                !</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Home</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <section class="content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="small-box bg-gradient-info">
                                    <div class="inner">
                                        <h3>Maintenance</h3>
                                        <p>Melihat detail catatan transaksi maintenance</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-screwdriver-wrench"></i>
                                    </div>
                                    <a href="monitoring/maintenance" class="small-box-footer">
                                        Lihat <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="small-box bg-gradient-success">
                                    <div class="inner">
                                        <h3>Inventaris</h3>
                                        <p>Melihat detail daftar inventaris device yang dimiliki</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-toolbox"></i>
                                    </div>
                                    <a href="inventaris/device" class="small-box-footer">
                                        Lihat <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info"><i class="fas fa-wrench"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Jumlah device yang sedang maintenance</span>
                                        <span class="info-box-number"><?php echo $rowMaintenanceDeviceCount ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-success"><i class="fas fa-microchip"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Jumlah device yang dimiliki</span>
                                        <span class="info-box-number"><?php echo $rowDeviceCount ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-outline card-info card-padding">
                                    <div class="card-header">
                                        <h3 class="card-title"><b>List Maintenance</b></h3>
                                        <div class="card-tools">
                                            <a href="monitoring/maintenance" class="btn btn-tool">
                                                Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <table id="tableTransaksi" class="table table order-list table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center lebar-kolom1">No</th>
                                                    <th class="text-center lebar-kolom2">Tanggal</th>
                                                    <th class="text-center lebar-kolom3">Nama PT</th>
                                                    <th class="text-center lebar-kolom4">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $counter = 0;
                                                while ($row = mysqli_fetch_assoc($resultTransaksi)) {
                                                    $counter++;
                                                    // Format date
                                                    $tanggal = date('d-m-Y', strtotime($row["tanggal_terima"]));
                                                    // Fetch detail_maintenance data based on transaksi_id
                                                    $transaksiId = $row["transaksi_id"];
                                                    $detailQuery = "SELECT * FROM detail_maintenance WHERE transaksi_id = $transaksiId";
                                                    $detailResult = mysqli_query($conn, $detailQuery);
                                                    $statusClass = 'bg-danger'; // Default class
                                                    $statusText = 'Belum'; // Default text

                                                    // Check conditions for bg-success
                                                    $allConditionsMet = true;
                                                    while ($detailRow = mysqli_fetch_assoc($detailResult)) {
                                                        if (
                                                            $detailRow['kedatangan'] != 1 ||
                                                            $detailRow['cek_barang'] != 1 ||
                                                            $detailRow['berita_as'] != 1 ||
                                                            $detailRow['administrasi'] != 1 ||
                                                            $detailRow['pengiriman'] != 1 ||
                                                            $detailRow['no_resi'] == 0
                                                        ) {
                                                            $allConditionsMet = false;
                                                            break;
                                                        }
                                                    }

                                                    if ($allConditionsMet) {
                                                        $statusClass = 'bg-success';
                                                        $statusText = 'Selesai';
                                                    }

                                                    // Output table row with appropriate status class and text
                                                ?>
                                                    <tr>
                                                        <td><?php echo $counter; ?></td>
                                                        <td><?php echo $tanggal ?></td>
                                                        <td><?php echo $row["nama_client"]; ?></td>
                                                        <td class="text-center"><span class="badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card card-outline card-success card-padding">
                                    <div class="card-header">
                                        <h3 class="card-title"><b>List Device</b></h3>
                                        <div class="card-tools">
                                            <a href="inventaris/device" class="btn btn-tool">
                                                Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table id="tableInventaris" class="table table order-list table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center lebar-kolom1">No</th>
                                                        <th class="text-center lebar-kolom3">Nomor SN</th>
                                                        <th class="text-center lebar-kolom2">Produk</th>
                                                        <th class="text-center lebar-kolom4">Perusahaan</th>
                                                        <th class="text-center lebar-kolom5">Garansi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $counter = 0;
                                                    while ($rowDevice = mysqli_fetch_assoc($resultDevice)) {
                                                        $counter++;
                                                        $statusClass = 'bg-danger'; // Default class
                                                        $statusText = 'Tidak'; // Default text

                                                        // Check if any rowDevice is missing and set default values
                                                        if (
                                                            empty($rowDevice["garansi_akhir"]) // Check if warranty expiry date is missing
                                                            // Add similar checks for other rowDevices as needed
                                                        ) {
                                                            $statusClass = '-';
                                                            $statusText = '-';
                                                        } else {
                                                            // Check conditions for bg-success
                                                            $allConditionsMet = true;
                                                            if (strtotime($rowDevice["garansi_akhir"]) < strtotime('today') || $rowDevice["garansi_void"] == 1) { // Check if warranty expiry date is before today
                                                                $allConditionsMet = false;
                                                            }

                                                            if ($allConditionsMet) {
                                                                $statusClass = 'bg-success';
                                                                $statusText = 'Ya';
                                                            }
                                                        }

                                                        // Output table rowDevice with appropriate status class and text
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $counter; ?></td>
                                                            <td><?php echo $rowDevice["no_sn"]; ?></td>
                                                            <td><?php echo $rowDevice["produk"] ?></td>
                                                            <td><?php echo !empty($rowDevice["nama_client"]) ? $rowDevice["nama_client"] : '-' ?></td>
                                                            <td class="text-center"><span class="badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </section>
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
    <script src="assets/adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="assets/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/adminlte/dist/js/adminlte.min.js"></script>
    <!-- Datatables -->
    <script src="https://cdn.datatables.net/v/bs4/dt-1.13.8/b-2.4.2/b-colvis-2.4.2/b-print-2.4.2/fh-3.4.0/r-2.5.0/rg-1.4.1/sb-1.6.0/sp-2.2.0/datatables.min.js">
    </script>
    <script src="https:////code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>

    <!-- Page specific script -->
    <script>
        $(document).ready(function() {
            var table = $('#tableTransaksi').DataTable({
                responsive: true,
                pageLength: 5,
                language: {
                    lengthMenu: 'Tampilkan _MENU_ data per halaman',
                    zeroRecords: 'Tidak ada maintenance',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                },
                dom: 'Bfrtip',
                order: [],
                searching: false,
                buttons: [],
                paging: true,
            });

            var table = $('#tableInventaris').DataTable({
                responsive: true,
                pageLength: 5,
                language: {
                    lengthMenu: 'Tampilkan _MENU_ data per halaman',
                    zeroRecords: 'Tidak ada device',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                },
                dom: 'Bfrtip',
                order: [],
                searching: false,
                buttons: [],
                paging: true,
            });


        });
    </script>

</body>

</html>