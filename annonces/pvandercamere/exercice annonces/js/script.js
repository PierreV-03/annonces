


function afficheAnnonce(id){
    //Rôle : affiche le résumé complet d'une annonce
    //Paramètres : id : id de l'annonce à afficher
    //Retour : néant

    //Fonction AJAX :
    //On va demander des infos et les afficher par une fonction d'affichage

    //Construction de l'url :
    //On passe en paramètre GET l'id de l'annonce à afficher
    let url = "affiche_details_ajax.php?id=" + id;

    //On envoi la requête :
    $.ajax(url, {
        method: "GET",
        success: affichageAnnonce,
        error: function(){console.log("Erreur de communication")},
    });

}

function affichageAnnonce(data){
    //Rôle : traite les données envoyées par la requête HTTP
    //Paramètre : data : données reçues du serveur
    //Retour : néant

    $("#zoneAffichage").show().html(data);
}

function refresh(){
    //Rôle : recharge la page tous les 10 secondes
    //Paramètres : néant
    //Retour : néant

    //On établit un intervalle qui lance la fonction qui va reload la page :
    setInterval(recharge, 10000);
}


function recharge(){
    //Rôle : recharge la page
    //Paramètres : néant
    //Retour : néant

    //On relance la page : 
    location.reload();
}

