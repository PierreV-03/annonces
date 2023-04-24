<?php 
/*

Page template : affiche les offres de l'utilisateur courant

Paramètres :  $offreEnCours : liste des offres non-répondues
              $offresAcceptees : liste des offres acceptées
              $offresRefusees : liste des offres refusées

*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "template/fragments/head.php" ?>
    <title>Vos offres</title>
</head>
<body onload="refresh()">
    <?php include "template/fragments/header.php" ?>

    <!-- Liste des offres en cours -->
    <h2>Vos offres en cours</h2>

    <?php
        //Si la liste des offres en cours est vide :
        if(empty($offreEnCours)){
            //On affiche simplement un texte :
            echo "Pas d'offres en cours";
        }//Sinon :
        else{
            //On affiche un résumé pour chaque offre :
            foreach($offreEnCours as $offre){       
                include "template/fragments/resum_offre_active.php"; 
            }
        }

    ?>

    <!-- Liste des offres acceptées -->
    <h2>Vos offres acceptées </h2>

    <?php
        //Si la liste des offres acceptées est vide :
        if(empty($offresAcceptees)){
            //On affiche simplement un texte :
            echo "Pas d'offres acceptées";
        }//Sinon :
        else{
            //On affiche un résumé pour chaque offre :
            foreach($offresAcceptees as $offre){       
                include "template/fragments/resum_offre_active.php"; 
            }
        }

    ?>

    <!-- Liste des offres refusées -->
    <h2>Vos offres refusées</h2>

    <?php
        //Si la liste des offres refusées  est vide :
        if(empty($offresRefusees)){
            //On affiche simplement un texte :
            echo "Pas d'offres refusées";
        }//Sinon :
        else{
            //On affiche un résumé pour chaque offre :
            foreach($offresRefusees as $offre){       
                include "template/fragments/resum_offre_active.php"; 
            }
        }

    ?>

    <script src="js/jquery.js"></script>
    <script src="js/script.js"></script>
</body>
</html>