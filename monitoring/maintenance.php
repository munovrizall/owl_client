<?php

include "../includes/connection.php";

$username = $_SESSION['username'];

$query = "SELECT * FROM client WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$row = $result->fetch_assoc();
$namaPT = $row['nama_client'];

if ($namaPT == '') {
    header("Location: /owl_client");
}

$queryTransaksi = "SELECT * FROM transaksi_maintenance WHERE nama_client = '$namaPT' ORDER BY tanggal_terima DESC";
$resultTransaksi = mysqli_query($conn, $queryTransaksi);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monitoring Maintenance</title>

    <?php
    $rootPath = $_SERVER['DOCUMENT_ROOT'];
    include $rootPath . "/owl_client/includes/stylesheet.html";
    ?>

    <style>
        .lebar-kolom1 {
            width: 5%;
        }

        .lebar-kolom2 {
            width: 20%;
        }

        .lebar-kolom3 {
            width: 43%;
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
                            <h1 class="m-0">Halo <?php echo $row['nama_client'] . ' - ' . $row['nama_korespondensi']; ?>
                                !</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active"><a href="../homepage">Home</a></li>
                                <li class="breadcrumb-item active">Maintenance</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <section class="content">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><b>List Maintenance</b></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="table-responsive card-padding">
                                    <table id="tableTransaksi" class="table table order-list table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center lebar-kolom1">No</th>
                                                <th class="text-center lebar-kolom2">Tanggal</th>
                                                <th class="text-center lebar-kolom3" style="min-width: 80px">Nama PT</th>
                                                <th class="text-center lebar-kolom4">Status</th>
                                                <th class="text-center lebar-kolom5 aksi-column" style="min-width: 120px">Aksi</th>
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
                                                    <td><?php echo $counter ?></td>
                                                    <td><?php echo $tanggal ?></td>
                                                    <td><?php echo $row["nama_client"]; ?></td>
                                                    <td class="text-center"><span class="badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span></td>
                                                    <td class="text-center">
                                                        <div class="row">
                                                            <div class="col" style="margin-bottom: 8px">
                                                                <a href='detail?id=<?php echo $row["transaksi_id"]; ?>' class="btn btn-info btn-block">Detail</a>
                                                            </div>
                                                            <div class="col">
                                                                <a href='generate_pdf/pdf?id=<?php echo $row["transaksi_id"]; ?>' class="btn btn-block btn-outline-danger"><i class="fas fa-file-pdf" style="margin-right: 8px;"></i>PDF</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- general form elements -->
                            <!-- /.card -->
                            <!-- Pagination links -->

                        </div><!-- /.container-fluid -->
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
    <script src="../assets/adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="../assets/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/adminlte/dist/js/adminlte.min.js"></script>
    <!-- Datatables -->
    <script src="https://cdn.datatables.net/v/bs4/dt-1.13.8/b-2.4.2/b-colvis-2.4.2/b-print-2.4.2/fh-3.4.0/r-2.5.0/rg-1.4.1/sb-1.6.0/sp-2.2.0/datatables.min.js"></script>
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
                language: {
                    lengthMenu: 'Tampilkan _MENU_ data per halaman',
                    zeroRecords: 'Tidak ada maintenance',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                },
                dom: 'Bfrtip',
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
                buttons: [
                    'pageLength',
                    {
                        extend: 'copy',
                        title: 'Monitoring Transaksi Maintenance',
                        exportOptions: {
                            columns: ':visible:not(.aksi-column)'
                        }
                    },
                    {
                        extend: 'spacer',
                        style: 'bar',
                        text: 'Export files:'
                    },
                    {
                        extend: 'csv',
                        title: 'Monitoring Transaksi Maintenance',
                        exportOptions: {
                            columns: ':visible:not(.aksi-column)'
                        }
                    },
                    {
                        extend: 'excel',
                        title: 'Monitoring Transaksi Maintenance',
                        exportOptions: {
                            columns: ':visible:not(.aksi-column)'
                        }
                    },
                    {
                        extend: 'pdf',
                        title: 'Monitoring Transaksi Maintenance',
                        exportOptions: {
                            columns: ':visible:not(.aksi-column)'
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Monitoring Transaksi Maintenance',
                        exportOptions: {
                            columns: ':visible:not(.aksi-column)'
                        }
                    },
                ],
                order: [],
            });

            table.buttons().container()
                .appendTo('wrapper .col-md-6:eq(0)');

            $("table.order-list").on("click", ".ibtnEdit", function(event) {
                var idToEdit = 123;

                // Lakukan redirect dengan menyertakan ID sebagai parameter
                window.location.href = 'edit/edit?id=' + idToEdit;
            });

        });
    </script>

</body>

</html>