<?php 
/*

Page contrôleur : affiche un formulaire pour faire une nouvelle offre

Paramètres : GET : id l'annonce s"électionnée

*/
//Initialisation 
include "template/fragments/init.php";

//Analyse de la demande :
    //Récupération des paramètre :
    $idAnnonce = $_GET["id"];
    

//Affichage :
include "template/pages/form_offre.php";
?>

