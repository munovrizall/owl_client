<?php
include("../includes/connection.php");

$username = $_SESSION['username'];

$queryUsername = "SELECT * FROM client WHERE username = '$username'";
$resultUsername = mysqli_query($conn, $queryUsername);
$rowUsername = $resultUsername->fetch_assoc();
$namaKorespondensi = $rowUsername['nama_korespondensi'];

if ($namaKorespondensi == '') {
    header("Location: /owl_client/");
}

$query = "SELECT * FROM client WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$row = $result->fetch_assoc();
$namaPT = $row['nama_client'];

if (isset($_GET['id'])) {
    $transaksi_id = $_GET['id'];

    // Selecting data from detail_maintenance table based on transaksi_id
    $query = "SELECT * FROM detail_maintenance WHERE transaksi_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $transaksi_id);
    $stmt->execute();

    $result = $stmt->get_result();

    // You can also fetch data from the transaksi_maintenance table
    $transaksiQuery = "SELECT nama_client FROM transaksi_maintenance WHERE transaksi_id = ?";
    $transaksiStmt = $conn->prepare($transaksiQuery);
    $transaksiStmt->bind_param("i", $transaksi_id);
    $transaksiStmt->execute();

    $transaksiResult = $transaksiStmt->get_result();
} else {
    echo "ID not provided.";
}

if (isset($_GET['id'])) {
    $transaksi_id = $_GET['id'];
    // Assuming $result contains data from the query
    $row = mysqli_fetch_assoc($transaksiResult);
    $nama_client = $row["nama_client"];
}

if ($nama_client != $namaPT) {
    header("Location: maintenance");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monitoring Transaksi</title>

    <?php
    $rootPath = $_SERVER['DOCUMENT_ROOT'];
    include $rootPath . "/owl_client/includes/stylesheet.html";
    ?>

    <style>
        .lebar-kolom1 {
            width: 17%;
        }

        .lebar-kolom2 {
            width: 15%;
        }

        .lebar-kolom3 {
            width: 10%;
        }

        .lebar-kolom4 {
            width: 20%;
        }

        .lebar-kolom5 {
            width: 3%;
        }

        .lebar-kolom10 {
            width: 20%;
        }

        th {
            text-align: center;
            vertical-align: middle;
        }

        .column-name {
            font-weight: bold;
        }

        .column-description {
            font-size: 10px;
            color: #888;
        }

        .larger-checkbox {
            width: 20px;
            height: 20px;
        }

        .disabled-checkbox {
            pointer-events: none;
            opacity: 1;
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
                            <?php
                            if (isset($_GET['id'])) {
                                $transaksi_id = $_GET['id'];
                                echo "<h1>Monitoring Transaksi #{$transaksi_id}</h1>";
                            } else {
                                echo "<h1>Monitoring Transaksi</h1>";
                                echo "ID not provided.";
                            }
                            ?>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active"><a href="../homepage">Home</a></li>
                                <li class="breadcrumb-item active"><a href="maintenance">Maintenance</a></li>
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
                            <?php
                            echo "<h3 class='card-title'>Monitoring Transaksi {$nama_client}</h3>";
                            ?>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="monitoringForm" method="post">
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><b>Detail Transaksi</b></h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="lebar-kolom5">ID</th>
                                                        <th class="lebar-kolom1" style="min-width:140px;">Nama Barang</th>
                                                        <th class="lebar-kolom2" style="min-width:100px;">Nomor SN</th>
                                                        <th class="lebar-kolom3">Garansi?</th>
                                                        <th class="lebar-kolom4">Kerusakan</th>
                                                        <th class="lebar-kolom5">
                                                            <div class="column-name">DTG</div>
                                                            <div class="column-description">Barang Datang</div>
                                                        </th>
                                                        <th class="lebar-kolom5">
                                                            <div class="column-name">CEK</div>
                                                            <div class="column-description">Buat Berita</div>
                                                        </th>
                                                        <th class="lebar-kolom5">
                                                            <div class="column-name">R</div>
                                                            <div class="column-description">Reparasi Barang</div>
                                                        </th>
                                                        <th class="lebar-kolom5">
                                                            <div class="column-name">SO/PO</div>
                                                            <div class="column-description">Proses Administrasi</div>
                                                        </th>
                                                        <th class="lebar-kolom5">
                                                            <div class="column-name">P</div>
                                                            <div class="column-description">Pengiriman Barang</div>
                                                        </th>
                                                        <th class="text-center lebar-kolom10" style="min-width:150px;">No. Resi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="transaksiTable">
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $row["detail_id"]; ?></td>
                                                            <td><?php echo $row["produk_mt"]; ?></td>
                                                            <td><?php echo $row["no_sn"]; ?></td>
                                                            <td><?php echo $row["garansi"] == 1 ? 'Ya' : 'Tidak'; ?></td>
                                                            <td><?php echo $row["keterangan"]; ?></td>
                                                            <td style="text-align: center;">
                                                                <div class="form-check">
                                                                    <input class="form-check-input larger-checkbox disabled-checkbox" type="checkbox" value="1" name="checkboxBarangDatang[<?php echo $row['detail_id']; ?>]" <?php echo $row["kedatangan"] == 1 ? 'checked' : ''; ?>>
                                                                </div>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <div class="form-check">
                                                                    <input class="form-check-input larger-checkbox disabled-checkbox" type="checkbox" value="1" name="checkboxCekMasalah[<?php echo $row['detail_id']; ?>]" <?php echo $row["cek_barang"] == 1 ? 'checked' : ''; ?>>
                                                                </div>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <div class="form-check">
                                                                    <input class="form-check-input larger-checkbox disabled-checkbox" type="checkbox" value="1" name="checkboxBeritaAcara[<?php echo $row['detail_id']; ?>]" <?php echo $row["berita_as"] == 1 ? 'checked' : ''; ?>>
                                                                </div>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <div class="form-check">
                                                                    <input class="form-check-input larger-checkbox disabled-checkbox" type="checkbox" value="1" name="checkboxAdministrasi[<?php echo $row['detail_id']; ?>]" <?php echo $row["administrasi"] == 1 ? 'checked' : ''; ?>>
                                                                </div>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <div class="form-check">
                                                                    <input class="form-check-input larger-checkbox disabled-checkbox" type="checkbox" value="1" name="checkboxPengiriman[<?php echo $row['detail_id']; ?>]" <?php echo $row["pengiriman"] == 1 ? 'checked' : ''; ?>>
                                                                </div>
                                                            </td>
                                                            <td><?php echo $row["no_resi"]; ?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </form>

                        <div class="card-footer d-flex justify-content-end">
                            <button id="backButton" class="btn btn-info" onclick="goBack()"><i class="fas fa-arrow-left" style="padding-right: 8px"></i>Kembali</button>
                        </div>
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
    <!-- Page specific script -->
    <script>
        function goBack() {
            window.history.back();
        }
    </script>

</body>

</html>