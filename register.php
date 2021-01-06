<?php

include 'templates/auth_header.php';

require 'functions.php';

if (isset($_POST["register"])) {

    if (registrasi($_POST) > 0) {
        //berhasil
        echo "
            <script>
            alert('Anda berhasil mendaftar, mohon login');
            document.location.href = 'login.php';
            </script>";
    } else {
        //gagal
        echo mysqli_error($conn);
    }
}

?>

<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Buat Akun!</h1>
                        </div>
                        <form class="user" method="POST" action="register.php">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="nama" name="nama" placeholder="Nama Lengkap" required>
                            </div>
                            <div class=" form-group">
                                <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Email" required>
                            </div>
                            <div class=" form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password" required>
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Konfirmasi Password" required>
                                    <span id="message"></span>
                                </div>
                            </div>
                            <button type="submit" name="register" class="btn btn-primary btn-user btn-block">
                                Buat Akun
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="login.php">Sudah memiliki akun? Login disini</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include 'templates/auth_footer.php'; ?>