<?php 
/*

Page contrôleur : affiche un formulaire pour ajouter une nouvelle annonce

Paramètre : néant

*/
//Initialisation :
include "template/fragments/init.php";

//Vérification de la connexion :
    //On redirige l'utilisateur s'il n'est pas connecté :
    if(!isConnected()){
        include "template/pages/form_connexion.php";
        exit;
    }

//Analyse de la demande 
    //Récupération des paramètres : néant
   
    
//Affichage :
include "template/pages/form_annonce.php";
?>