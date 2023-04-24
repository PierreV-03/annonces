<?php 
/*

Page contrôleur : marque l'offre sélectionnée commme "accepte" et envoie un mail à l'acheteur.
                  marque également l'annonce comme étant "finie" et refuse toutes les autres offres proposées pour celle-ci

Paramètres : $GET : id de l'offre

*/
//Initialisation :
include "template/fragments/init.php";

//Vérification connexion :
    if(!isConnected()){
        include "template/pages/form_connexion.php";
        exit;
    }

//Analyse de la demande :
    //Récupération des paramètres :
    $idOffre = $_GET["offre"];
    $idAnnonce = $_GET["id"];


//On récupère l'offre qu'on a accepté :
$offreAccepte = new offre();
//On la charge à partir de l'id récupérée :
$offreAccepte->loadById($idOffre);


//On envoie un mail au propriétaire de l'offre : 
    //On va récupérer tous les élément nécessaires à l'envoie du mail :
    $paramMail = $offreAccepte->getElementsMailAccept();

    //Mail de l'auteur de l'offre:
    $mailOffreur = $paramMail["mailOffreur"];

    //Mail de l'auteur de l'annonce :
    $mailAuteur = $paramMail["mailVendeur"];

    //Titre de l'annonce sur laquelle a été faite l'offre :
    $titreAnnonce = $paramMail["titreAnnonce"];

    //Pseudo de l'utilisateur qui a fait l'offre :
    $pseudoOffreur = $paramMail["pseudoOffreur"];

    //On envoie un mail   
    envoieMailsAccepte($mailOffreur, $mailAuteur, $titreAnnonce, $pseudoOffreur);
    


//Interaction bdd :
    
    //On change l'état de l'offre : on la met à 2 (acceptée)
    $offreAccepte->set("etat", 2);  
    //On met à jour l'offre dans la bdd :
    $offreAccepte->update();

    //On change l'état de toutes les autres offres faites sur cette annonce : 3 = refusée
    $offreAccepte->refuseAllOther($idAnnonce);


    //On marque l'annonce concernée comme étant finie (=> etat = 2 )
    //On charge l'objet un objet annonce à partir de l'id récupérée en paramètre :
    $annonce = new annonce();
    $annonce->loadById($idAnnonce);

    //On met la valeur du champ "etat" à 2 :
    $annonce->set("etat", 2);
    //On met à jour dans la base de données :
    $annonce->update();

    
//Affichage : 
include "template/pages/confirm_accept_offre.php";
   
?>