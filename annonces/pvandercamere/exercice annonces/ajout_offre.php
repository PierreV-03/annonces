<?php 
/*

Page contrôleur : enregistre la nouvelle offre dans la bdd

Paramètres : $POST : les caractéristiques de la nouvelle offre
             $GET : id de l'annonce

*/
//Initialisation
include "template/fragments/init.php";

//Analyse de la demande 
    //Récupération des paramètres :
    $idAnnonce = $_GET["id"];
    $message = $_POST["message"];
    $prix = $_POST["prix"];


//Interaction bdd :
    //Création d'un nouvel objet "offre"
    $newOffre = new offre();

    //On charge cet objet offre :
    $newOffre->set("message", $message);
    $newOffre->set("annonce", $idAnnonce);
    $newOffre->set("prix", $prix);

    //On donne l'id de l'utilisateur courant au champ "auteur"
    $newOffre->set("auteur", $_SESSION["id"]);

    //Valeur de base du champ état : 1 = offre non répondue
    $newOffre->set("etat", 1);

    //On envoie la nouvelle offre dans la bdd et on envoie un mail au proprétaire de l'annonce si l'enregistrement à fonctionné:
    if($newOffre->insert()){
        sendMailSeller($idAnnonce);
    }

    

//Affichage :
include "template/pages/confirm_envoi_offre.php";



?>