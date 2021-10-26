<?php

session_start();
if(isset($_SESSION['notification'])){
    echo $_SESSION['notification'];

}
session_destroy();
?>

<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP - spectacle</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <form action="traitement.php" method="post" enctype="multipart/form-data">

        <label for="nomDuSpectacle">Nom du spectacle</label>
        <input type="text" name="nomDuSpectacle" maxlength="100" required>
    
        <label for="salle">Nom de la salle</label>
        <input type="text" name="salle" maxlength="100" required>

        <label for="nombrePlace">Nombre de place</label>
        <input type="number" name="nombrePlace"  min="0" max="99999" step 1 required>

        <label for="date">Date du spectacle</label>
        <input type="datetime-local" name="date">

       <label for="adresse">Adresse de la salle</label>
       <input type="text" name="adresse">

       <!-- <label for="ville">Ville</label>
        <input type="text" name="ville" maxlength="50" required>

        <label for="cp">Code postal</label>
        <input type="number" name="cp" min="1000" max="99999" step="1" required>-->

        <label for="prix">Prix (€)</label>
        <input type="number" name="prix" min="0" max="999.99" step="0" required>

        <label for="photo">Photo</label>
        <input type="file" name="photo" accept="image/png, image/jpg, image/jpeg">

        <label for="description">Description</label>
        <textarea name="description" cols="30" rows="10" maxlength="65535"></textarea>
      
        <input type="submit" value="Créer">
    </form>
    
</body>

</html>