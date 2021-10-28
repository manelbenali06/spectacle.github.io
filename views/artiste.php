<?php
    $id = (int)$_GET['artistes'];
    $req = $db->query('SELECT * FROM artist WHERE id=' . $id);
    $artiste = $req->fetch();
?>

<div class="container my-3">

    <div class="row">

        <div class="col-12">
            <h1><?= $artist['name'] ?></h1>
           
        </div>

        <div class="col-12">
            <p><?= $artist['description'] ?></p>
        </div>
        
        
        <div class="col-sm-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3 my-3">
            <img src="assets/img/artist/<?= $artist['img'] ?>" alt="<?= $artist['alt'] ?>" class="w-100">
        </div>

        
    </div>

</div>