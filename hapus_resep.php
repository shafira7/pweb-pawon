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

if (hapus_resep($id) > 0) {
    //berhasil
    echo "
        <script>
        alert('resep berhasil dihapus');
        document.location.href = 'resepku.php';
        </script>
    ";
} else {
    //gagal
    echo "
        <script>
        alert('resep gagal dihapus');
        document.location.href = 'resepku.php';
        </script>
    ";
}
