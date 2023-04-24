<?php 
/*

Page contrôleur : déconnecte l'utilisateur courant (= vide la session)

Paramètres :néant

*/
//Initilisation :
include "template/fragments/init.php";
//On déconnecte l'utilisateur :
deconnexion();

//On affiche le formulaire de connexion :
include "template/pages/form_connexion.php";
exit;
?>