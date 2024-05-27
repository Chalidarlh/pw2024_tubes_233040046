<?php
session_start();
require 'functions.php';

$musik = query("SELECT * FROM lagu");

//cek cookie
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    //ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM user WHERE id=$id ");
    $row = mysqli_fetch_assoc($result);

    //cek cookie dan username
    if ($key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
    }
}

if (isset($_SESSION["login"])) {
    header("Location: admin.php");
    exit;
}


if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");

    //cek username
    if (mysqli_num_rows($result) === 1) {

        //cek pw
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            // set session
            $_SESSION["login"] = true;

            //cek remember me
            if (isset($_POST['remember'])) {
                //buat cookie

                setcookie('id', $row['id'], time() + 60);
                setcookie('key', hash('sha256', $row['username']), time() + 60);
            }

            header("Location: admin.php");
            exit;
        }
    }

    $error = true;
}

//tombol cari diklik
if (isset($_POST["cari"])) {
    $musik = cari($_POST["keyword"]);
}
?>
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TTH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- css -->
    <link rel="stylesheet" href="./css/login.css">

    <!-- font -->


    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow fixed-top" style="background-color: #10140c;">
        <div class="container">
            <a class="navbar-brand" href="#">TTH</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#home">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#tth">TTH</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#admin">Admin</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- hero/jumbotron -->
    <section class="jumbotron" id="home">
        <div class="jumbotrongrup">
            <h1>TTH</h1>
            <h3>Today's Top Hits</h3>
            <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
        </div>
    </section>

    <!-- tth -->
    <section class="row justify-content-center tth" id="tth">
        <div class="col-9 table-responsive">

            <form class="d-flex mb-4" role="search" method="post">
                <input class="form-control" style="width: 300px;" type="search" placeholder="Search" name="keyword" autofocus autocomplete="off" id="keyword">
                <button class="btn btn-outline-primary" type="submit" name="cari" id="tombol-cari">Search</a></button>
            </form>

            <div class="container" id="container">
                <table class="table table-striped table-hover table-dark" id="tabel">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Artist</th>
                            <th scope="col">Album</th>
                            <th scope="col">Duration</th>
                            <th scope="col">Date Added</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($musik as $msk) : ?>
                            <tr>
                                <th scope="row"><?= $i; ?></th>
                                <td>
                                    <img src="img/<?= $msk['cover'] ?>" alt="" width="70px">
                                    <?= $msk['title']; ?>
                                </td>
                                <td><?= $msk['artist']; ?> </td>
                                <td><?= $msk['album']; ?> </td>
                                <td><?= $msk['duration']; ?> </td>
                                <td><?= $msk['dateAdded']; ?> </td>

                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col galeri">
            <div class="card mb-3 mt-5">
                <img src="./img/espresso.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
            <div class="card mb-3 mt-5">
                <img src="./img/ttpd.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
            <div class="card mb-5 mt-5">
                <img src="./img/ariana grande eternal sunshine.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
            <div class="card mb-5 mt-5">
                <img src="./img/lunchbillie.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- login -->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#182818" fill-opacity="1" d="M0,192L205.7,224L411.4,32L617.1,160L822.9,128L1028.6,96L1234.3,224L1440,64L1440,320L1234.3,320L1028.6,320L822.9,320L617.1,320L411.4,320L205.7,320L0,320Z"></path>
    </svg>

    <div class="login" id="admin">
        <div class="card border-light mb-3" style="width: 25rem; background-color: rgba(0, 0, 0, 0.2); color:white;">
            <div class="card-body p-4 mb-3">
                <h1 class="text-center mb-5">Log In</h1>

                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <p>❌ incorrect username or password</p>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <div class="input-group flex-nowrap mb-3">
                        <span class="input-group-text" id="addon-wrapping"><i data-feather="user"></i></span>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                    </div>
                    <div class="input-group flex-nowrap mb-3">
                        <span class="input-group-text" id="addon-wrapping"><i data-feather="lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <button type="submit" class="btn btn-primary " name="login">Log in</button>
                    </div>
                    <div class="registerlink text-center">
                        <p>Don't have an account? <a href="registrasi.php">Sign up here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Feather Icons -->
    <script>
        feather.replace();
    </script>

    <script src="js/script2.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>