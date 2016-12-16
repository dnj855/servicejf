<div class='panel panel-primary'>
    <div class="panel-heading">
        <h4 class="panel-title">Lire les punchlines<?php
            $requested_month = $_GET['month'];
            echo ' (' . $mois[$requested_month] . ')';
            ?></h4>
    </div>
    <div class="list-group">
        <?php
        $punchlines = getFgMonth($bdd, $_GET['month']);
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
                        echo $auteur['prenom'] . ' ' . $auteur['nom'] . '. ';
                        $votes = getFgVotes($bdd, $punchline['id']);
                        echo "<em>" . $votes['votes'] . " voix pour cette punchline.</em>";
                        ?>
                    </footer>
                </blockquote>
                <?php
                $date = new DateTime($punchline['date_message']);
                $date_now = new DateTime();
                if ($date->format('m') == $date_now->format('m')) {
                    ?>
                    <p class="list-group-item-text text-center">
                        <a href="fg.php?action=vote&id=<?php echo $punchline['id']; ?>" class="btn btn-success btn-xs">Voter pour cette punchline</a>
                    </p>
                <?php } ?>
            </li>
        <?php } ?>

    </div>
</div>
<nav aria-label="...">
    <ul class="pager">
        <li class="previous
        <?php
        $previous_month = array_filter(getFgMonth($bdd, previousMonth($requested_month))); // On regarde s'il y a des entrées pour le mois précédent et on modifie l'affichage en fonction
        if (empty($previous_month)) {
            echo 'disabled"><a href="#">';
        } else {
            ?>
                "><a href="fg.php?action=read&month=<?php echo previousMonth($requested_month) ?>">
                    <?php } ?>
                <span aria-hidden="true">&larr;</span> <?php
                echo $mois[previousMonth($requested_month)];
                ?></a></li>
        <li class="next
            <?php
            $next_month = array_filter(getFgMonth($bdd, nextMonth($requested_month))); // On fait comme pour le mois précédent mais avec le mois suivant.
            if (empty($next_month)) {
                echo 'disabled"><a href="#">';
            } else {
                ?>"><a href="fg.php?action=read&month=<?php echo nextMonth($requested_month) ?>"><?php
                    }
                    echo $mois[nextMonth($requested_month)];
                    ?> <span aria-hidden="true">&rarr;</span></a></li>
    </ul>
</nav>