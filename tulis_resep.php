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

if (isset($_POST["submit"])) {

    if (tambah_resep($_POST) > 0) {
        //berhasil
        echo "
            <script>
            alert('resep berhasil dipost!');
            document.location.href = 'index.php';
            </script>
            ";
    } else {
        //gagal
        echo "
            <script>
            alert('resep gagal dipost');
            document.location.href = 'tulis_resep.php';
            </script>
            ";
    }
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Tulis Resep</h1>

    <div class="col-xl-12">
        <div class="card-body shadow mb-4">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <input type="hidden" name="id" value="<?= $user['id']; ?>">
                    <div class="col-xl-4 col-lg-5">
                        <div class="mb-3">
                            <label for="image" class="form-label font-weight-bold text-primary">Unggah Foto</label>
                            <input class="form-control-file form-control height-auto" type="file" id="image" name="image">
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-7">
                        <div class="form mb-3">
                            <label for="judul" class="form-label font-weight-bold text-primary">Judul</label>
                            <input type="text" class="text-dark form-control" id="judul" name="judul" placeholder="Judul Resep" required>
                        </div>
                        <div class="form mb-3">
                            <label for="penulis" class="form-label font-weight-bold text-primary">Penulis</label>
                            <input type="text" readonly class="text-dark pl-2 form-control-plaintext" id="penulis" name="penulis" value="<?= $user['nama'] ?>">
                        </div>
                        <div class="form">
                            <label for="deskripsi" class="form-label font-weight-bold text-primary">Deskripsi</label>
                            <textarea class="text-dark form-control" id="deskripsi" name="deskripsi" placeholder="Sedikit deskripsi atau cerita dibalik resep" style="height: 85px" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="form mb-3">
                        <label for="bahan" class="form-label font-weight-bold text-primary">Bahan</label>
                        <textarea class="text-dark form-control" id="bahan" name="bahan" placeholder="- 1Sdm Bahan" style="height: 100px" required></textarea>
                    </div>
                    <div class="form">
                        <label for="langkah" class="form-label font-weight-bold text-primary">Langkah-langkah</label>
                        <textarea class="text-dark form-control" id="langkah" name="langkah" placeholder="- Langkah langkah" style="height: 100px" required></textarea>
                    </div>
                </div>
                <div class="m-3 pt-2 d-flex justify-content-center">
                    <a href="index.php" type="button" name="cancel" class="m-1 btn btn-outline-secondary">Cancel</a>
                    <button type="submit" name="submit" class="m-1 btn btn-primary">Post</button>
                </div>
            </form>

        </div>
    </div>

</div>

<?php include 'templates/footer.php'; ?>