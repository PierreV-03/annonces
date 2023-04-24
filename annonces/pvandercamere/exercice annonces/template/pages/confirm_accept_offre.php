<?php 
/*

Page template : affiche un message de confirmation de l'acceptation de l'offre sélectionnée

Paramètres : néant

*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offre Acceptée</title>
</head>
<body>
    <p>Vous avez acceptée l'offre</p>
    <p>L'auteur de cette offre peut désormais vous contacter par mail.</p>

    <a href="offre_annonce.php?id=<?=$idAnnonce?>"><button>OK</button></a>
</body>
</html>