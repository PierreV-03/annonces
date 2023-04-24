<?php 
/*

Page contrôleur : affiche la liste des annonces en fonction de la recherche de l'utilisateur

Paramètres : $POST : terme/prix/date recherchés par l'utilisateur

*/
//Initialisation :
include "template/fragments/init.php";



//Vérification pour voir si l'utilisateur est connecté :
if(! isConnected()){
    //Si personne n'est connecté, on envoie vers la page de connexion 
    include "template/pages/form_connexion.php";
    exit;
} 

//Analyse de la demande :
    //Récupération des paramètres :
    //Si les champs sont vide : 
    if(empty($_POST["terme"])){
        //On leur donne une valeur par défaut (différente en fonction du champ)
        $terme = "";
    }//Sinon : 
    else{
        //On récupère la valeur saisie :
        $terme = $_POST["terme"];
    }
    //Répéter pour tous les champs du formulaire : 
    if(empty($_POST["prix-min"])){
        $prixMin = "0";
    }else{
        $prixMin = $_POST["prix-min"];
    }

    if(empty($_POST["prix-max"])){
        $prixMax = "999999999";
    }else{
        $prixMax = $_POST["prix-max"];
    }

    if(empty($_POST["date-max"])){
        $dateMax = "";
    }else{
        $dateMax = $_POST["date-max"];
    }

//Interactions avec la base de donnée 
    //On va effectuer une requête sql pour aller récupérer les annonces recherchées dans la bdd
    //Nouvel objet "annonce"
    $rechercheAnnonce = new annonce();
    //On effectue la requête auprès du serveur :
    $listeAnnonce = $rechercheAnnonce->recupAnnonces($terme, $prixMin, $prixMax, $dateMax);


//Affichage :
include "template/pages/liste_annonces.php";
?>