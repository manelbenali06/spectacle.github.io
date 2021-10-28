<?php
?>
<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP - connexion</title>
    <link rel="stylesheet" type="text/css" href="design/default.css">

</head>
<body>
    <h1>Inscription</h1>
    <p>Bienvenue sur mon site, pour en savoir plus, inscrivez-vous. Sinon <a href="inscription.php">connectez-vous</a></p>

    <form method="post" action="index.php">
        <table>
            <tr>
               <td>pseudo</td> 
               <td><input type ="text" name="pseudo" placeholder="EX: Nicolas"></td> 
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="email" name="email" placeholder="EX: example@google.com"></td>
            </tr>
            <tr>
                <td>Mot de passe</td>
                <td><input type="password" name="password" placeholder="EX:*****"></td>
            </tr>
            <tr>
                <td>Retaper mot de passe</td>
                <td><input type="password" name="password_confirm" placeholder="EX:*****"></td>
            </tr>
        </table>
        <button>Inscription</button>
    </form>
</body>
</html>