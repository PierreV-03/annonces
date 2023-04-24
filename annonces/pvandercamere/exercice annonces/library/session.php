<?php
/*

Page de gestion des fonctions liées à la Session

*/

function isConnected(){
    //Rôle : vérifie si quelqu'un est connecté et si le compte est actif
    //Paramètre : néant
    //Retour : true si quelqu'un est conecté, false sinon

    //Si l'id de la Session est vide(= personne n'est connecté) :
    if(empty($_SESSION["id"])){
        //On retourne false
        return false;
    }

    //On vérifie ensuite si le compte courant est activé :
        //On charge l'utilisateur :
        $user = new utilisateur();
        $user->loadById($_SESSION["id"]);

        //On regarde si le champs "actif" de l'utilisateur est à 1 (=activé) ou non : 
            //On récupère la valeur de ce champ :
            $etatCompte = $user->get("actif");

            if($etatCompte == 1 ){
                //On renvoie true :
                return true;
            }//Sinon :
            else{
                //Le compte n'est pas encore activé, on renvoie false
                return false;
            }

}

function verifConnexion($login, $password){
    //Rôle : vérifie si les identifiants utilisés pour se connecter sont bons  et établi la connexion si c'est bon
    //Paramètres : $login : pseudo utlisé 
    //             $password : mot de passe utlisé
    //Retour :  false si les identifiants sont mauvais

    //On commence par vérifier si le pseudo existe dans la bdd:
        //On effectue une requête pour aller chercher si élément comporte le pseudo
        $sql = "SELECT `id`, `password` FROM `utilisateur` WHERE `pseudo` = :pseudo";

        //COnstruction des paramètres :
        $param = [":pseudo"=> $login];

        //Exécution de la requête :
        $req = traiteRequete($sql, $param);

        //Récupération des résultats :
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        //Si le résultat est vide (= ce pseudo n'existe pas dans la bdd)
        if(empty($result)){
            //On retourne false : 
            return false;
        }


    //Ensuite on vérifie si le mot de passe utilisé correspond au compte auquel on se connecte :
        //On récupère le mot de passe du compte :
        $compte = $result[0];
        print_r($compte);
        $mdp = $compte["password"];

        //Si le mot de passe saisi correspond au mot de passe du compte :
        if(password_verify($password, $mdp)){
            //Alors les identifiants sont bons, on établit la connexion :
            $_SESSION["id"] = $compte["id"];
            echo "ok";
            
            //On renvoie true
            return true;
        }//Sinon : 
        else{
            //Le mot de passe est incorrect, on retourne false :
            echo "mauvais mdp";
            return false;
        }   
}


function deconnexion(){
    //Rôle : déconnecte l'utilisateur courant = vide la Session
    //Paramètre : néant
    //Retour : néant

    //On vide la Session :
    $_SESSION = [];
}



function connecte(){
    //Rôle : charge l'utilisateur en fonction de l'id de la session
    //Paramètre : néant
    //Retour : false si personne n'est connecté

    //Si la session est vide : 
    if(empty($_SESSION["id"])){
        //On renvoit false :
        return false;
    }//Sinon  :
    else{
        //On charge l'utilisateur connecté :
        //Nouvel objet :
        $currentUser = new utilisateur;
        $currentUser->loadById($_SESSION["id"]);
    }
}
?>