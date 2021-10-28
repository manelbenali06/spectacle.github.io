<?php

session_start();
if (isset($_SESSION['notification'])) {
    echo $_SESSION['notification'];
}
session_destroy();
require_once('../config/database.php');
$req = $db->query('SELECT * FROM cirque');
$spectacles = $req->fetchAll();

?>

<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CIRQUE</title>
        <link rel="stylesheet" href="../assets/css/fontawesome.css">
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>

    <body>

        <table>
            <thead>
                <tr>
                    <th>Nom de la salle</th>
                    <th>Nombre de place</th>
                    <th>Date du spectacle</th>
                    <th>Prix</th>
                    <th>Photo</th>
                    <th>Description</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($spectacles as $cirque) { ?>
                        <tr>
                            <td><?= $cirque['nom_de_la_salle'] ?></td>
                            <td><?= $cirque['nombre_de_place'] ?></td>
                            <td><?= $cirque['date_du_spectacle'] ?></td>
                            <td><?= $cirque['prix'] ?>€</td>
                            <td><?= empty($cirque['photo']) ? '(pas de photo pour cette scene)' : "<img src=\"../assets/img/photos/{$cirque['photo']}\">" ?></td>
                            <td><?= $cirque['description'] ?></td>
                            <td>
                                <a href="#"><i class="fas fa-pen-square"></i></a><br>
                                <a href="traitement.php?delete=<?= $cirque['id'] ?>"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php }
                ?>
            </tbody>
        </table>    

        <!-- afficher les images et couper les données trop longues -->

        <a href="form.php">Ajouter un evenement</a><br><br><br>
        <a href="form_artist.php">Ajouter un artiste</a>
            
    </body>

</html>