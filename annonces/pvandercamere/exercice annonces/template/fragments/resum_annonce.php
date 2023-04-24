<div>
    <p><b><?= htmlentities($annonce->get("titre")) ?></b></p>
    <p><?= htmlentities($annonce->get("description")) ?></p>
    <p>Prix : <?=htmlentities($annonce->get("prix")) ?>€</p>
    <p>Postée le : <?= htmlentities($annonce->get("date")) ?></p>
    <?php 
        //On va récupérer les offres pour l'annonce :
        $listeOffres = $annonce->getOffres();
        //Si la liste récupérée est vide :
        if(empty($listeOffres)){
            //On met un message pour l'indiquer :
            echo "Pas d'offre pour cette annonce pour le moment";
        }//Sinon :
        else{
            //On relève le nombre d'offres récupérées :
            $nbOffres = count($listeOffres);
            //Et on affiche un lien pour les consulter
            echo "<a href=\"offre_annonce.php?id=".$annonce->getId()."\">Vous avez $nbOffres offre(s) pour cette annonce</a>";
        }

    ?>

</div>