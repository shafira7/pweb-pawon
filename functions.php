<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "pawon";


$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function registrasi($data)
{
    global $conn;

    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    //cek email udah ada atau blm
    $result = mysqli_query($conn, "SELECT email FROM user WHERE email = '$email'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('Email sudah terdaftar!');
              </script>
              ";
        return false;
    }

    //cek password & konfirmasi password
    if ($password !== $password2) {
        echo "<script>
                alert('Password tidak sesuai');
              </script>
              ";
        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO user VALUES('', '$nama', '$email', DEFAULT, '$password', DEFAULT) ");

    return mysqli_affected_rows($conn);
}

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function upload($page)
{
    $image = $_FILES['image']['name'];
    $size = $_FILES['image']['size'];
    $error = $_FILES['image']['error'];
    $tmp_name = $_FILES['image']['tmp_name'];

    if ($error === 4) {
        echo "<script>
                alert('Mohon pilih foto!')
                </script>";
        return false;
    }

    $formatImageValid = ['jpg', 'jpeg', 'png'];
    $formatImage = explode('.', $image);
    $formatImage = strtolower(end($formatImage));

    if (!in_array($formatImage, $formatImageValid)) {
        echo "<script>
                alert('Yang anda upload bukan foto!')
                </script>";
        return false;
    }

    if ($size > 10000000) {
        echo "<script>
                alert('Ukuran foto terlalu besar!')
                </script>";
        return false;
    }

    $new_name = uniqid();
    $new_name .= '.';
    $new_name .= $formatImage;

    if ($page == 1) {
        move_uploaded_file($tmp_name, 'assets/img/profile/' . $new_name);
    } elseif ($page == 2) {
        move_uploaded_file($tmp_name, 'assets/img/resep/' . $new_name);
    }


    return $new_name;
}

function tambah_resep($data)
{
    global $conn;

    $id_user = $data["id"];
    $judul = htmlspecialchars($data["judul"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    $bahan = htmlspecialchars($data["bahan"]);
    $langkah = htmlspecialchars($data["langkah"]);

    $image = upload(2);
    if (!$image) {
        return false;
    }

    $query = "INSERT INTO resep
                VALUES
            ('','$id_user','$judul','$deskripsi','$image','$bahan','$langkah', DEFAULT)
            ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapus_resep($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM resep WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function edit_resep($data)
{
    global $conn;

    $id = $data["id"];
    $old_image = $data["old_image"];
    $judul = htmlspecialchars($data["judul"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    $bahan = htmlspecialchars($data["bahan"]);
    $langkah = htmlspecialchars($data["langkah"]);


    if ($_FILES['image']['error'] === 4) {
        $image = $old_image;
    } else {
        $image = upload(2);
        unlink('assets/img/resep/' . $old_image);
    }

    $query = "UPDATE resep SET
                judul = '$judul',
                deskripsi = '$deskripsi',
                image = '$image',
                bahan = '$bahan',
                langkah = '$langkah',
                date_edited = DEFAULT
                WHERE id = $id
            ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function tambah_favorit($id_user, $id_resep)
{
    global $conn;

    $ret = 0;
    $cek = mysqli_query($conn, "SELECT id_resep FROM favorit WHERE id_user = $id_user AND id_resep = $id_resep");

    if (mysqli_num_rows($cek) === 0) {
        $query = "INSERT INTO favorit
                VALUES ('$id_user', '$id_resep')
            ";
        mysqli_query($conn, $query);
        $ret = 1;
    } else {
        $ret = 0;
    }

    return $ret;
}

function hapus_favorit($id_user, $id_resep)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM favorit WHERE id_user = $id_user AND id_resep = $id_resep");

    return mysqli_affected_rows($conn);
}

function edit_profile($data)
{
    global $conn;

    $id = $data["id"];
    $old_image = $data["old_image"];
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);

    if ($_FILES['image']['error'] === 4) {
        $image = $old_image;
    } else {
        $image = upload(1);
        if ($old_image != 'default.jpg') {
            unlink('assets/img/profile/' . $old_image);
        }
    }

    $query = "UPDATE user SET
                nama = '$nama',
                email = '$email',
                image = '$image'
                WHERE id = $id
            ";

    mysqli_query($conn, $query);


    return mysqli_affected_rows($conn);
}
