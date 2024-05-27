<?php
session_start();

//(jika tidak ada session login, maka kembalikan user ke halaman login)
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';
//cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {
    //cek apakah data berhasil dikirim atau tidak
    if (tambah($_POST) > 0) {
        echo "
        <script>
            alert('data added successfully!');
            document.location.href='admin.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('data added failed');
            document.location.href='admin.php';
        </script>
        ";
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TTH | Add Songs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body,
        html {
            min-height: 100vh;
            background-image: url(./img/bg2.jpg);
            background-size: cover;
            background-position: center;
            color: white;

        }

        .tambah {
            padding: 2rem;
        }
    </style>
</head>

<body>
    <div class="tambah">
        <div class="row text-center">
            <div class="col">
                <h1>Add Songs</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="artist" class="form-label">Artist</label>
                        <input type="text" class="form-control" id="artist" name="artist" required>
                    </div>
                    <div class="mb-3">
                        <label for="album" class="form-label">Album</label>
                        <input type="text" class="form-control" id="album" name="album" required>
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="form-label">Duration</label>
                        <input type="text" class="form-control" id="duration" name="duration" required>
                    </div>
                    <div class="mb-3">
                        <label for="dateAdded" class="form-label">Date Added</label>
                        <input type="text" class="form-control" id="dateAdded" name="dateAdded" required>
                    </div>
                    <div class="mb-3">
                        <label for="cover" class="form-label">Cover Album</label>
                        <input type="file" class="form-control" id="cover" name="cover" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>