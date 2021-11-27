<div class="container my-3">

    <h1>spectacles</h1>

    <div class="row">
        <div class="col-12">
            <?php
                $req = $db->query('SELECT * FROM cirque ORDER BY id DESC');
                $spectacles = $req->fetchAll();
            ?>
            <table class="table">
                <thead>
                    <tr>
                       <th>N°</th>
                        <th>Nom du Spectacle</th>
                        <th>Nom de la salle</th>
                        <th>Nombre de place</th>
                        <th>Date Du spectacle</th>
                        <th>Prix</th>
                        <th>Photos</th>
                        <th>Description</th>
                        <th>Actions</th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 1;
                        foreach ($spectacles as $spectacle) { ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $spectacle['nom_du_spectacle'] ?></td>
                                <td><?= $spectacle['nom_de_la_salle'] ?></td>
                                <td><?= $spectacle['nombre_de_place'] ?></td>
                                <td><?= date('Y-m-d', strtotime($spectacle['date_du_spectacle'])) ?></td>
                                <td><?= $spectacle['prix'] ?></td>
                                
                                <td><img src="assets/img/photos/<?= $spectacle['photo'] ?>"></td>
                                <td><?= substr($spectacle['description'], 0, 200) ?></td>
                                
                                
                                <td><a href="index.php?page=spectacle&spectacles=<?= $spectacle['id'] ?>"><i class="fas fa-eye"></i></a></td>
                                <td><a href="index.php?page=spectacle&spectacles=<?= $spectacle['id'] ?>"><i class="fas fa-trash"></i></a></td>
                                <td><a href="index.php?page=spectacle&spectacles=<?= $spectacle['id'] ?>"><i class="fas fa-pen-square"></i></a></td>
                            </tr>
                        <?php 
                            $i++;   
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>