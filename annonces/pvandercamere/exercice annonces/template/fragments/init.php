<?php 

ini_set("display_errors", 1);
error_reporting(E_ALL);

session_start();

global $bdd ;
$bdd = new PDO("mysql:host=localhost;dbname=projets_annonces_pvandercamere;charset=UTF8", "pvandercamere","B4Mgr5r?Q");

include_once "data/model.php";
include_once "data/annonce.php";
include_once "data/compte_check.php";
include_once "data/offre.php";
include_once "data/utilisateur.php";

include_once "library/fonctions.php";
include_once "library/session.php";


?>