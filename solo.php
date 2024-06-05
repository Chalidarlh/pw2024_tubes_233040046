<?php
require 'functions.php';

$musik = query("SELECT * FROM lagu WHERE kategori_id=1");

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
    <title>TTH | Solo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #182818;
        }

        .tabel {
            padding: 6rem 7% 1.4rem;
        }
    </style>
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #10140c;">
        <div class="container">
            <a class="navbar-brand" href="#">TTH</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="login.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Artist
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="solo.php">Solo</a></li>
                            <li><a class="dropdown-item" href="duo.php">Duo/Group</a></li>
                        </ul>
                    </li>

                </ul>
                <form class="d-flex" role="search" method="post">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="keyword" id="keyword">
                    <button class="btn btn-outline-success" type="submit" name="cari" id="tombol-cari">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- tabel -->
    <section class="tabel">

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
    </section>

    <script src="js/script3.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>