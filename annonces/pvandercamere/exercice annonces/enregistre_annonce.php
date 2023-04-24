<?php 
/*

Page contrôleur : Enregistre une nouvelle annonce dans la bdd

Paramètres : $POST : caractéristiques de la nouvelle annonce

*/
//Initialisation : 
include "template/fragments/init.php";

//Vérification de la connexion :
    //On redirige l'utilisateur s'il n'est pas connecté :
    if(!isConnected()){
        include "template/pages/form_connexion.php";
        exit;
    }

//Analyse de la demande :
    //Récupération des paramètres :
    //Si un des champs n'est pas rempli
    if(empty($_POST["titre"]) || empty($_POST["description"]) || empty($_POST["prix"])){
        //On renvoie vers le formuliare avec un message d'erreur :
        $erreur = "Veuillez remplir tous les champs !";
        include "template/pages/form_annonce.php";
        exit;
    }

    $titre = $_POST["titre"];
    $description = $_POST["description"];
    $prix = $_POST["prix"];
    $image = $_FILES["image"];

    //Enregistrement du fichier image :
    //Si l'enregistrement n'a pas fonctionné :
    if( ! ( $cheminImage = enregistreImage($image))){
        //On renvoie à la page de formulaire avec un message d'erreur :
        $erreur = "Format fichier invalide";
        include "template/pages/form_annonce.php";
        exit;
    }

    


//Interaction avec la base de données :
    //On établit un nouvel objet annonce :
    $nouvelleAnnonce = new annonce();

    //On le charge avec les valeurs du formulaire :
    $nouvelleAnnonce->set("titre", $titre);
    $nouvelleAnnonce->set("description", $description);
    $nouvelleAnnonce->set("image", $cheminImage);
    $nouvelleAnnonce->set("prix", $prix);
    //Le champs vendeur est l'id de l'utilisateur courant :
    $nouvelleAnnonce->set("vendeur", $_SESSION["id"]);
    //La valeur du champ "etat" est à  1 par défaut = annonce toujours disponible
    $nouvelleAnnonce->set("etat", 1);
    //On donne la date du jour :
    $nouvelleAnnonce->set("date", date("Y-m-d H:i:s"));

    //On envoie l'objet chargé  dans la bdd :
    $nouvelleAnnonce->insert();



//Affichage :
include "template/pages/confirm_annonce.php";

?>