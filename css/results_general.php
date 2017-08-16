<div class="panel panel-primary">
    <div class="panel-heading">
        <h2 class="panel-title">Classement général officiel</h2>
    </div>
    <table class="table table-responsive">

        <tr>
            <th>#</th>
            <th>Réalisateur</th>
            <th>Points</th>
            <th>Matchs réalisés</th>
        </tr>
        <?php
        $i = 1;
        $realisateurs = getCssClassementGeneral($bdd, $_SESSION['css_season']);
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
                <td><?php echo $realisateur['directed_games']; ?></td>
            </tr>
        <?php }
        ?>
    </table>
    <div class="panel-footer">
        <p>Le classement général officiel est établi en fonction du nombre de victoires du FC Metz obtenues par chaque réalisateur. Le tout est ensuite ramené au ratio du nombre de matchs réalisés par chacun.</p>
    </div>
</div>