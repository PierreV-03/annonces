<?php 
/*

Page contrôleur : récupère toutes les offres faites par l'utlisateur

Paramètres : néant

*/
//Initialisation :
include "template/fragments/init.php";

//Interaction avec la base de données :
    //On veut récupérer toutes les offres faites par l'utilisateur courant :
    //On va les récupérer en trois requêtes différentes :
        //On initialise un objet "offre" :
        $rechercheOffre = new offre();

        //On va récupérer les offres en cours = non répondues, donc "etat" à 1
        $offreEnCours = $rechercheOffre->getOffres(1);

        //On va récupérer les offres acceptées (état à 2) :
        $offresAcceptees = $rechercheOffre->getOffres(2);

        //Enfin, on va récupérer les offres refusées (état à 3) :
        $offresRefusees = $rechercheOffre->getOffres(3);


//Affichage :
include "template/pages/liste_offres.php";

?>