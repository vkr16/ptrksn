<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="<?= base_url('public/assets/img') ?>/a-logo.png" type="image/x-icon">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" />

    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/e4b7aab4db.js" crossorigin="anonymous"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('public/assets') ?>/css/main.css" />


</head>

<body>

    <body class="login-page">
        <div class="card position-center login-box mx-auto card-accent-indigo">
            <div class="card-header text-center p-3 bg-white">
                <span class="fw-bold h1">SUBDIT </span><span class="fw-light h1">PTRKSN III</span>
            </div>
            <div class="card-body">
                <p class="text-center">Masuk untuk memulai sesi anda</p>
                <form action="login" method="POST">
                    <div class="input-group mb-3">
                        <input required type="text" class="form-control" name="email" placeholder="Alamat Email" />
                        <span class="input-group-text bg-indigo-light">
                            <i class="fas fa-envelope"></i>
                        </span>
                    </div>
                    <div class="input-group mb-3">
                        <input required type="password" class="form-control" name="password" placeholder="Kata Sandi" />
                        <span class="input-group-text bg-indigo-light">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-green" type="submit">Masuk</button>
                    </div>
                </form>
                <!-- <div class="d-grid gap-1 mt-3">
                    <a href="#forgot-password" class="text-decoration-none text-indigo">
                        I forgot my password
                    </a>
                    <a href="#register" class="text-decoration-none text-indigo">
                        Create an account
                    </a>
                </div> -->
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Notiflix -->
        <script src="<?= base_url('public/assets') ?>/js/notiflix-aio-3.2.5.min.js"></script>
    </body>

</html>

<?php
if (isset($_COOKIE['login']) && $_COOKIE['login'] == 'incorrect') {
    echo '
    <script>
        Notiflix.Notify.failure("Password Incorrect");
    </script>';
} else if (isset($_COOKIE['login']) && $_COOKIE['login'] == 'suspended') {
    echo '
    <script>
        Notiflix.Notify.failure("Account Suspended");
    </script>';
} else if (isset($_COOKIE['login']) && $_COOKIE['login'] == 'notexist') {
    echo '
    <script>
        Notiflix.Notify.failure("Account Not Found");
    </script>';
}
?>

<script>
    function developerCredit() {
        Notiflix.Notify.info("Developer: FM. (www.akuonline.my.id)")
    }
</script>