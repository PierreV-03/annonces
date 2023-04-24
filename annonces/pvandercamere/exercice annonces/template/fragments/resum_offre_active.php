<?php 
    //On charge l'annonce liée à l'offre :
    $annonce = new annonce();
    $annonce->loadById($offre->get("annonce"));
?>
<p>Annonce : <?= htmlentities($annonce->get("titre")) ?></p>
<p>Prix Initial : <?= htmlentities($annonce->get("prix"))?>€</p>
<p>Votre prix : <?= htmlentities($offre->get("prix"))?>€</p>