<div class="panel panel-primary">
    <div class="panel-heading">
        <h2 class="panel-title">Classement général à la différence de buts</h2>
    </div>
    <table class="table table-responsive">

        <tr>
            <th>#</th>
            <th>Réalisateur</th>
            <th>Différence de buts</th>
            <th>Points (classement officiel)</th>
        </tr>
        <?php
        $i = 1;
        $realisateurs = getCssClassementDifferenceDeButs($bdd, $_SESSION['season']);
        $general = getCssClassementGeneral($bdd, $_SESSION['season']);
        foreach ($realisateurs as $id => $realisateur) {
            ?>
            <tr<?php
            if ($id == $_SESSION['id']) {
                echo ' class="active"';
            }
            ?>>
                <td><?php
                    if (!$last_points || $last_points != $realisateur['points']) {
                        echo $i;
                    } elseif ($last_points == $realisateur['points']) {
                        echo '-';
                    }
                    $i++;
                    ?>
                </td>
                <td><a href="css.php?action=read&realisateur=<?php echo $id; ?>"><?php echo $realisateur['prenom'] . ' ' . $realisateur['nom']; ?></a></td>
                <td><?php
                    echo $realisateur['points'];
                    $last_points = $realisateur['points'];
                    ?></td>
                <td><?php echo $general[$id]['points']; ?></td>
            </tr>
        <?php }
        ?>
    </table>
    <div class="panel-footer">
        <p>
            Ce classement alternatif se base uniquement sur la différence de buts lors des matchs.
        </p>
    </div>
</div>