<?php
session_start();

require 'functions.php';

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
} else {
    $query = mysqli_query($conn, "SELECT * FROM user WHERE id ='" . $_SESSION["id"] . "'");
    $user = mysqli_fetch_assoc($query);
}

include 'templates/header.php';
include 'templates/sidebar.php';
include 'templates/topbar.php';

$resep = query("SELECT * FROM resep WHERE id_user = '" . $user['id'] . "' ");
$numCount = 1;

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Resepku</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Resep-resep yang kamu tulis</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Terakhir update</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resep as $row) : ?>
                            <?php $phpdate = strtotime($row["date_edited"]);
                            $tanggal = date('d F, Y ', $phpdate); ?>
                            <tr>
                                <td><?= $numCount++ ?></td>
                                <td><?php echo ucwords($row["judul"]) ?></td>
                                <td><?php echo $row["deskripsi"] ?></td>
                                <td><?php echo $tanggal ?></td>
                                <td class="d-flex justify-content-center">
                                    <a href="page_resep.php?id=<?php echo $row["id"] ?>" class="m-1 btn btn-info btn-circle btn-sm">
                                        <i class="fas fa-search"></i>
                                    </a>
                                    <a href="edit_resep.php?id=<?php echo $row["id"] ?>" class="m-1 btn btn-warning btn-circle btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" data-toggle="modal" data-target="#deleteModal" class="m-1 btn btn-danger btn-circle btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<!-- Page level plugins -->
<script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Page level custom scripts -->
<script src="js/demo/datatables-demo.js"></script>
<?php include 'templates/footer.php'; ?>