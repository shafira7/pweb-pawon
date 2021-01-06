<?php
session_start();
require 'functions.php';

//cek cookie
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    $result = mysqli_query($conn, "SELECT email FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    //cek cookie dan email
    if ($key === hash('sha256', $row['email'])) {
        $_SESSION['login'] = true;
    }
}

//cek session
if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}
include 'templates/auth_header.php';


if (isset($_POST["login"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");

    if (mysqli_num_rows($result) === 1) {

        //cek pass
        $row = mysqli_fetch_assoc($result);
        $id = $row["id"];

        if (password_verify($password, $row["password"])) {

            //set session
            $_SESSION["login"] = true;

            //cek remember me
            if (isset($_POST['remember'])) {
                //buat cookie
                setcookie('id', $row['id'], time() + 3600);
                setcookie('key', hash('sha256', $row['email']), time() + 3600);
            }

            $_SESSION['id'] = $id;
            header("Location: index.php");
            exit;
        }

        $error = true;
    } else {
        echo "<script>
        alert('Email belum terdaftar!');
      </script>
      ";
    }
}

?>

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image">
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Selamat datang kembali!</h1>
                                </div>
                                <?php if (isset($error)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        email/password salah!
                                    </div>
                                <?php endif; ?>
                                <form class="user" method="post" action="">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Email" value="">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                            <label class="custom-control-label" for="remember">Ingat Saya</label>
                                        </div>
                                    </div>
                                    <button type="submit" name="login" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <!-- <div class="text-center">
                                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                                </div> -->
                                <div class="text-center">
                                    <a class="small" href="register.php">Buat Akun!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<?php include 'templates/auth_footer.php'; ?>