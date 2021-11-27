<?php
//systeme de notification si le formulaire nest pas valide on revient dessus avec les infos
session_start();
if(isset($_SESSION['notification'])){
    echo $_SESSION['notification'];
    unset($_SESSION['notification']);

}



require_once('..config/database.php');
 
    if(isset($_GET['update']) && !empty($_GET['update'])){
        $id = (int)$_GET['update'];
        $req = $db->query('SELECT * FROM cirque WHERE id=' .$id);
        $spectacle = $req->fetch();
    }
?>


<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP - spectacle</title>
    <link rel="stylesheet" href="../assets/css/fontawesome.css">
    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>
    <h1><?= isset($spectacle) ? 'Modifier' : 'Ajouter' ?> un article</h1>

        <form action="traitement.php<?= isset($spectacle) ? "?update={$spectacle['id']}" : null ?>"method="post" enctype="multipart/form-data"> 

        <label for="nomDuSpectacle">Nom du spectacle</label>
        <input type="text" name="nomDuSpectacle" maxlength="100" value="<?= isset($spectacle) ? $spectacle['nomDuSpectacle'] : (isset($_SESSION['form']['nomDuSpectacle']) ? $_SESSION['form']['nomDuSpectacle'] : null) ?>" required>
        <br><br>
        <label for="salle">Nom de la salle</label>
        <input type="text" name="salle" maxlength="100" value="<?= isset($spectacle) ? $spectacle['salle'] : (isset($_SESSION['form']['salle']) ? $_SESSION['form']['salle'] : null) ?>" required>
        <br><br>
        <label for="nombrePlace">Nombre de place</label>
        <input type="number" name="nombrePlace"  min="0" max="99999" step 1 value="<?= isset($spectacle) ? $spectacle['nombrePlace'] : (isset($_SESSION['form']['nombrePlace']) ? $_SESSION['form']['nombrePlace'] : null) ?>" required>
        <br><br>
        <label for="date">Date du spectacle</label>
        <input type="datetime-local" name="date" value="<?= isset($spectacle) ? $spectacle['date'] : (isset($_SESSION['form']['date']) ? $_SESSION['form']['date'] : null) ?>" required>
        <br><br>
       <label for="adresse">Adresse de la salle</label>
       <input type="text" name="adresse" value="<?= isset($spectacle) ? $spectacle['adresse'] : (isset($_SESSION['form']['adresse']) ? $_SESSION['form']['adresse'] : null) ?>" required>
       <br><br>
        <label for="prix">Prix (€)</label>
        <input type="number" name="prix" min="0" max="999.99" step="0" value="<?= isset($spectacle) ? $spectacle['prix'] : (isset($_SESSION['form']['prix']) ? $_SESSION['form']['prix'] : null) ?>" required>
        <br><br>
        <label for="photo">Photo</label>
        <input type="file" name="photo" accept="image/png, image/jpg, image/jpeg" <?= isset($spectacle) ? null : 'required' ?>>
        <br><br>
        <label for="description">Description</label>
        <textarea name="description" cols="30" rows="10" maxlength="65535"required><?= isset($spectacle) ? $spectacle['description'] : (isset($_SESSION['form']['description']) ? $_SESSION['form']['description'] : null) ?></textarea>
        <br><br>
        <input type="submit" value="Créer">
    </form>
    
</body>

</html>