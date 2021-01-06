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


$id = $_GET["id"];

$resep = query("SELECT * FROM resep WHERE id = $id")[0];

$bahan = explode('-', $resep['bahan']);
$langkah = explode('-', $resep['langkah']);

$qpenulis = mysqli_query($conn, "SELECT nama FROM user as u INNER JOIN resep AS r ON u.id = r.id_user WHERE r.id = $id;");
$penulis = mysqli_fetch_assoc($qpenulis);

$tanggal = $resep['date_edited'];

$phpdate = strtotime($resep["date_edited"]);
$tanggal = date('d F, Y ', $phpdate);

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <a href="javascript:history.go(-1)" class="mb-3 btn btn-secondary btn-icon-split btn-lg">
        <span class="icon text-white-50">
            <i class="fas fa-chevron-left"></i>
        </span>
        <span class="text">Back</span>
    </a>

    <div class="card shadow mb-4">
        <div class="card-body">

            <div class="h3 mx-auto d-block text-center"><?= $resep['judul'] ?></div>
            <img class="mx-auto d-block figure-img img-fluid rounded" style="max-width: 500px; width: 100%; height: 350px; object-fit: cover;" src=" assets/img/resep/<?= $resep['image']; ?>" alt="foto resep">
            <div class="h5 mt-3 text-center">Author : <?= $penulis['nama'] ?></div>
            <div class="h6 text-center">Terakhir Diubah pada <?= $tanggal ?></div>
            <div class="h6">Bahan :</div>
            <div>
                <ul>
                    <?php foreach (array_slice($bahan, 1) as $perbahan) : ?>
                        <li><?= $perbahan ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="h6">Langkah :</div>
            <ol>
                <?php foreach (array_slice($langkah, 1) as $perlangkah) : ?>
                    <li><?= $perlangkah ?></li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>