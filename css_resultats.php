<?php
include('auth.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Service j&f: - le challenge des soirées sport</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <?php
        include('nav_menu.php');
        ?>
        <div class="container">
            <header class="page-header">
                <h1>le challenge des soirées sport</h1>
            </header>

            <section>
                <?php if ($_GET['error'] == '0') { ?>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <span class="glyphicon glyphicon-ok-circle"></span> La soirée sport a bien été sauvegardée.
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="row">
                    <?php if ($_SESSION['css'] == '1') { ?>
                        <nav class="col-md-4">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <ul class="nav nav-pills nav-stacked">
                                        <li><a href="css.php"><span class="glyphicon glyphicon-pencil"></span> Saisie</a></li>
                                        <li class="active"><a href="css_resultats.php"><span class="glyphicon glyphicon-list-alt"></span> Résultats</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    <?php } ?>
                    <div class="col-md-8 <?php
                    if ($_SESSION['css'] != '1') {
                        echo 'col-md-offset-4';
                    }
                    ?>">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <?php
                                // On calcule d'abord le nombre total d'interviews qui ont été réalisées.
                                $nb_total_soirees = $bdd->query('SELECT COUNT(*) AS nb_total_soirees FROM soirees_foot WHERE pts_fcmetz IS NOT NULL');
                                $nb_total_soirees = $nb_total_soirees->fetch();
                                ?>
                                Les résultats après <?php echo $nb_total_soirees['nb_total_soirees']; ?> soirées sport
                            </div>
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Matches</th>
                                            <th>Ratio</th>
                                            <th>Points moyens</th>
                                            <th>Différence de buts</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Ensuite, on regarde qui a réalisé des interviews.
                                        $query = $bdd->query('SELECT DISTINCT personnel_fbln.id AS technicien_id, prenom FROM soirees_foot JOIN personnel_fbln ON personnel_fbln.id = soirees_foot.id_technicien');
                                        while ($technicien = $query->fetch()) {
                                            $id_technicien = $technicien['technicien_id']; // On stocke l'id du technicien en question dans une variable.
                                            echo '<tr><td class="ci_resultats">' . $technicien['prenom'] . '</td>';

                                            // S'ensuivent toute une série de requêtes pour établir les différentes possibilités d'interviews.
                                            $total = $bdd->prepare('SELECT COUNT(*) AS total FROM soirees_foot WHERE id_technicien = ?');
                                            $total->execute(array($id_technicien));
                                            $total = $total->fetch();
                                            $total = $total['total'];

                                            $ratio = $bdd->prepare('SELECT COUNT(*) AS ratio FROM soirees_foot WHERE pts_fcmetz = 3 AND id_technicien = ?');
                                            $ratio->execute(array($id_technicien));
                                            $ratio = $ratio->fetch();
                                            $ratio = $ratio['ratio'];
                                            $ratio = round($ratio / $total, 2);

                                            $moyenne_pts = $bdd->prepare('SELECT AVG(pts_fcmetz) AS moyenne_pts FROM soirees_foot WHERE id_technicien = ?');
                                            $moyenne_pts->execute(array($id_technicien));
                                            $moyenne_pts = $moyenne_pts->fetch();
                                            $moyenne_pts = round($moyenne_pts['moyenne_pts'], 2);

                                            $sum_buts_fcmetz = $bdd->prepare('SELECT SUM(buts_fcmetz) AS sum_buts_fcmetz FROM soirees_foot WHERE id_technicien = ?');
                                            $sum_buts_fcmetz->execute(array($id_technicien));
                                            $sum_buts_fcmetz = $sum_buts_fcmetz->fetch();
                                            $sum_buts_fcmetz = $sum_buts_fcmetz['sum_buts_fcmetz'];

                                            $sum_buts_adversaire = $bdd->prepare('SELECT SUM(buts_adversaire) AS sum_buts_adversaire FROM soirees_foot WHERE id_technicien = ?');
                                            $sum_buts_adversaire->execute(array($id_technicien));
                                            $sum_buts_adversaire = $sum_buts_adversaire->fetch();
                                            $sum_buts_adversaire = $sum_buts_adversaire['sum_buts_adversaire'];

                                            $goal_average = $sum_buts_fcmetz - $sum_buts_adversaire;

                                            // Et ensuite on affiche les données.
                                            echo '<td class="ci_resultats">' . $total . '</td>';
                                            echo '<td class="ci_resultats">' . $ratio . '</td>';
                                            echo '<td class="ci_resultats">' . $moyenne_pts . '</td>';
                                            echo '<td class="ci_resultats">' . $goal_average . '</td></tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="panel-footer">
                                Le meilleur technicien selon le reglement du challenge est celui qui a son ratio qui s'approche le plus de 1.<br />Version provisoire de l'affichage des résultats.
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>