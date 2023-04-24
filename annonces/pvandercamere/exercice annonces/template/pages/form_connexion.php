<?php 
/*

Page template : affiche un formulaire de connexion

Paramètres : $erreur : message d'erreur au cas où l'utilisateur se trompe

*/
//Récupération des paramètres :
if(empty($erreur)){
    $erreur = " ";
}else{
    $erreur = $erreur;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Connexion</h2>
    <small style="color : red;"><?= $erreur ?></small>
    <form action="connexion.php" method="post">
        <label> Pseudo
            <input type="text" name="pseudo">
        </label>
        <br>
        <label>Mot de passe 
            <input type="password" name="password">
        </label>
        <br>
        <input type="submit" value="Connexion">
    </form>

    <p>Pas de compte ? <a href="affiche_form_inscription.php" title="S'incrire"><button>S'inscrire</button></a> </p>
</body>
</html>