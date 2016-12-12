<div class="panel-heading">
    <h4 class="panel-title">Voter pour une punchline</h4>
</div>
<div class="list-group">
    <?php
    $id_punchline = $_GET['id'];
    $punchline = getFg($bdd, $id_punchline);
    ?>
    <li class="list-group-item">
        <?php
        if (!$punchline) {
            echo 'Erreur 500 : la punchline sélectionnée n\'existe pas.<br />Merci de réessayer en cliquant sur <a href="fg.php?action=read">Lire les punchlines</a>.';
        } else {
            ?>
            <p class="list-group-item-heading text-center">
                Il te reste # votes ce mois-ci. Voici la punchline pour laquelle tu souhaites voter :
            </p>
            <blockquote>
                <p>
                    <?php echo nl2br(htmlspecialchars($punchline['message'])); ?>
                </p>
            </blockquote>
            <p class="list-group-item-text">Valides-tu ton choix ?</p>
            <p class="list-group-item-text text-center">
                <a class="btn btn-success" href="fg_vote_traitement.php?id=<?php echo $punchline['id']; ?>">Oui</a>
                <a class="btn btn-danger" href="fg.php?action=read">Non</a>

            </p>
        <?php } ?>
    </li>

</div>