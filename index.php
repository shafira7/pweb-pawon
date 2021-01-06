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

$resep = query("SELECT * FROM resep");


?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Home</h1>
        <form class="d-none d-sm-inline-block form-inline navbar-search shadow">
            <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Cari resep..." aria-label="Search" id="keyword">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" name="search" id="search-button">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="row mt-4">
            <div class="col-lg-8">
                <h2 class="display-5">Hai, <strong><?= $user["nama"] ?>!</strong></h2>
                <p class="lead"> Di Pawon, kamu bisa explore berbagai macam resep makanan maupun minuman!</p>
                <hr>
                <p>Kamu juga bisa menulis resepmu sendiri!</p>
                <p class="lead">
                    <a class="btn btn-warning btn-lg" href="tulis_resep.php" role="button">Mulai tulis resep!</a>
                </p>
            </div>
            <div class="col-lg-4 d-flex flex-row justify-content-center">
                <img src="assets/img/undraw_cooking_lyxy.png" class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 20rem;" alt="cooking">
            </div>
        </div>
    </div>
    <div id="card">
        <div class="row flex-row d-flex justify-content-center">
            <?php foreach ($resep as $row) : ?>
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
                                        <a class="dropdown-item" href="tambah_favorit.php?id=<?= $row['id'] ?>">Tambah ke favorit</a>
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


<script src="assets/js/script.js"></script>
<!-- End of Main Content -->
<?php include 'templates/footer.php'; ?>