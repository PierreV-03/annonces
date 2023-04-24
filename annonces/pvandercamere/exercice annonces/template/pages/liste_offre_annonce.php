<?php 
/*

Page template : affiche la liste des offres faite sur l'annonce selectionné

Paramètres : $listeOffre : liste des offres

*/
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "template/fragments/head.php" ?>
    <title>Offres proposées</title>
</head>
<body>
    <?php include "template/fragments/header.php" ?>
    <h2>Offres faites sur cette annonce </h2>

    <?php 
        //Pour chaque offre de la liste :
        foreach($listeOffre as $offre){
            //On affiche le contenu de l'offre
            include "template/fragments/resum_offre.php";
        }



    ?>
    
</body>
</html>