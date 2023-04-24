<?php 
/*

Page template : affiche un message pour confirmer le refus d'une offre + un lien vers la liste des offres de l'annonce parcourue

Paramètres : néant

*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "template/fragments/head.php" ?>
    <title>Offre refusée</title>
</head>
<?php include "template/fragments/header.php" ?>
<body>

    <p>Vous avez refusé cette offre</p>

    <a href="offre_annonce.php?id=<?= $idAnnonce ?>"><button> Retour aux offres</button></a>
</body>
</html>