<?php 

function traiteRequete($sql, $param = []){
    //Rôle : traite une requête sql
    //Paramètres : $sql : requête
    //             $param : paramètres de la requête (tableau vide si aucun précisé)
    //Retour : true si on a réussi, false sinon

    //On lie la base de données :

    global $bdd;

    //Créé une requête :
    $req = $bdd->prepare($sql);
    

    //Exécute la requête :
    if( ! $req->execute($param)){
        //La requête a echoué
        echo "Echec de la requête $sql avec les paramètres ";
        print_r($param);
        return false;
    }
    //Cela s'est  bien passé : on retourne la requête :
    return $req;
}


function enregistreImage($image){
    //Rôle : effectue une vérif du fichier uploader et l'enregistre
    //Paramètres : $image = image reçue
    //Retour : le chemin du fichier si on a réussi, false sinon

    //Vérification s'il y a une erreur lors du transfert
    if($image["error"] > 0){
        return false;
    }
    /*
    //On relève la taille du fichier uploadé :
    $fileSize = $image["size"];

    
    //On établit une limite max : 
    $maxSize = 100000;

    //Si la taille du fichier est supèrieure à la limite : 
    if($fileSize > $maxSize){
        //On renvoie false:
        return false;
    }
    */

    //On précise les extensions accepté ( en l'occurence, extensions images)
    //On créé un tableau :
    $extValides = [".jpg", ".jpeg", ".gif", ".png"];

    //On récupère l'extension du fichier reçu :
    $fileExt = "." . strtolower(substr(strrchr($image["name"], '.'),1)); 

    //On vérifie si l'extension récupérée est conforme :
    if(!in_array($fileExt, $extValides)){
        return false;
    }


    //On peut ensuite envoyer le fichier sur serveur :
    //On récupère le nom du fichier :
    $fileName = $image["name"];

    //On récupère le nom temporaire (?) du fichier :
    $tmpName = $image["tmp_name"];

    //On fait un name unique pour éviter de se retrouver avec plusieures image au même nom :
    $uniqueName = md5(uniqid(rand(), true));

    //On précise la destination = le dossier dans lequel est stocké  le fichier + le nom du fichier :
    //Ce sera le chemin : "img/nomDuFichier.extDuFichier";
    $fileName = "img/" . $uniqueName . $fileExt;

    //On vérifie si l'upload a fonctionné :
    $resultat = move_uploaded_file($tmpName, $fileName);
    
    //Si resultat retourne true :
    if($resultat){
        //On renvoie le chemin pour le stocker dans la base de données :
        print_r($fileName);
        return $fileName;  
    }
     
}

function sendMailSeller($id){
    //Rôle : envoie un mail au propriétaire d'une annonce
    //Paramètres : $id : id de l'annonce sur laquelle on fait une offre
    //Retour : néant

    //On va récupérer le mail du propriétaire, le pseudo du propriétaire, et le titre de l'annonce à partir de l'id de l'annonce :
    //Construction de la requête sql :
    $sql = "SELECT `utilisateur`.`mail` AS 'mail', `utilisateur`.`pseudo` AS 'pseudo', `annonce`.`titre` AS 'titre'
    FROM `utilisateur`
    LEFT JOIN `annonce` ON `annonce`.`vendeur`= `utilisateur`.`id` 
    WHERE `annonce`.`id` = :id";


    //Paramètres de la requête :
    $param = [":id"=> $id];

    //Exécution de la requête :
    $req = traiteRequete($sql, $param);

    //Récupération des résultats :
    $result = $req->fetchAll(PDO::FETCH_ASSOC);
    $infos = $result[0];

    $mailVendeur = $infos["mail"];
    $pseudoVendeur = $infos["pseudo"];
    $titreAnnonce = $infos["titre"];

    //Construction et envoi du mail :
    finalisationMail($mailVendeur, $pseudoVendeur, $titreAnnonce);



}

function finalisationMail($mailVendeur, $pseudoVendeur, $titreAnnonce){
    //Rôle : envoie un mail au vendeur d'une annonce
    //Paramètres : $mailVendeur : adresse mail du vendeur
    //             $pseudoVendeur : pseudonyme du vendeur
    //             $titreAnnonce : titre de l'annonce sur laquelle on a fait une offre

    //Préparation du mail :

    //Construction des paramètres du mail :
    $sujet = "Nouvelle offre !";
    $message = "Vous avez reçu une offre sur votre annonce '$titreAnnonce'";
    $destMail = "pvandercamere@mywebecom.ovh";      //On mettra $mailVendeur ici dans un cas réel
    $destNom = $pseudoVendeur;
    //Préparation du mail :
    $messageComplet =  "Bonjour ". $pseudoVendeur ." ".  $message. " Connectez vous sur notre site pour voir les détails de cette offre";
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

    //Contenu du message :
    $messageHTML = '
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8">
    </head>
    <body>
        <p>Bonjour,</p>
        <p><b>Vous avez reçu un message</b> : </p>
        <p>' . nl2br(htmlentities($messageComplet)) . ' </p>
    </body>
    </html>
    ';
    //Destinataire : "nom visible" <adresse>, "nom visible 2" <adresse2>
    $destinataire = '"' . $destNom . '"' . "<$destMail>";
    mail($destinataire, $sujet, $messageHTML, $entetes);

}

function envoieMailsAccepte($mailOffreur, $mailAnnonce, $titreAnnonce, $pseudoOffreur){
    //Rôle : envoie un mail à l'auteur d'une offre pour lui indiquer que son offre a été acceptée 
    //Paramètres : mailAuteur : mail de l'auteur de l'offre
    //             mailAnnonce : mail de l'utilisateur qui a mis l'annonce en ligne
    //             titreAnnonce : titre de l'annonce
    //             pseudoOffreur : pseudo de l'utilisateur qui a fait l'offre
    //Retour : néant

    //Construction des paramètres du mail :
    $sujet = "Offre acceptée ! ";
    $message = " Votre offre sur " . $titreAnnonce ."a été acceptée ! ";
    $destMail = "pvandercamere@mywebecom.ovh";      //On mettra $mailOffreur ici dans un cas réel
    $destNom = $pseudoOffreur;
    //Préparation du mail :
    $messageComplet =  "Bonjour ". $pseudoOffreur ." ".  $message. " Vous pouvez désormais contacter le 
                        propriétaire de cette annonce via son adresse mail :". $mailAnnonce . ".";
    //Entêtes : 
        //Tableau d'entêtes :
        $entetes = [];
        //FROM : l'envoyeur : 
        $entetes["From"] = '"Site" <pvandercamere@mywebecom.ovh>';          //Adresse mail du serveur
        //REPLY-TO : destinataire des réponses
        $entetes["Reply-To"] = '"Auteur de l\'annonce" <site@gmail.com>';
        //Mail HTML :
        //entêtes spécifiques : 
        $entetes["MIME-version"] = "1.0";
        $entetes["Content-Type"] = "text/html; charset=utf8";

    //Contenu du message :
    $messageHTML = '
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8">
    </head>
    <body>
        <p>Bonjour,</p>
        <p><b>Vous avez reçu un message</b> : </p>
        <p>' . nl2br(htmlentities($messageComplet)) . ' </p>
    </body>
    </html>
    ';
    //Destinataire : "nom visible" <adresse>, "nom visible 2" <adresse2>
    $destinataire = '"' . $destNom . '"' . "<$destMail>";
    mail($destinataire, $sujet, $messageHTML, $entetes);


}


?>