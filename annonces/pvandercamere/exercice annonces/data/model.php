<?php 


/*

Page objet : gère les méthodes générales communes à tous les objets

*/



class __model{
    //Attributs :
    protected $champs =  [];
    protected $table = "";
    protected $id = 0;
    protected $valeurs = [];

    //Méthodes :

    function get($nomChamp){
        //Rôle : récupère la valeur d'un champ de l'objet
        //Paramètre : $nomChamp : nom du champ 
        //Retour : valeur du champ

        //On vérifie si le champ voulu est dans le tableau des champs de l'objet et s'il a une valeur:
        if(in_array($nomChamp, $this->champs) and isset($this->valeurs[$nomChamp])){
            return $this->valeurs[$nomChamp];
        }
        
    }

    function set($nomChamp, $newValeur){
        //Rôle : modifie la valeur du champ voulu 
        //Paramètres : $newValeur : nouvelle valeur à donner au champ sélectionné
        //             $nomChamp : nom du champ dont on veut modifier la valeur
        //Retour : true si on a réussi, false sinon

        //On vérifie si le champ est dans le tableau des chmaps de l'objet:
        if(! in_array($nomChamp, $this->champs)){
            //S'il n'y est pas, on retourne false
            return false;
        }else{
            //S'il y est :
            //On lui donne la nouvelle valeur reçue en paramètre :
            $this->valeurs[$nomChamp] = $newValeur;
            return true;
        }
    }

    function getId(){
        //Rôle : retourne l'id de l'objet
        //Paramètre : néant
        //Retour : id de l'objet s'il en a un, 0 sinon

        if(empty($this->id)){
            return 0;
        }
        else{
            return $this->id;
        }
        
    }

    function _construct($id = null) {      // Constructeur : attention il y a 2 
        // Cette méthode s'exécute automatiquement juste après la création de l'objet
        // Role : charger l'objet d'id donné (si on a un id)
        // Retour : toujours néant
        // Paramètre : 
            // $id : id à charger (optionnel)

        // Si on a un id (non null) à charger
        //      Charger l'objet courant
        if (isset($id)) {
            $this->loadById($id);
        }
    }

    function loadById($id){
        //Rôle : charge un objet à partir des valeurs de l'élément de la bdd correspondant à l'id reçue
        //Paramètres : $id : id de l'élément cherché dans la bdd
        //Retour : true si on a réussi, false sinon

        //Préparation de la requête sql :
        //On prépare les champs qu'on veut récupérer :
        $champsVoulu = $this->makeChampsRequete();

        //Ligne sql :
        //On veut aller récupérer la valeur de tous les champs de l'élément dans la table de l'objet
        $sql = "SELECT $champsVoulu FROM `$this->table` WHERE `id`= :id";

        //Construction des param :
        $param = [":id"=>$id];
        
        //Exécution de la requête : 
        $req = traiteRequete($sql, $param);

        //Récupération du résultat de la requête :
        $resultats = $req->fetchAll(PDO::FETCH_ASSOC);

        //On récupère l'élément voulu dans le résultat :
        $element = $resultats[0];

        //Si le résultat récupéré n'est pas vide :
        if(! empty($resultats)){
            //On valorise les attributs de l'objet avec les valeurs de l'élément
            $this->loadFromArray($element);

            //On valorise l'id de l'objet :
            $this->id = $id;

            //Et on renvoie true :
            return true;

        }//Sinon :
        else{
            //On renvoie faux :
            return false;
        }
    }

    function getAll(){
        //Rôle : récupère tous les éléments d'une table de données
        //Paramètre : néant
        //Retour : tableau d'objet contenant tous les éléments de la table

        //On construit la requête sql :
        //On prépare la ligne avec les champs voulus :
        $champsVoulu = $this->makeChampsRequete();

        //Ligne sql :
        //On veut tous les champs de tous les éléments de la table de l'objet courant 
        $sql = "SELECT `id`, $champsVoulu FROM `$this->table` WHERE 1";

        //Traitement de la requête :
        $req = traiteRequete($sql) ;

        //Récupération des résultats de la requête :
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        //Si le résultat de la requête n'est pas vide :
        if(! empty($result)){
            //On créé un tableau d'objet à partir de tous les éléments récupérés par la requête
            $tableau = $this->tabToTabObjet($result);
            //On renvoie le tableau d'objets :
            return $tableau;
        }//Sinon :
        else{
            //On retourne false:
            return false;
        }

    }

    function update(){
        //Rôle : met à jour un élement de la bdd à partir des valeurs des attributs d'un objet
        //Paramètre : néant
        //Retour : true si on a réussi, false sinon

        //Construction de la requête sql :
        //On construit la ligne contenant les champs et leur nouvelle valeur à enregistrer dans la bdd:
        $champsUpdate = $this->makeChampsUpdate();

        //Ligne sql : 
        $sql = "UPDATE `$this->table` SET $champsUpdate WHERE `id` = :id";

        //Construction des paramètres :
        $param = $this->makeParamUpdate();
        //On ajoute l'id aux paramètres :
        $param[":id"] = $this->id;

        //On traite la requête sql :
        $req = traiteRequete($sql, $param);

        //Si la requête retourne false :
        if($req == false){
            //On a echoué : on retourne false
            $this->id = 0;
            return false;
        }//Sinon on retourne true :
        else{
            return true;
        }

    }

