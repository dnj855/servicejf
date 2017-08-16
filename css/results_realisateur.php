<?php
$realisateur = getCssDirectorInfos($bdd, $_GET['realisateur'], $_SESSION['css_season']);
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $realisateur['identity']['prenom'] . ' ' . $realisateur['identity']['nom']; ?></h3>
    </div>
    <div class="panel-body">
        <div class="col-xs-12 col-md-4">
            <h4 class="text-center"><a href="css.php?action=read">Classement officiel</a> <span class="label label-<?php
                if ($realisateur['general'] == "1") {
                    echo "success";
                } elseif ($realisateur['general'] > 1 && $realisateur['general'] <= 3) {
                    echo "info";
                } else {
                    echo "danger";
                }
                ?>"><?php echo $realisateur['general']; ?></span></h4>
            <p class="text-center">Score : <?php echo $realisateur['general_points']; ?></p>
        </div>
        <div class="col-xs-12 col-md-4">
            <h4 class="text-center"><a href="css.php?action=read&classement=points">Classement par points</a> <span class="label label-<?php
                if ($realisateur['points'] == "1") {
                    echo "success";
                } elseif ($realisateur['points'] > 1 && $realisateur['points'] <= 3) {
                    echo "info";
                } else {
                    echo "danger";
                }
                ?>"><?php echo $realisateur['points']; ?></span></h4>
            <p class="text-center">Moyenne : <?php echo $realisateur['points_points']; ?> pts</p>

        </div>
        <div class="col-xs-12 col-md-4">
            <h4 class="text-center"><a href="css.php?action=read&classement=average">Diff. de buts</a> <span class="label label-<?php
                if ($realisateur['average'] == "1") {
                    echo "success";
                } elseif ($realisateur['average'] > 1 && $realisateur['average'] <= 3) {
                    echo "info";
                } else {
                    echo "danger";
                }
                ?>"><?php echo $realisateur['average']; ?></span></h4>
            <p class="text-center"><?php echo $realisateur['average_points']; ?></p>

        </div>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">En détail :</h3>
    </div>
    <table class="table table-hover table-responsive table-condensed">
        <tr>
            <th>Journée</th>
            <th>Match</th>
            <th>Résultat</th>
        </tr>
        <?php foreach ($realisateur['matchs'] as $match) { ?>
            <tr<?php
            if ($match['pts_fcmetz'] == 3) {
                echo ' class="success"';
            } elseif ($match['pts_fcmetz'] == 0) {
                echo ' class="danger"';
            } elseif ($match['pts_fcmetz'] == 1) {
                echo ' class="info"';
            }
            ?>>
                <td><?php echo $match['id_journee']; ?></td>
                <td><?php echo $match['team_home'] . ' - ' . $match['team_away']; ?></td>
                <td><?php echo $match['buts_home'] . ' - ' . $match['buts_away']; ?></td>
            </tr>
            <?php
        }
        ?>

    </table>
</div>