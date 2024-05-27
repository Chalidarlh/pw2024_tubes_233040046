<?php
//Koneksi ke database
$conn = mysqli_connect('localhost', 'root', '', 'pw2024_tubes_233040046');

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

function tambah($data)
{
    global $conn;

    $title = htmlspecialchars($data["title"]);
    $artist = htmlspecialchars($data["artist"]);
    $album = htmlspecialchars($data["album"]);
    $duration = htmlspecialchars($data["duration"]);
    $dateAdded = htmlspecialchars($data["dateAdded"]);

    //upload gambar
    $cover = upload();
    if (!$cover) {
        return false;
    }

    $query = "INSERT INTO lagu VALUES
            (NULL, '$title', '$artist', '$album', '$duration', '$dateAdded', '$cover')
         ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload()
{
    $namaFile = $_FILES['cover']['name'];
    $ukuranFile = $_FILES['cover']['size'];
    $error = $_FILES['cover']['error'];
    $tmpName = $_FILES['cover']['tmp_name'];

    // //cek apakah tidak ada gambar yang diupload
    // if ($error === 4) {
    //     echo "<script>
    //         alert('please choose file to complete data');
    //          </script>";
    //     return false;
    // }

    //cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
            alert('what you uploaded is not an image');
             </script>";
        return false;
    }

    //cek jika ukurannya terlalu besar
    if ($ukuranFile > 1000000) {
        echo "<script>
            alert('image size is too large');
             </script>";
        return false;
    }

    //lolos pengecekan, gambar siap diupload
    //generate nama baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFile);
    return $namaFile;
}

function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM lagu WHERE id=$id");

    return mysqli_affected_rows($conn);
}

function edit($data)
{
    global $conn;

    $id = $data["id"];
    $title = htmlspecialchars($data["title"]);
    $artist = htmlspecialchars($data["artist"]);
    $album = htmlspecialchars($data["album"]);
    $duration = htmlspecialchars($data["duration"]);
    $dateAdded = htmlspecialchars($data["dateAdded"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    //cek apakah user pilih gambar baru atau tidak
    if ($_FILES['cover']['error'] === 4) {
        $cover = $gambarLama;
    } else {
        $cover = upload();
    }


    $query = "UPDATE lagu SET
          title='$title',
          artist='$artist',
          album= '$album',
          duration='$duration',
          dateAdded='$dateAdded',
          cover='$cover'
          WHERE id=$id
          ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function cari($keyword)
{
    $query = "SELECT * FROM lagu WHERE
                title LIKE '%$keyword%' OR
                artist LIKE '%$keyword%' OR
                album LIKE '%$keyword%'
                ";

    return query($query);
}

function registrasi($data)
{
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    //cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username='$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                 alert('username is already registered');
                 </script>";
        return false;
    }

    //cek konfirmasi pw
    if ($password !== $password2) {
        echo "<script>
                alert('Confirm password is incorrect');
                </script>";
        return false;
    }

    //enkripsi pw
    $password = password_hash($password, PASSWORD_DEFAULT);

    //tambahkan userbaru ke db
    mysqli_query($conn, "INSERT INTO user VALUES(NULL,'$username', '$password')");

    return mysqli_affected_rows($conn);
}

//pagination
//konfigurasi
$jumlahDataPerHal = 10;
$jumlahData = count(query("SELECT * FROM lagu"));
$jumlahHal = ceil($jumlahData / $jumlahDataPerHal);
$halAktif = (isset($_GET["halaman"])) ? $_GET["halaman"]
    : 1;
$awalData = ($jumlahDataPerHal * $halAktif) - $jumlahDataPerHal;
