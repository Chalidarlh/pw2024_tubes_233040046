<?php
require '../functions.php';
$keyword = $_GET["keyword"];

$query = "SELECT * FROM lagu WHERE
            title LIKE '%$keyword%' OR
            artist LIKE '%$keyword%' OR
            album LIKE '%$keyword%'
";
$musik = query($query);


?>

<table class="table table-striped table-dark table-hover table-bordered border-black">
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