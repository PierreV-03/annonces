<?php 
/*

Page contrôleur : récupère dans la bdd toutes les annonces de l'utilisateur

Paramètres : néant

*/
//Initialisation :
include "template/fragments/init.php";



//Analyse de la demande
    //Récupération des paramètres :
    //néant

//Interaction avec la bdd :
    //On veut récupérer toutes les annonces de l'utilisateur courant
        //Chargement de l'objet "utilisateur" :
        $user = new utilisateur();
        $user->loadById($_SESSION["id"]);

    //On récupère dans la bdd toutes les annonces qui ont été faites par cet utilisateur :
        //Nouvel objet "annonce" 
        $annonce = new annonce();

        //Récupération des annonces en cours de l'utilisateur :
        $annoncesEnCours = $annonce->getCurrent();

        //On récupère dans la bdd la liste des annonces finies
        $annoncesFinies = $annonce->getOver();

    
    


//Affichage 
include "template/pages/mes_annonces.php";

?>