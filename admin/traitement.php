<?php
    session_start();
    require_once('../config/database.php');
    
    if ($_SERVER['HTTP_REFERER'] == 'http://localhost/php/cirque/admin/form.php' || (isset($_GET['update']) && !empty($_GET['update']))) { // vérifie qu'on vient bien du formulaire
        //die('ok') pour voir les erreures) {  //on reccupere ce quise trouve dans form on utilise la methode post

        // nettoyage des données $post cest la methode utiliser dans form sa peut etre get aussi
        $nomDuSpectacle = htmlspecialchars($_POST['nomDuSpectacle']);
        $nomDeLaSalle = htmlentities($_POST['salle']);
        $nombreDePlace= (int)$_POST['nombrePlace'];
        $dateDuSpectacle = $_POST['date'];
        $prix = (int)$_POST['prix'];
        $photo = null;
        $description = htmlentities($_POST['description']);
        
       
        $valid = true;

        if ($_GET['update']) {
            $action = 'update';
            $id = (int)$_GET['update'];
        } else {
            $action = 'create';
        }
    

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

            if ($action === 'create' || ($action === 'update' && $_FILES['photo']['name'])) { // si création ou si présence d'une image lors de la modification
                if (empty($_FILES['photo']['name']) || $_FILES['photo']['size'] > 2000000 || !in_array($_FILES['photo']['type'], $authorizedFormats)) {
                    $errorMessage .= '<p>- l\'image est obligatoire, ne doit pas dépasser 2 Mo et doit être au format PNG, JPG, JPEG, JP2 ou WEBP.</p>';
                    $validation = false;
                } else {
                    $timestamp = time(); // récupère le nombre de secondes écoulées depuis le 1er janvier 1970
                    $format = strchr($_FILES['photo']['name'], '.'); // récupère tout ce qui se trouve après le point (png, jpg, ...)
                    $imgName = $timestamp . $format; // crée le nouveau nom d'image
                    move_uploaded_file($_FILES['photo']['tmp_name'], '../assets/img/posts/' . $imgName); // upload du fichier
                }
            }
        }

        if (strlen($description) > 65535) { // vérification de la description
            $valid = false;
        }

        if ($valid === true) {
            if ($action === 'create') {//action de creation
                $req = $db->prepare('INSERT INTO cirque (nom_du_spectacle, nom_de_la_salle, nombre_de_place, date_du_spectacle, prix, photo, description) VALUES (:nom_du_spectacle, :nom_de_la_salle, :nombre_de_place, :date_du_spectacle, :prix, :photo, NOW() :description)');// prépare la requête
            } else {//action de modification
                $reqImg = $db->query('SELECT photo FROM cirque WHERE id=' . $id);
                $oldImg = $reqImg->fetch();
                if (isset($imgName)) {//j'ai bien une nouvelle image a inserer dans la base de donnée
                    if (file_exists('../assets/img/posts/' . $oldImg['photo'])) {
                        unlink('../assets/img/posts/' . $oldImg['photo']);
                    }//on cherche d'abord l'ancienne image pour la supprimer pour ne pas avoir pleins d'images inutile dans notre dossier
                } else {
                    $imgName = $oldImg['img'];//si jai pas d'image il faut remettre lancienne
                }
                //on fait la requette pour inserer la nouvelle img
                $req = $db->prepare('UPDATE cirque SET nom_du_spectacle=:nom_du_spectacle, nom_de_la_salle=:nom_de_la_salle, nombre_de_place=:nombre_de_place, date_du_spectacle=:date_du_spectacle, prix=:prix, photo=:photo, updated_at=NOW(), description=:description WHERE id=' . $id);
            }
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
            
            
            if ($action === 'create') {
                $_SESSION['notification'] = 'L\'article a bien été ajouté';
            } else {
                $_SESSION['notification'] = 'L\'article a bien été modifié';
            }
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