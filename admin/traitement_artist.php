<?php
    session_start();
    require_once('../config/database.php');
    
    if ($_SERVER['HTTP_REFERER'] == 'http://localhost/php/cirque/admin/form_artist.php') {  //on reccupere ce quise trouve dans form on utilise la methode post

        // nettoyage des données
        $name = htmlspecialchars($_POST['name']);
        $description = htmlentities($_POST['description']);
        $photo = null;
        $valid = true;

        if (empty($name) || strlen($name) > 100) {
            $valid = false;
        }


        if (strlen($description) > 65535) { // vérification de la description
            $valid = false;
        }


        if (isset($_FILES['img']) && !empty($_FILES['img']['name'])) {
            $mimeTypes = [
                'image/png',
                'image/jpg',
                'image/jpeg'
            ];
            if (in_array($_FILES['img']['type'], $mimeTypes) && $_FILES['img']['size'] <= 2000000) {
                $img = 'artist_' . time() . strrchr($_FILES['img']['name'], '.');
            }
        }

        

        if ($valid === true) {//si il nya pas d'erreure
                  
            $req = $db->prepare('INSERT INTO artist (name, description, img) VALUES (:name, :description, :img)');
            $req->bindParam(':name', $name, PDO::PARAM_STR);
            $req->bindParam(':description', $description, PDO::PARAM_STR);
            $req->bindParam(':img', $img, PDO::PARAM_STR);
            $req->execute();
            
            move_uploaded_file($_FILES['img']['tmp_name'], '../assets/img/artist/' . $img); // deplacer le fichier
            $_SESSION['notification'] = 'L\'article a bien été ajouté';
             header('Location: index.php'); // redirection
        } else {//si il ya une erreure
            $_SESSION['notification'] = $errorMessage;
            $_SESSION['form_artist'] = [
                'name' => $name,
                'description'=>$description,
                'img'=> $img,
                
            ];
             header('Location: form_artist.php');
        }

    }  elseif (isset($_GET['delete']) && !empty($_GET['delete'])) {
        $id = (int)$_GET['delete'];
        $req = $db->query('SELECT img FROM artist WHERE id=' . $id); // récupère le nom de l'image
        $oldImg = $req->fetch();
        if (file_exists('../assets/img/artist/' . $oldImg['img'])) { // vérifie que le fichier existe
            unlink('../assets/img/artist/' . $oldImg['img']); // supprime l'image du dossier local
        }
        $reqDelete = $db->query('DELETE FROM artist WHERE id=' . $id); // supprime les données en bdd
        $_SESSION['notification'] = 'L\'article a bien été supprimé';
         header('Location: index.php'); // redirection
    }

?>