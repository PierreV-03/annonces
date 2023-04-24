<?php 
/*

Page contrôleur : Verifie que les identifiants de connexion sont corrects 

Paramètres : POST : identifiants de connexion utilisées

*/
//Initialisation :
include "template/fragments/init.php";

//Analyse de la demande :
    //Récupération des paramètres : 
    //Si les champs ne sont pas remplis :
    if(empty($_POST["pseudo"] or empty($_POST["password"]))){
        //On ne peut pas effectuer la connexion : on renvoie au formulaire de connexion 
        include "template/pages/form_connexion.php";
        exit;
    }//Sinon :
    else{
        //On récupère ce qui a été saisi :
        $pseudo = $_POST["pseudo"];
        $password = $_POST["password"];
    }

//Interactions avec la base de données :
    //On vérifie que les identifiants sont bons :
    //S'ils sont bons :
    if(verifConnexion($pseudo, $password)){
        //On envoie vers l'index :
        header("Location: index.php");
    }//Sinon : 
    else{
        //On renvoie vers le formulaire de connexion + message d'erreur:
        $erreur = "Mauvais identifiants ou compte non activé";
        include "template/pages/form_connexion.php";
        exit;
    }
    
?>