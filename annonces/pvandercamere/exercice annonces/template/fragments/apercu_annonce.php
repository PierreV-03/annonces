<div onclick="afficheAnnonce(<?= $annonce->getId() ?>)" class="annonce">
    <p class= "title"><b><?= $annonce->get("titre") ?></b></p>
    <p><?= $annonce->get("description") ?></p>
</div>