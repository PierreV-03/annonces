<?php 

class offre extends __model{

    //Attributs
    protected $champs = ["message", "annonce", "auteur", "prix", "etat"];
    protected $table = "offre";



    function getElementsMailAccept(){
        //Rôle : récupère tous les éléments nécessaires à la construction d'un mail d'acceptation d'une offre 
        //Paramètres : néant
        //Retour : liste des éléments récupérés

        //Construction de la requête sql :
        //On veut : le titre de l'annonce qur laquelle l'offre a été faite
        //          le mail de l'auteur de l'offre
        //          le mail de l'auteur de l'annonce 
        //          le pseudo de l'auteur de l'offre
        $sql = "SELECT `offreur`.`mail` AS `mailOffreur`, `vendeur`.`mail` AS `mailVendeur`, `annonce`.`titre` AS `titreAnnonce`, 
                `offreur`.`pseudo` AS `pseudoOffreur` 
                FROM `offre`
                LEFT JOIN `annonce` ON `annonce`.`id` = `offre`.`annonce`
                LEFT JOIN `utilisateur` AS `offreur` ON `offreur`.`id` = `offre`.`auteur`
                LEFT JOIN `utilisateur` AS `vendeur` ON `vendeur`.`id` = `annonce`.`vendeur`
                WHERE `offre`.`id` = :id";

        //Construction des paramètres :
        $param = [":id"=> $this->id];

        //Exécution de la requête :
        $req = traiteRequete($sql, $param);

        //Récupération des résultats :
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        $resultat = $result[0];

        //On renvoie le résultat reçu :
        return $resultat;


    }

    function refuseAllOther($id){
        //Rôle : refuse toutes les autres offres qui ont été faite sur une annonce
        //Paramètres : $id : id de l'annonce 
        //Retour : néant

        //On effectue une requête sql pour aller chercher toutes les offres faite sur l'annonce et  qui n'ont pas la même id que l'offre courante :
        //On indique les champs qu'on veut récupérer :
        $champsVoulus = $this->makeChampsRequete() ;
        $sql = "SELECT `id`, $champsVoulus FROM `$this->table` WHERE `annonce`= :idAnnonce AND NOT `id`= :idOffre";

        //Construction des paramètres  :
        $param = [":idAnnonce"=>$id,
                  ":idOffre"=> $this->id,
        ];

        //Exécution de la requête :
        $req = traiteRequete($sql, $param);

        //Récupération des résultats :
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        //Si le résultat n'est pas vide :
        if(!empty($result)){
             //On transforme la liste de résulats reçues en tableau d'objet :
            $listeOffresRefusees = $this->tabToTabObjet($result);
            print_r($listeOffresRefusees);

            //Pour chaque offre de la liste :
            foreach($listeOffresRefusees as $offre){
                //On met la valeur du champ "etat" à 3 = offre refusée
                $offre->set("etat", 3);

                //On met enfin à jour dans la base de données: 
                $offre->update();

            }
        }

              
    }

    function getOffres($etat){
        //Rôle : récupère toutes les offres qui sont dans un certain état (en cours, acceptée, refusée)
        //Paramètres : $etat : nombre indicateur de l'état dans lesquelles sont les offres qu'on veut récupérer
        //Retour : liste des offres 

        //Construction de la requête sql :
        //On construit la ligne des champs qu'on veut récupérer :
        $champsVoulus = $this->makeChampsRequete();

        //On récupère tous les éléments dont le champs "etat" correspond au nombre passé en paramètre et où le champs "auteur" correspond à l'id de la Session:
        $sql = "SELECT `id`, $champsVoulus FROM `$this->table` WHERE `etat`= :etat AND `auteur`= :idSession";

        //Construction des paramètres :
        $param = [":etat" => $etat,
                  ":idSession"=> $_SESSION["id"],
                ];

        //Exécution de la requête sql :
        $req = traiteRequete($sql, $param);
        
        //Récupération des résultats :
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        //Transformation de la liste reçue en tableau d'objet :
        $listeOffres = $this->tabToTabObjet($result);

        //On renvoie le tableau des offres récupérées :
        return $listeOffres;
    
    }


}


?>