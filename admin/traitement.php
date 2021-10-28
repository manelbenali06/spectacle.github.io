<?php
    session_start();
    require_once('../config/database.php');
    
    if ($_SERVER['HTTP_REFERER'] == 'http://localhost/php/cirque/admin/form.php') {  //on reccupere ce quise trouve dans form on utilise la methode post

        // nettoyage des données
        $nomDuSpectacle = htmlspecialchars($_POST['nomDuSpectacle']);
        $nomDeLaSalle = htmlentities($_POST['salle']);
        $nombreDePlace= (int)$_POST['nombrePlace'];
        $dateDuSpectacle = $_POST['date'];
        $prix = (int)$_POST['prix'];
        $photo = null;
        $description = htmlentities($_POST['description']);
        $valid = true;

        if (empty($nomDuSpectacle) || strlen($nomDuSpectacle) > 100) {
            $valid = false;
        }

        if (empty($nomDeLaSalle) || strlen($nomDeLaSalle) > 100) { // vérifiaction du contact
            $valid = false;
        }

        if (empty($nombreDePlace) || strlen($nombreDePlace) > 100) { 
            $valid = false;
        }

        if (empty($dateDuSpectacle)) { 
            $valid = false;
        }

        if ($prix < 0 || $prix > 99999999) { // vérification du prix
            $valid = false;
        }

        if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
            $mimeTypes = [
                'image/png',
                'image/jpg',
                'image/jpeg'
            ];
            if (in_array($_FILES['photo']['type'], $mimeTypes) && $_FILES['photo']['size'] <= 2000000) {
                $photo = 'cirque_' . time() . strrchr($_FILES['photo']['name'], '.');
            }
        }

        if (strlen($description) > 65535) { // vérification de la description
            $valid = false;
        }

        if ($valid === true) {
            $dateDuSpectacle = date_format((new \DateTime($dateDuSpectacle)), 'Y-m-d h:i:s');       
            $req = $db->prepare('INSERT INTO cirque (nom_du_spectacle, nom_de_la_salle, nombre_de_place, date_du_spectacle, prix, photo, description) VALUES (:nom_du_spectacle, :nom_de_la_salle, :nombre_de_place, :date_du_spectacle, :prix, :photo, :description)');
            $req->bindParam(':nom_du_spectacle', $nomDuSpectacle, PDO::PARAM_STR);
            $req->bindParam(':nom_de_la_salle', $nomDeLaSalle, PDO::PARAM_STR);
            $req->bindParam(':nombre_de_place', $nombreDePlace, PDO::PARAM_INT);
            $req->bindParam(':date_du_spectacle', $dateDuSpectacle, PDO::PARAM_STR);
            $req->bindParam(':prix', $prix, PDO::PARAM_INT);
            $req->bindParam(':photo', $photo, PDO::PARAM_STR);
            $req->bindParam(':description', $description, PDO::PARAM_STR);
            $req->execute();
            
            move_uploaded_file($_FILES['photo']['tmp_name'], '../assets/img/photos/' . $photo); // upload du fichier
            $_SESSION['notification'] = 'L\'article a bien été ajouté';
             header('Location: index.php'); // redirection
        } else {
            $_SESSION['notification'] = $errorMessage;
            $_SESSION['form'] = [
                'nomDuSpectacle' => $nomDuSpectacle,
                'salle' => $nomDeLaSalle,
                'nombrePlace' => $nombreDePlace,
                'date' => $dateDuSpectacle,
                'prix'=> $prix,
                'photo'=> $photo,
                'description'=>$description,
            ];
             header('Location: form.php');
        }

    }  elseif (isset($_GET['delete']) && !empty($_GET['delete'])) {
        $id = (int)$_GET['delete'];
        $req = $db->query('SELECT photo FROM cirque WHERE id=' . $id); // récupère le nom de l'image
        $oldImg = $req->fetch();
        if (file_exists('../assets/img/photos/' . $oldImg['photo'])) { // vérifie que le fichier existe
            unlink('../assets/img/photos/' . $oldImg['photo']); // supprime l'image du dossier local
        }
        $reqDelete = $db->query('DELETE FROM cirque WHERE id=' . $id); // supprime les données en bdd
        $_SESSION['notification'] = 'L\'article a bien été supprimé';
         header('Location: index.php'); // redirection

    }  
?>