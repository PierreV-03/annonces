<?php 

class utilisateur extends __model{
    //Attributs 
    protected $champs = ["pseudo", "password", "mail", "actif"];
    protected $table = "utilisateur";



    //Méthodes 

    function checkPseudo($pseudo){
        //Rôle : vérifie que le pseudo utilisé pour l'inscription est unique
        //Paramètres : $pseudo : pseudo utilisé
        //Retour : false ou true 

        //On effectue une requête auprès du serveur 
        $sql = "SELECT `id`, `pseudo` FROM `utilisateur` WHERE `pseudo`= :pseudo";

        //Construction des paramètres :
        $param = [":pseudo" => $pseudo];

        //Exécution de la requête :
        $req = traiteRequete($sql, $param);

        //Récupération des résultats de la requête :
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        //Si le résultat retourné n'est pas vide = le pseudo existe déja
        if(!empty($result)){
            //ON retourne false :
            return false;
        }//Sinon : 
        else{
            //On retourne true :
            return true;
        }

        
    }  

    function checkMail($mail){
        //Rôle : vérifie que le mail utilisé pour l'inscription est unique
        //Paramètres : $mail : mail utilisé
        //Retour : false ou true 

        //On effectue une requête auprès du serveur 
        $sql = "SELECT `id`, `mail` FROM `utilisateur` WHERE `mail`= :mail";

        //Construction des paramètres :
        $param = [":mail" => $mail];

        //Exécution de la requête :
        $req = traiteRequete($sql, $param);

        //Récupération des résultats de la requête :
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        //Si le résultat retourné n'est pas vide = le mail existe déja
        if(!empty($result)){
            //ON retourne false :
            return false;
        }//Sinon : 
        else{
            //On retourne true :
            return true;
        }
    }

    function envoieMail($code){
        //Rôle : envoie un mail pour confirmer l'inscription
        //Paramètre : $code : le code d'activation du compte
        //Retour : néant

        //Construction des paramètres du mail :
        $sujet = "Finalisation inscription";
        $message = "Dernières étapes afin de finir votre inscription.";
        $destMail = "pvandercamere@mywebecom.ovh";
        $destNom = $this->get("pseudo");

        //Préparation du mail :
        $messageComplet =  "Bonjour ". $this->get("pseudo"). ". Vous vous êtes inscrit sur notre site. $message
                            Veuillez suivre le lien et saisir le code suivant afin d'activer votre compte.
                            Code : $code";

        //Entêtes : 
        //Tableau d'entêtes :
        $entetes = [];

        //FROM : l'envoyeur : 
        $entetes["From"] = '"Site" <pvandercamere@mywebecom.ovh>';          //Adresse mail du serveur

        //REPLY-TO : destinataire des réponses
        $entetes["Reply-To"] = '"Site" <site@gmail.com>';

        //Mail HTML :
        //entêtes spécifiques : 
        $entetes["MIME-version"] = "1.0";
        $entetes["Content-Type"] = "text/html; charset=utf8";

        $messageHTML = '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf8">
        </head>
        <body>
            <p>Bonjour,</p>n
            <p><b>Vous avez reçu un message</b> : </p>
            <p>' . nl2br(htmlentities($messageComplet)) . ' </p>
            <a href="http://annonces.pvandercamere.mywebecom.ovh/exercice%20annonces/confirmation_compte.php">Activez votre compte</a>
        </body>
        </html>
        ';

        //Destinataire : "nom visible" <adresse>, "nom visible 2" <adresse2>
        $destinataire = '"' . $destNom . '"' . "<$destMail>";

        mail($destinataire, $sujet, $messageHTML, $entetes);

    }

    function loadByName($pseudo){
        //Rôle : charge un objet en fonction du pseudo passé
        //Paramètres : $pseudo : pseudo récupéré
        //Retour : true si on a réussi, false sinon

        //Préparation de la requête sql :
        //Récupération de tous les champs voulus :
        $champsVoulus = $this->makeChampsRequete();
        $sql = "SELECT `id`, $champsVoulus  FROM `utilisateur` WHERE `pseudo` = :pseudo";

        //Construction des paramètres :
        $param = [":pseudo" => $pseudo];

        //Exécution de la requête :
        $req = traiteRequete($sql, $param);

        //Récupération du résultat : 
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        $user = $result[0];

        //Si on a bien récupéré quelque chose :
        if(!empty($user)){
            //On charge l'objet :
            $this->loadFromArray($user);

            //On valorise l'id :
            $this->id = $user["id"];

            //On renvoie true :
            return true;
        }//Sinon :
        else{
            //On renvoie false : 
            return false;
        }



    }
}

?>