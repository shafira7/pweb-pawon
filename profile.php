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

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Profile</h1>
    <div class="p-2 col-auto">
        <div class="card-body shadow mb-4">
            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-3">
                        <img class="mx-auto d-block rounded-circle" style="max-width: 300px; width: 100%; height: 300px; object-fit: cover;" src=" assets/img/profile/<?= $user['image'] ?>" alt="foto profil">
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="mb-3">
                        <h2 class="text-md-center text-lg-left text-dark"><?= $user['nama'] ?></h2>
                        <p class="text-md-center text-lg-left text"><?= $user['email'] ?></p>
                        <div class="pt-2 d-flex float-none">
                            <a href="edit_profile.php" type="button" class="mt-1 mb-1 btn text-md-center btn-secondary">Edit Profil</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





</div>
<!-- End of Main Content -->
<?php include 'templates/footer.php'; ?>