    function insert(){
        //Rôle : créé un nouvel objet dans la base de données à partir des valeurs de l'objet courant
        //Paramètres : néant
        //Retour : true si on a réussi, false sinon

        //On construit la requête sql :
        //On récupère les champs nécessaires et leur valeur :

        
        $champsInsert = $this->makeChampsUpdate();

        //Ligne sql : 
        $sql = "INSERT INTO `$this->table` SET $champsInsert";

        //Construction du tableau des paramètres :
        $param = $this->makeParamUpdate();
        

        //Exécution de la requête sql :
        $req = traiteRequete($sql, $param);

        //Si la requête retourne false : 
        if($req == false){
            //On a echoué : on retourne false :
            $this->id = 0;
            return false;
        }//Sinon (= on a réussi):
        else{
            //On donne à l'objet l'id de l'élément qu'on vient de créer
            global $bdd;
            $this->id = $bdd->lastInsertId();
            //On renvoie true :
            return true;
        }
    }

    function delete(){
        //Rôle : supprime un élément dans la bdd en fonction de l'id de l'objet courant
        //Paramètres : néant
        //Retour : true si on a réussi, false sinon

        //Construction de la requête sql :
        //Ligne sql :
        $sql ="DELETE FROM `conseils` WHERE `id` = :id";

        //Construction des paramètres :
        $param = ["id"=>$this->id];

        //Exécution de la requête :
        $req = traiteRequete($sql, $param);

        //Si la requête a echoué : 
        if($req == false){
            //On retourne false :
            return false;
        }//Sinon : 
        else{
            //On retourne true 
            return true;
        }
    }

    function makeChampsRequete(){
        //Rôle : construit une chaine de charactères contenant tous les champs de l'objet
        //Paramètre : néant
        //Retour : chaîne de caractère construite :

        //On construit un tableau vide :
        $tab = [];
        

        //Pour chaque champ présent dans le tableau des champs de l'objet :
        foreach($this->champs as $nomChamp){
            //On ajoute le nom du champ au tableau :   
            $tab[] = "`$nomChamp`";   
        }
        

        //On met en forme la ligne de caractères :
        $ligne = implode(",", $tab);
        

        //On renvoie cette ligne de caractères :
        return $ligne;
    }

    function loadFromArray($tab){
        //Rôle : valorise les attributs de l'objet 
        //Paramètres : $tab :tableau à partir duquel on valorise les attributs de l'objet
        //Retour : néant

        //Pour chaque champ de l'objet
        foreach($this->champs as $nomChamp){
            //Si le nom du champ existe :
            if(isset($nomChamp)){
                //On donne au champ la valeur correspondante dans le tableau
                $this->set($nomChamp, $tab[$nomChamp]);
            }
            
        }
    }

    function tabToTabObjet($tab){
        //Rôle : transforme un tableau en tableau d'objets
        //Paramètres : $tab : tableau à transformer
        //Retour : tableau d'objets

        //On créé un tableau vide :
        $tabObjet = [];

        //On récupère le nom de la table de l'objet courant
        $table = $this->table;
    
        //Pour chaque élément du tableau récupéré : 
        foreach($tab as $element){
            //On créé un nouvel objet dans la table récupérée :
            $objet = new $table;
            //On valorise les attributs de l'objet créé avec l'élément parcouru
            $objet->loadFromArray($element);
            //On donne également l'id de l'élément à l'objet :
            $objet->id = $element["id"];

            //Enfin on ajoute l'objet rempli au tableau :
            $tabObjet[$objet->id] = $objet;
        }

        //On retourne le tableau d'objets créé :
        
        return $tabObjet;
    }

    function makeChampsUpdate(){
        //Rôle : fait une ligne de caracères comprenant les noms des champs de l'objet 
        //Paramètre : néant
        //Retour : la ligne de caractères construite

        //On créé un tableau vide :
        $tab = [];

        //Pour chaque champ de l'objet courant :
        foreach($this->champs as $nomChamp){
            //On l'ajoute au tableau  :
            $tab[] = "`$nomChamp`= :$nomChamp"; 
        }

        //On transforme le tableau en chaîne de caractères :
        $ligne = implode(",", $tab);

        //On renvoie cette ligne :
        return $ligne;
    }

    function makeParamUpdate(){
        //Rôle : construction du tableau des paramètres pour une requête de mise à jour
        //Paramètres : néant
        //Retour : le tableau des paramètres créé

        //On créé un tableau vide :
        $tabParam = [];
        
        //Pour chaque champ de l'objet courant : 
        foreach($this->champs as $nomChamp){
            //Si le champ à une valeur :
            if(isset($this->valeurs[$nomChamp])){
                //On l'ajoute au tableau des paramètre avec sa valeur :
                $tabParam[":$nomChamp"] = $this->valeurs[$nomChamp];
                
            }//Sinon, si le champ n'a pas de valeur
            else{
                //On le met dans le tableau avec une valeur null
                $tabParam[":$nomChamp"] = null;
            }
        }
        
        
        //Enfin, on retourne le tableau : 
        return $tabParam;
    }
}
?>