<?php 
/*

Page template : formulaire d'activation du compte

Paramètres : $erreur : message d'erreur si les identifiants sont mauvais

*/
//Récupération des paramètres: 
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
    <title>Activation</title>
</head>
<body>
    <p> Entrez le code reçu pour activer votre compte</p>
    <form action="verif_code.php" method="post">
        <small style="color : red;"><?=$erreur ?></small>
        <br>
        <label>Pseudo du compte
            <input type="text" name="pseudo" >
        </label>
        <br>
        <label>Code d'activation
            <input type="text" name="code">
        </label>
        <br>
        <input type="submit" value="Confirmer">
    </form>
</body>
</html>