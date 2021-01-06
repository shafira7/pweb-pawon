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

if (tambah_favorit($id_user, $id_resep) > 0) {
    //berhasil
    echo "
        <script>
        alert('resep ditambah ke favorit');
        document.location.href = 'index.php';
        </script>
    ";
} else {
    //gagal
    echo "
        <script>
        alert('resep sudah ada dalam favorit');
        document.location.href = 'index.php';
        </script>
    ";
}
