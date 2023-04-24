<?php 
/*

Page contrôleur : récupère toutes les offres faites pour l'annonce sélectionée

Paramètres : $GET : id de l'annonce sélectionnée

*/
//Initialisation :
include "template/fragments/init.php";

//Analyse de la demande 
    //Récupération des paramètres :
    $idAnnonce = $_GET["id"];


//Interaction avec la bse de données :
    //Récupération de la liste des offres de cette annonce :
    //On charge un objet annonce
    $annonce = new annonce();
    $annonce->loadById($idAnnonce);

    //Récupération des offres faites sur l'annonce :
    $listeOffre = $annonce->getOffres();

//Affichage :
include "template/pages/liste_offre_annonce.php"



?>