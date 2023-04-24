<p><?= htmlentities($offre->get("message")) ?></p>
<p><?=htmlentities($offre->get("prix"))?>€</p>
<a href="accepte_offre.php?offre=<?= $offre->getId()?>&id=<?=$idAnnonce?>" title="Accepter cette offre"><button>Accepter</button></a>
<a href="refus_offre.php?offre=<?= $offre->getId()?>&id=<?= $idAnnonce ?>" title="Refuser cette offre"><button>Refuser</button></a>