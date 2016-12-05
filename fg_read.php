<div class="panel-heading">
    <h4 class="panel-title">Lire les punchlines</h4>
</div>
<div class="list-group">
    <?php
    $punchlines = getFg($bdd);
    foreach ($punchlines as $punchline) {
        ?>
        <li class="list-group-item">
            <h5 class="list-group-item-heading">
                <?php echo htmlspecialchars(nl2br($punchline['message'])); ?>
                <?php if ($_SESSION['admin'] == 1) { ?><a href="ar_fg_delete.php?id=<?php echo $punchline['id']; ?>" type="button" class="close" ><span aria-hidden="true">&times;</span></a><?php } ?>
            </h5>
            <p class="list-group-item-text">Envoyé le <?php echo $punchline['date']; ?> par
                <?php
                $auteur = getUserIdentity($bdd, $punchline['sender']);
                echo $auteur['prenom'] . ' ' . $auteur['nom'];
                ?>
            </p>
        </li>
    <?php } ?>

</div>