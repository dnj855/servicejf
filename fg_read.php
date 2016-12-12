<div class="panel-heading">
    <h4 class="panel-title">Lire les punchlines</h4>
</div>
<div class="list-group">
    <?php
    $punchlines = getFg($bdd);
    foreach ($punchlines as $punchline) {
        ?>
        <li class="list-group-item">
            <blockquote>
                <p>
                    <?php echo nl2br(htmlspecialchars($punchline['message'])); ?>
                    <?php if ($_SESSION['admin'] == 1) { ?><a href="ar_fg_delete.php?id=<?php echo $punchline['id']; ?>" type="button" class="close" ><span aria-hidden="true">&times;</span></a><?php } ?>
                </p>
                <footer>
                    Prononcé le <?php echo $punchline['date']; ?>. Balancé par
                    <?php
                    $auteur = getUserIdentity($bdd, $punchline['sender']);
                    echo $auteur['prenom'] . ' ' . $auteur['nom'];
                    ?>.
                </footer>
            </blockquote>
            <p class="list-group-item-text text-center">
                <a href="fg.php?action=vote&id=<?php echo $punchline['id']; ?>" class="btn btn-success btn-xs">Voter pour cette punchline</a>
            </p>
        </li>
    <?php } ?>

</div>