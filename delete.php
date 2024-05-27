<?php
session_start();

//(jika tidak ada session login, maka kembalikan user ke halaman login)
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

$id = $_GET["id"];

if (hapus($id) > 0) {
    echo "
        <script>
            alert('data deleted successfully!');
            document.location.href='admin.php';
        </script>
        ";
} else {
    echo "
        <script>
            alert('data failed to delete');
            document.location.href='admin.php';
        </script>
        ";
}
