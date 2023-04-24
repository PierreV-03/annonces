<?php 
/*

Page template : listes des annonces de l'utilisateur courant

Paramètres : $annoncesEnCours : liste des annonces toujours disponibles
             $annoncesFinies : liste des annonces qui ne sont plus disponible

*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "template/fragments/head.php"?>
    <title>Vos annonces</title>
</head>
<body onload="refresh()">
    <?php include "template/fragments/header.php" ?>

    <!-- Annonces en cours  -->

    <h2>Vos annonces toujours en ligne </h2>
    <?php 
        //Si la liste des annonces en cours est vide :
        if(empty($annoncesEnCours)){
            //On met un message l'indiquant
            echo "Vous pas d'annonce en ligne en ce moment";
        }//Sinon :
        else{
            //Pour chaque annonce de la liste :
            foreach($annoncesEnCours as $annonce){
                //On un résumé de l'annonce :
                include "template/fragments/resum_annonce.php";
            }
        }
    
    ?>


    <!-- Annonces finies -->
    <h2>Vos annonces finies</h2>
    <?php 
        //Si la liste des annonces finies est vide :
        if(empty($annoncesFinies)){
            //On affiche un message l'indiquant
            echo "Vous n'avez aucune annonce finies";
        }//Sinon :
        else{
            //Pour chaque annonce de la liste :
            foreach($annoncesFinies as $annonce){
                //On affiche un résumé de l'annonce :
                include "template/fragments/resum_annonce_finie.php";
            }
        }
    ?>
    
    <script src="js/jquery.js"></script>
    <script src="js/script.js"></script>
    
</body>
</html>