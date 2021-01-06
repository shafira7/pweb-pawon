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

//cek submit udah ditekan atau blm
if (isset($_POST["submit"])) {

    if (edit_resep($_POST) > 0) {
        //berhasil
        echo "
        <script>
        alert('resep berhasil diubah!');
        document.location.href = 'index.php';
        </script>";
    } else {
        //gagal
        echo "
        <script>
        alert('resep gagal diubah');
        document.location.href = 'resepku.php';
        </script>";
    }
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Resep</h1>

    <div class="col-xl-12">
        <div class="card-body shadow mb-4">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <input type="hidden" name="id" value="<?= $resep['id']; ?>">
                    <input type="hidden" name="old_image" value="<?= $resep['image']; ?>">
                    <div class="col-xl-4 col-lg-5">
                        <div class="mb-3">
                            <label for="image" class="form-label font-weight-bold text-primary">Unggah Foto</label>
                            <img class="img-thumbnail" src="assets/img/resep/<?= $resep['image']; ?>" alt="foto resep">
                            <input class="mt-3 form-control-file form-control" type="file" id="image" name="image">
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-7">
                        <div class="form mb-3">
                            <label for="judul" class="form-label font-weight-bold text-primary">Judul</label>
                            <input type="text" class="text-dark form-control" id="judul" name="judul" placeholder="Kopi Susu Gula Aren" required value="<?= $resep['judul']; ?>">
                        </div>
                        <div class="form mb-3">
                            <label for="penulis" class="form-label font-weight-bold text-primary">Penulis</label>
                            <input type="text" readonly class="pl-2 form-control-plaintext" id="penulis" name="penulis" value="<?= $user['nama'] ?>">
                        </div>
                        <div class="form">
                            <label for="deskripsi" class="form-label font-weight-bold text-primary">Deskripsi</label>
                            <textarea class="text-dark form-control" id="deskripsi" name="deskripsi" style="height: 98px" required><?= $resep['deskripsi']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="form mb-3">
                        <label for="bahan" class="form-label font-weight-bold text-primary">Bahan</label>
                        <textarea class="text-dark form-control" id="bahan" name="bahan" style="height: 85px" required value="<?= $resep['bahan']; ?>"><?= $resep['bahan']; ?></textarea>
                    </div>
                    <div class="form">
                        <label for="langkah" class="form-label font-weight-bold text-primary">Langkah-langkah</label>
                        <textarea class="text-dark form-control" id="langkah" name="langkah" style="height: 85px" required><?= $resep['langkah']; ?></textarea>
                    </div>
                </div>
                <div class="m-3 pt-2 d-flex justify-content-center">
                    <a href="index.php" type="button" name="cancel" class="m-1 btn btn-outline-secondary">Cancel</a>
                    <button type="submit" name="submit" class="m-1 btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>

</div>

<?php include 'templates/footer.php'; ?>