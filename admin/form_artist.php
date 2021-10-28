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
    <title>PHP - ARTISTE</title>
    <link rel="stylesheet" href="../assets/css/fontawesome.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <form action="traitement_artist.php" method="post" enctype="multipart/form-data">

        <label for="name">Nom de l'artiste</label>
        <input type="text" name="name" maxlength="100" required>
        <br><br>
        <label for="description">Description</label>
        <textarea name="description" cols="30" rows="10" maxlength="65535"></textarea>
        <br><br>
        <label for="img">Image</label>
        <input type="file" name="img" accept="image/png, image/jpg, image/jpeg">
        <br><br>
        <input type="submit" value="Créer">
    </form>
    
</body>

</html>