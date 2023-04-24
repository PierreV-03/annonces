<?php 

class compte_check extends __model{

    //Attributs
    protected $champs = ["utilisateur", "code"];
    protected $table = "compte_check";


    //Méthodes : 

    function checkCode($code){
        //Rôle : vérifie si le code saisi par l'utilisateur est bon = s'il correspond à celui stocké dans l'objet courant
        //Paramètres : $code : code saisi
        //Retour : true si c'est bon, false sinon

        //Si le code saisi correspond à celui de l'objet :
        if($code == $this->valeurs["code"]){
            //On renvoie true :
            return true;
        }//Sinon : 
        else{
            //On renvoie false : 
            return false;
        }

    }

    function loadByUser($idUser){
        //Rôle : charge un compte de vérification en fonction de l'id de l'utilisateur 
        //Paramètres : $idUser : id de l'utilisateur dont on veut activer le compte
        //Retour : true si on a réussi, false sinon

        //Préparation de la requête sql :
        //Construction de la ligne des champs voulus :
        $champsVoulus = $this->makeChampsRequete();

        //Requête sql :
        $sql = "SELECT `id`, $champsVoulus FROM `$this->table` WHERE `utilisateur` = :idUser";

        //Préparation des paramètres :
        $param = [":idUser" => $idUser];

        //Exécution de la requête :
        $req = traiteRequete($sql, $param);

        //Récupération des résultats :
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        $resultat = $result[0];

        //Si on a récupéré quelque chose :
        if(!empty($result)){
            //On charge l'objet à partir du résultat :
            $this->loadFromArray($resultat);

            //On valorise l'id de l'objet courant :
            $this->id = $resultat["id"];

            //On retourne true :
            return true;
        }//Sinon :
        else{
            //On retourne false :
            return false;
        }


    }
}



?>