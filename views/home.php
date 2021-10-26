<div class="container my-3">

    <h1>Accueil</h1>

    <div class="row">
        <p>Voici une sélection de spectacles de cirque et de magie. Cirque moderne plein de poésie et de prouesses techniques, cirques traditionnels célébrant les arts de la piste, habileté et humour des magiciens... Des spectacles que les enfants apprécient tout spécialement !</p>
    </div>

    <div class="row">
        <h2>Les spectacles du jour</h2>
        <?php
            $req = $db->query('SELECT * FROM cirque ORDER BY id DESC LIMIT 3');
            $spectacles = $req->fetchAll();
            foreach ($spectacles as $spectacle) { ?>
                <div class="col-sm-12 col-md-4 p-3">
                    <div class="card">
                        <img src="assets/img/photos/<?= $spectacle['photo'] ?>" class="card-img-top" alt="photo du spectacle <?= $spectacle['nom_du_spectacle'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $spectacle['nom_du_spectacle'] ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?= date('Y-m-d', strtotime($spectacle['date_du_spectacle'])) ?></h6>
                            <p class="card-text"><?= substr($spectacle['description'], 0, 200) . '...' ?></p>
                            <a href="index.php?page=spectacle&spectacles=<?= $spectacle['id'] ?>" class="btn btn-secondary">Lire la suite</a>
                        </div>
                    </div>
                </div>
            <?php }
        ?>
        <div class="col-12 text-end mb-5">
            <a href="index.php?page=spectacles" class="btn btn-outline-dark">Tous les spectacles</a>
        </div>
    </div>

    

</div>