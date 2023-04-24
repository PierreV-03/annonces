<?php 
/*

Page template : formulaire de connexion

Paramètres: $erreurPseudo : messsage d'erreur à afficher si le pseudo est déjà utilisé
            $erreurMail : messsage d'erreur à afficher si le mail est déjà utilisé

*/
//Récupération des param : 
    //Si le message est vide : 
    if(empty($erreurPseudo)){
        $erreurPseudo = " ";
    }

    if(empty($erreurMail)){
        $erreurMail = " ";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "template/fragments/head.php" ?>
    <title>Inscription</title>
</head>
<body>
    <h2>Inscription</h2>
    <form action="inscription.php" method="post">
        <small><?= $erreurMail ?></small>
        <br>
        <label>Mail
            <input type="text" name="mail">
        </label>
        <br>
        <small><?= $erreurPseudo ?></small>
        <br>
        <label>Pseudo
            <input type="text" name="pseudo" >
        </label>
        <br>
        <label> Mot de passe
            <input type="text" name="password">
        </label>
        <br>
        <input type="submit" value="Envoyer"> 
    </form>

    <a href="affiche_form_connexion.php"><button>Retour</button></a>
</body>
</html>