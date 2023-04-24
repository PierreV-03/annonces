<?php 
/*

Page contrôleur : marque l'offre sélectionnée comme étant refusée

Paramètres : $GET:  offre : id de l'offre refusée
                    id : id de l'annonce sur laquelle a été faite l'offre

*/
//Initialisation :
include "template/fragments/init.php";

//Vérification de la connexion : 
    //Si personne n'est connecté :
    if(! isConnected()){
        //On renvoie vers la page de connexion :
        include "template/pages/form_connexion.php";
        exit;
    }

//Analyse de la demande :
    //Récupération des paramètres : 
    $idOffre = $_GET["offre"];
    $idAnnonce = $_GET["id"];


//Interaction avec la bdd :
    //On charge un nouvel objet "offre" à partir de l'id offre récupérée :
    $offre = new offre();
    $offre->loadById($idOffre);

    //On change l'état de l'offre : on le met à 3 = offre refusée
    $offre->set("etat", 3);

    //On met à jour l'élément dans la base de données:
    $offre->update();

//Affichage :
include "template/pages/confirmation_offre_refuse.php";

?>