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

    if (edit_profile($_POST) > 0) {
        //berhasil
        echo "
        <script>
        alert('profil berhasil diubah!');
        document.location.href = 'index.php';
        </script>";
    } else {
        //gagal
        echo "
        <script>
        alert('profil gagal diubah');
        document.location.href = 'profile.php';
        </script>";
    }
}


?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Profile</h1>
    <div class="p-2 col-auto">
        <div class="card-body shadow mb-4">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <input type="hidden" name="id" value="<?= $user['id']; ?>">
                    <input type="hidden" name="old_image" value="<?= $user['image']; ?>">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <img class="mx-auto d-block rounded-circle" style="max-width: 300px; width: 100%; height: 300px; object-fit: cover;" src=" assets/img/profile/<?= $user['image']; ?>" alt="foto profil">
                            <input class="mt-3 mb-3 form-control-file form-control" type="file" id="image" name="image">
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class=" mb-3">
                            <input type="text" class="mb-3 text-dark form-control" id="nama" name="nama" placeholder="Nama Lengkap" required value="<?= $user['nama']; ?>">
                            <input type="text" class="mb-3 text-dark form-control" id="email" name="email" placeholder="Email" required value="<?= $user['email']; ?>">
                            <div class="pt-2 d-flex float-none">
                                <a href="profile.php" type="button" name="cancel" class="mt-1 mb-1 btn btn-outline-secondary">Cancel</a>
                                <button type="submit" name="submit" class="ml-2 mt-1 mb-1 btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>





</div>
<!-- End of Main Content -->
<?php include 'templates/footer.php'; ?>