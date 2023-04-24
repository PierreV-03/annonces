<?php 
/*

Page contrôleur : affiche l'annonce sélectionnée par l'utilisateur

Paramètres : GET : id de l'annonce

*/
//Initialisation :
include "template/fragments/init.php";

//Analyse de la demande :
    //Récupération des paramètres :
    $idAnnonce = $_GET["id"];

//Interaction avec la base de données : 
    //Chargement d'un nouvel objet "annonce"
    $annonce = new annonce();
    $annonce->loadById($idAnnonce);

//Affichage : 
include "template/fragments/contenu_annonce.php";
?>