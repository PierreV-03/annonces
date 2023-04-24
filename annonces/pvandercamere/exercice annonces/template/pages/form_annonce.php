<?php 
/*

Page template : formulaire 


Paramètre : $erreur : message d'erreur à affiche rau cas où un champ n'est pas rempli
*/
if(empty($erreur)){
    $erreur =  "";
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "template/fragments/head.php" ?>
    <title>Faire une annonce</title>
</head>
<?php include "template/fragments/header.php" ?>
<body>
    <small style="color : red;"><?= $erreur ?></small>
    <form action="enregistre_annonce.php" enctype="multipart/form-data" method="post">
        <label>Titre/nom
            <input type="text" name="titre">
        </label>
        <br>
        <label>Description
            <textarea name="description" cols="30" rows="10"></textarea>
        </label>
        <br>
        <label>Image
            <input type="file" name="image" >
        </label>
        <br>
        <label>Prix 
            <input type="number" name="prix" >
        </label>
        <br>
        <input type="submit" value="Enregistrer">
    </form>
</body>
</html>