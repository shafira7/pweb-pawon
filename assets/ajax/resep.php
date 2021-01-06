<?php

require '../../functions.php';

$keyword = $_GET["keyword"];

$query = "SELECT * FROM resep
        WHERE
        judul LIKE '%$keyword%' OR
        deskripsi LIKE '%$keyword%'
        ";

$resep = query($query);

?>

<div class="row d-flex flex-wrap justify-content-center">
    <?php foreach ($resep as $row) : ?>
        <div class="p-2 col-auto">
            <div class="card center shadow" style="width: 18rem;">
                <img class="card-img-top img-fluid" src="assets/img/resep/<?= $row["image"]; ?>" alt="image">
                <div class="card-body">
                    <a href="page_resep.php?id=<?php echo $row["id"] ?>" class="h5 stretched-link card-title text-primary"><?php echo $row["judul"] ?></a>
                    <p class="card-text"><?php echo $row["deskripsi"] ?></p>
                </div>
                <div class="card-footer text-muted">
                    <p class="card-text"><small class="text-muted"><?php echo $row["date_edited"] ?></small></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>