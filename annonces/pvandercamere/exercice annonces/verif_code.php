<?php 
/*

Page contrôleur : vérifie si les identifiants et code saisis sont correct, et active le compte si c'est la cas

Paramètres : POST : identifiants utilisés

*/
//Initialisation :
include "template/fragments/init.php";

//Analyse de la demande :
    //Récupération des paramètres :
    //Si un des champs est vide : on ne peut pas gérer la vérifiaction: on renvoie au formulaire :
    if(empty($_POST["pseudo"]) or empty($_POST["code"])){
        include "template/pages/form_confirmation_compte.php";
        exit;
    }//Sinon :
    else{
        //On récupère les valeurs du formulaire :
        $pseudo = $_POST["pseudo"];
        $code = $_POST["code"];
    }

//Interactions avec la base de données :
    //On charge l'utilisateur en fonction du pseudo fourni :
    $user = new utilisateur();
    $user->loadByName($pseudo);

    //On charge l'objet "compte_check" correspondant à l'id de l'utilisateur chargé :
    $verification = new compte_check();
    $verification->loadByUser($user->getId());
    

    //Enfin, on vérifie si le code passé par l'utilisateur est bon :
    //S'il est bon :
    if($verification->checkCode($code)){
        //On active le compte :
        $user->set("actif", 1);
        $user->update();
        //On redirige vers la page de connexion :
        include "template/pages/form_connexion.php";
        
    }//Sinon : echec
    else{
        //On renvoie vers la page de confirmation du compte + message erreur:
        $erreur = "Mauvais identifiant/code saisi";
        include "template/pages/form_confirmation_compte.php";
        
    }

?>