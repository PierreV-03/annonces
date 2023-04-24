<div data-id="<?= $annonce->getId() ?>" class="resume">
    <div class="image">
        <img src="<?= $annonce->get("image") ?>" alt="Image de <?= $annonce->get("titre") ?>" class="width-100">
    </div>
    <p><b><?= $annonce->get("titre") ?></b></p>
    <p><?= $annonce->get("description") ?></p>
    <p>Prix proposé : <?= $annonce->get("prix") ?>€</p>
    <a href="creer_offre.php?id=<?= $annonce->getId() ?>" title="Proposer un prix pour cette annonce" class="btn">Faire une offre</a>
</div>