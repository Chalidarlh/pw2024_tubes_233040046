<?php
session_start();

//(jika tidak ada session login, maka kembalikan user ke halaman login)
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

require 'functions.php';
$musik = query("SELECT * FROM lagu");

$mpdf = new \Mpdf\Mpdf();

$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/print.css">
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cardo:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
</head>
<body>
<h1> TTH </h1>
    <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Cover Album</th>
                        <th scope="col">Title</th>
                        <th scope="col">Artist</th>
                        <th scope="col">Album</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Date Added</th>
                    </tr>
                </thead>';

$i = 1;
foreach ($musik as $msk) {
    $html .= '<tr>
                        <td>' . $i++ . '</td>
                        <td><img src="img/' . $msk["cover"] . '"></td>
                        <td>' . $msk["title"] . '</td>
                        <td>' . $msk["artist"] . '</td>
                        <td>' . $msk["album"] . '</td>
                        <td>' . $msk["duration"] . '</td>
                        <td>' . $msk["dateAdded"] . '</td>
                        
                    </tr>';
}

$html .= ' </table>
    
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('TTH.pdf', \Mpdf\Output\Destination::INLINE);
