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

$id_user = $user["id"];
$id_resep = $_GET["id"];

if (hapus_favorit($id_user, $id_resep) > 0) {
    //berhasil
    echo "
        <script>
        alert('resep berhasil dihapus dari favorit');
        document.location.href = 'favorit.php';
        </script>
    ";
} else {
    //gagal
    echo "
        <script>
        alert('resep gagal dihapus dari favorit');
        document.location.href = 'favorit.php';
        </script>
    ";
}
