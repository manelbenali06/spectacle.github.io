<?php
    $id = (int)$_GET['spectacles'];
    $req = $db->query('SELECT * FROM cirque WHERE id=' . $id);
    $cirque = $req->fetch();
?>

<div class="container my-3">

    <div class="row">

        <div class="col-12">
            <h1><?= $cirque['nom_de_la_salle'] ?></h1>
           
        </div>
        
        <div class="col-sm-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3 my-3">
            <img src="assets/img/photos/<?= $cirque['photo'] ?>">
        </div>

        <div class="col-12">
            <p><?= $cirque['description'] ?></p>
        </div>
        
    </div>

</div>