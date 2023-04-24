<?php 
/*

Page template : affiche la liste des annonces trouvées dans la bdd (+ formulaire de recherche)

Paramètre : $listeAnnonce : liste des annonces

*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "template/fragments/head.php" ?>
    <title>Accueil</title>
</head>
<?php include "template/fragments/header.php" ?>
<body>
    <!-- Formulaire de recherche  -->
    <form action="index.php" method="post" class="recherche">
        <label>Terme recherché
            <input type="text" name="terme" >
        </label>
        <br>
        <label>Prix min 
            <input type="number" name="prix-min">
        </label>
        <br>
        <label>Prix max
            <input type="number" name="prix-max">
        </label>
        <br>
        <label>Annonce publiée avant :
            <input type="date" name="date-max">
        </label>
        <br>
        <input type="submit" value="Rechercher">
    </form>
   


    


    <!-- Liste des annonces -->
    <div class="flex  justify-between annonces">
        <div class="width-50">
            <?php 
                //Si la liste des annonces reçue est vide :
                if(empty($listeAnnonce)){
                    //On affiche un message :
                    echo "Aucune annonce trouvée";
                }//Sinon
                else{
                    //Pour chaque annonce récupérée :
                    foreach($listeAnnonce as $annonce){
                        //On affiche un apperçu :  
                        include "template/fragments/apercu_annonce.php";
                    };
                }
            
            
            ?>
        </div>

        <div class="width-50 affichage" id="zoneAffichage">
            
        </div>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/script.js"></script>
</body>
</html>