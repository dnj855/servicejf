<div class='panel panel-primary'>
    <div class="panel-heading">
        <h4 class="panel-title">Lire les punchlines<?php
            $requested_month = $_GET['month'];
            $requested_year = $_GET['year'];
            $previous_month = previousMonth($requested_month);
            $next_month = nextMonth($requested_month);
            $next_year = getFgNextYear($requested_month, $requested_year);
            $previous_year = getFgPreviousYear($requested_month, $requested_year);
            echo ' (' . $mois[$requested_month] . ' ' . $requested_year . ')';
            ?></h4>
    </div>
    <div class="list-group">
        <?php
        $punchlines = getFgMonth($bdd, $requested_month, $requested_year);
        if (!$punchlines) {
            ?>
            <div class="panel-body">
                <p class="lead text-center">Il n'y a pas encore de punchline postée ce mois-ci.</p>
                <p class="text-center"><a href="fg.php?action=write">Pourquoi ne pas ouvrir le bal ?</a></p>
            </div>
            <?php
        } else {
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
                    if ($date->format('m') == $date_now->format('m') && $_SESSION['actif']) {
                        ?>
                        <p class="list-group-item-text text-center">
                            <a href="fg.php?action=vote&id=<?php echo $punchline['id']; ?>" class="btn btn-success btn-xs">Voter pour cette punchline</a>
                        </p>
                    <?php } ?>
                </li>
                <?php
            }
        }
        ?>

    </div>
</div>
<nav aria-label="...">
    <ul class="pager">
        <li class="previous">
            <a href="fg.php?action=read&month=<?php echo $previous_month; ?>&year=<?php echo $previous_year; ?>">
                <span aria-hidden="true">&larr;</span> <?php
                echo $mois[$previous_month] . ' ' . $previous_year;
                ?></a></li>
        <li class="next">
            <a href="fg.php?action=read&month=<?php echo $next_month ?>&year=<?php echo $next_year; ?>"><?php
                echo $mois[$next_month] . ' ' . $next_year;
                ?> <span aria-hidden="true">&rarr;</span></a></li>
    </ul>
</nav>