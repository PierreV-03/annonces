<?php 

class annonce extends __model{
    //Attributs
    protected $champs = ["titre","description","image", "prix", "vendeur", "etat", "date"];
    protected $table = "annonce";


    //Méthodes :

    function recupAnnonces($terme, $prixMin, $prixMax, $dateMax){
        //Rôle : récupère dans la bdd les annonces correspondantes à la recherche effectuée
        //Paramètres : $terme : le terme recherché dans la description de l'annonce
        //             $prixMin : prix minimum visé
        //             $prixMax : prix maximum visé
        //             $dateMax : date maximale de l'annonce 
        //Retour : liste des annonces trouvées

        //Construction de la requête sql :
        //On indique les champs qu'on veut récupérer :
        $champsVoulus = $this->makeChampsRequete();

        //Ligne sql :
        $sql = "SELECT  `id`, $champsVoulus FROM `$this->table` WHERE (`titre` LIKE :terme OR `description` LIKE :terme) 
                AND `prix` > :prixMin AND `prix` < :prixMax  AND `etat`= 1 AND NOT `vendeur`= :idUser" ;

        //Construction des paramètres :
        $param = [":terme" => "%$terme%",
                  ":prixMin" => $prixMin,  
                  ":prixMax" => $prixMax,
                  ":idUser" =>  $_SESSION["id"],  
        ];

        //On traite le cas de figure où la date a été précisée 
        if(!empty($dateMax)){
            $sql.= " AND `date` < :dateMax";
            $param[":dateMax"] = $dateMax ;
        }


        //Exécution de la requête :
        $req = traiteRequete($sql, $param);

        //Récupération des résultats :
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        //On transforme la liste reçue en tableau d'objets :
        $listeAnnonces = $this->tabToTabObjet($result);

        //On renvoie le tableau récupéré :
        return $listeAnnonces;

    }

    function getCurrent(){
        //Rôle : récupère les annonces en cours de l'utilisateur courant
        //Paramètres : néant
        //Retour : liste des annonces de l'utilisateur

        //Construction de la requête sql :
        //On veut les annonces dont le champ "vendeur" correspond à l'id de la session et dont le champ "actif" est 1
        //Construction des chamsp voulus : 
        $champsVoulus = $this->makeChampsRequete();
        $sql = "SELECT `id`, $champsVoulus FROM `$this->table` WHERE `etat`= 1 AND `vendeur`= :id";

        //Construction des paramètres :
        $param = [":id"=> $_SESSION["id"]];
        
        //Exécution de la requête :
        $req = traiteRequete($sql, $param);

        //Récupératoin des résultats :
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        //On transforme la liste récupérée en tableau d'objets :
        $listeAnnonces = $this->tabToTabObjet($result);

        //On renvoie la liste reçue :
        return $listeAnnonces;

    }

    function getOver(){
        //Rôle : récupère les annonces finies de l'utilisateur courant
        //Paramètres : néant
        //Retour : liste des annonces

        //Construction de la requête sql :
        //On veut les annonces dont le champs "vendeur" correspond à l'id de la session et dont la chmaps "actif" est 2
        //Construction des champs voulus :
        $champsVoulus = $this->makeChampsRequete();
        $sql = "SELECT `id`, $champsVoulus FROM  `$this->table` WHERE `vendeur`= :id AND `etat` = 2";

        //Construction des paramètres 
        $param =  [":id" => $_SESSION["id"]];

        //Exécution de la requête :
        $req = traiteRequete($sql, $param);

        //Récupération des résultats :
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        //On transforme la liste reçue en tableau d'objets :
        $listeAnnonces = $this->tabToTabObjet($result);

        //On renvoie la liste reçue :
        return $listeAnnonces;

    }

    function getOffres(){
        //Rôle : récupère toutes les offres faites pour l'annonce parcourue
        //Paramètres : néant
        //Retour : liste des offres effectuées

        //Construction de la requête sql :
        //On veut toutes les offres qui ont l'id de cette annonce dans le champ "annonce" et qui sont encore actives ("actif" = 1)
        $sql = "SELECT `id`, `message`, `prix`, `auteur`, `annonce`, `etat` FROM `offre` WHERE `annonce` = :id AND `etat`= 1";

        //Construction des paramètres :
        $param = [":id" => $this->id];

        //Exécution de la requête :
        $req = traiteRequete($sql, $param);

        //Récupérations des résultats :
        $result= $req->fetchAll(PDO::FETCH_ASSOC);

        //Transformation des résultats en tableau d'objet :
        $offres = new offre();
        $listeOffres = $offres->tabToTabObjet($result);
        
        //On renvoie le tableau créé :
        return $listeOffres;


    }
}

?>