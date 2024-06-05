<?php
session_start();

//(jika tidak ada session login, maka kembalikan user ke halaman login)
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

//pagination
//konfigurasi
$jumlahDataPerHal = 10;
$jumlahData = count(query("SELECT * FROM lagu"));
$jumlahHal = ceil($jumlahData / $jumlahDataPerHal);
$halAktif = (isset($_GET["halaman"])) ? $_GET["halaman"]
    : 1;
$awalData = ($jumlahDataPerHal * $halAktif) - $jumlahDataPerHal;


$musik = query("SELECT * FROM lagu LIMIT $awalData, $jumlahDataPerHal");

//tombol cari diklik
if (isset($_POST["cari"])) {
    $musik = cari($_POST["keyword"]);
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TTH | Today's Top Hits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css" />

    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cardo:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        body {
            font-family: "Cardo", serif;
        }
    </style>
</head>

<body>

    <!-- navbar-->
    <nav class="navbar fixed-top">
        <div class="container-fluid">
            <div class="navsatu">
                <form class="d-flex" role="search" method="post">
                    <input class="form-control me-2" type="search" placeholder="Search" name="keyword" autofocus autocomplete="off" id="keyword">
                    <button class="btn btn-outline-success" type="submit" name="cari" id="tombol-cari">Search</a></button>
                </form>
            </div>
            <div class="navdua">
                <a href="tambah.php" class="btn btn-primary me-3" role="button">Add Songs</a>
                <a href="cetak.php" class="btn btn-success me-3" role="button" target="_blank"> <i data-feather="printer"></i></a>
                <a href="logout.php" class="btn btn-danger" role="button">Log out</a>
            </div>

        </div>
    </nav>



    <!-- tabel-->
    <section class="tabel">
        <div class="table-responsive" id="container">
            <table class="table table-striped table-dark table-hover table-bordered border-black" id="tabel">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Artist</th>
                        <th scope="col">Album</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Date Added</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = $awalData + 1; ?>
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


                            <td>
                                <a href="edit.php?id=<?= $msk['id'] ?>" class="badge text-bg-warning text-decoration-none border">edit</a>
                                <a href="delete.php?id=<?= $msk['id'] ?>" class="badge text-bg-danger text-decoration-none border" onclick="return confirm ('are you sure want to delete this data?')">delete</a>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>


                </tbody>
            </table>
        </div>
    </section>


    <!-- pagination-->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <?php if ($halAktif > 1) : ?>
                    <a class="page-link" href="?halaman=<?= $halAktif - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                <?php endif; ?>
            </li>

            <?php for ($i = 1; $i <= $jumlahHal; $i++) : ?>
                <?php if ($i == $halAktif) : ?>
                    <li class="page-item active"> <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
                <?php else : ?>
                    <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <li class="page-item">
                <?php if ($halAktif < $jumlahHal) : ?>
                    <a class="page-link" href="?halaman=<?= $halAktif + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                <?php endif; ?>
            </li>
        </ul>
    </nav>

    <!-- Feather Icons -->
    <script>
        feather.replace();
    </script>

    <!-- script-->
    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>