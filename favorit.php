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

$id =  $_SESSION["id"];
$favorit = mysqli_query($conn, "SELECT * FROM resep as r INNER JOIN favorit AS f ON r.id = f.id_resep WHERE f.id_user = $id;");
$numCount = 1;

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Favorit</h1>

    <div id="card">
        <div class="row flex-row d-flex justify-content-center">
            <?php foreach ($favorit as $row) : ?>
                <?php $phpdate = strtotime($row["date_edited"]);
                $tanggal = date('d F, Y ', $phpdate); ?>
                <div class="p-2 col-auto">
                    <div class="card center shadow mb-4" style="width: 18rem;">
                        <img class="card-img-top img-fluid" src="assets/img/resep/<?= $row["image"]; ?>" alt="image">
                        <div class="card-body">
                            <div class="d-flex flex-row justify-content-between">
                                <a href="page_resep.php?id=<?= $row['id'] ?>" class="h5 mb-1 card-title"><?php echo ucwords($row["judul"]) ?></a>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="hapus_favorit.php?id=<?= $row['id'] ?>">Hapus dari favorit</a>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <p class="card-text"><?php echo $row["deskripsi"] ?></p>
                            <p class="card-text"><small class="text-muted"><?= $tanggal ?></small></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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