<?php 
/*

Page template : formulaire d'ajout d'offre pour l'annonce sélectionnée

Paramètres : néant

*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php  include "template/fragments/head.php"?>
    <title>Faire une offre</title>
</head>
<body>
    <?php include "template/fragments/header.php"?>

    <!-- Formulaire -->

    <form action="ajout_offre.php?id=<?= $idAnnonce ?>" method="post">
        <label>Message :
            <textarea name="message" cols="30" rows="10"></textarea>
        </label>
        <br>
        <label>Prix 
            <input type="number" name="prix">
        </label>
        <br>
        <input type="submit" value="Envoyer">
    </form>


    
</body>
</html>