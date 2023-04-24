<?php 
/*

Page contrôleur : traite l'inscription d'un utilisateur

Paramètres : POST : les valeurs passées par le formulaire d'inscription

*/
//Initialisation :
include "template/fragments/init.php";

//Analyse de la demande :
    //Récupération des paramètres : 
    $pseudo = $_POST["pseudo"];
    $mail = $_POST["mail"];
    $password = $_POST["password"];
   


//Interactions base de données :
    //Nouvel objet utilisateur :
    $newUser = new utilisateur;

    //On charge le nouvel utilisateur avec le POST :
    $newUser->set("pseudo", $pseudo);
    $newUser->set("mail", $mail);
    $newUser->set("actif", 0);

    //Cryptage du mot de passe :
    $cryptedPassword = password_hash($password, PASSWORD_BCRYPT);
    $newUser->set("password", $cryptedPassword);

    //Vérification de l'unicité du pseudo et du mail:
        
        //Si le mail n'est pas unique : 
        if(! $newUser->checkMail($mail)){
             //On affiche un message d'erreur :
             $erreurMail = "Mail déja utilisé";
             //On redirige vers l'inscription :
             include "template/pages/form_inscription.php";
             exit;
        }
        //Si le pseudo n'est pas unique :
        if(! $newUser->checkPseudo($pseudo)){
            //On affiche un message d'erreur :
            $erreurPseudo = "Pseudo déja utilisé";
            //On redirige vers l'inscription :
            include "template/pages/form_inscription.php";
            exit;
        }


    //Envoie du nouveau compte dans la bdd :
    //Si l'envoi a marché :
    if($newUser->insert()){
        //On génère un code pour l'activation du compte :
        $code = rand(100000, 999999);
        //On établi un objet "compte_check" pour gérer l'activation du compte :
        $verif = new compte_check();
        //On donne à cette objet le code généré et l'id du compte qui vient d'être créé :
        $verif->set("utilisateur", $newUser->getId());
        $verif->set("code", $code);
        //Enfin on envoie ce nouvel élément dans la bdd :
        $verif->insert();

        //On envoie un mail : 
        $newUser->envoieMail($code);
        //On affiche le suite :
        include "template/pages/confirm_inscription.php";
    }//Sinon :
    else{
        //On renvoit à la page d'inscription
        include "template/pages/form_inscription.php";
        exit;
    }


    //

        

       
?>