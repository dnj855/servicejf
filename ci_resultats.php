<?php
include('auth.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Service j&f: - le challenge invité</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <?php include('nav_menu.php'); ?>
        <div class="container">
            <header>
                <h1>le challenge invité</h1>
            </header>

            <section>
                <?php if ($_GET['error'] == '0') { ?>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="alert alert-success">
                                <span class="glyphicon glyphicon-ok-circle"></span> Le nouvel invité a bien été sauvegardé.
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="row">
                    <?php if ($_SESSION['service'] == '1') { ?>
                        <nav class="col-md-4">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <ul class="nav nav-pills nav-stacked">
                                        <li><a href="ci.php">Saisie</a></li>
                                        <li class="active"><a href="ci_resultats.php">Résultats</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    <?php } ?>
                    <div class="col-md-8 <?php
                    if ($_SESSION['service'] != '1') {
                        echo 'col-md-offset-4';
                    }
                    ?>">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <?php
                                // On calcule d'abord le nombre total d'interviews qui ont été réalisées.
                                $nb_total_itws = $bdd->query('SELECT COUNT(*) AS nb_total_itws FROM challenge_invite');
                                $nb_total = $nb_total_itws->fetch();
                                ?>
                                Résultats après <?php echo $nb_total['nb_total_itws'] ?> interviews réalisées
                            </div>
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Nombre d'interviews</th>
                                            <th>Direct studio</th>
                                            <th>Direct téléphone</th>
                                            <th>PAD studio</th>
                                            <th>PAD téléphone</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Ensuite, on regarde qui a réalisé des interviews.
                                        $query = $bdd->query('SELECT DISTINCT personnel_fbln.id AS itw_id, prenom FROM challenge_invite JOIN personnel_fbln ON personnel_fbln.id = challenge_invite.identite');
                                        // Pour chaque intervieweur existant, on lance une boucle.
                                        while ($intervieweur = $query->fetch()) {
                                            $id_intervieweur = $intervieweur['itw_id']; // On stocke l'id de l'intervieweur en question dans une variable.
                                            echo '<tr><td>' . $intervieweur['prenom'] . '</td>';

                                            // S'ensuivent toute une série de requêtes pour établir les différentes possibilités d'interviews.
                                            $total = $bdd->prepare('SELECT COUNT(*) AS total FROM challenge_invite WHERE identite = ?');
                                            $total->execute(array($id_intervieweur));
                                            $total = $total->fetch();
                                            $total = $total['total'];

                                            $ds = $bdd->prepare('SELECT COUNT(*) AS ds FROM challenge_invite WHERE direct = 1 AND studio = 1 AND identite = ?');
                                            $ds->execute(array($id_intervieweur));
                                            $ds = $ds->fetch();
                                            $ds = $ds['ds'];
                                            $ds = Pourcentage($ds, $total);

                                            $dt = $bdd->prepare('SELECT COUNT(*) AS dt FROM challenge_invite WHERE direct = 1 AND studio = 0 AND identite = ?');
                                            $dt->execute(array($id_intervieweur));
                                            $dt = $dt->fetch();
                                            $dt = $dt['dt'];
                                            $dt = Pourcentage($dt, $total);

                                            $ps = $bdd->prepare('SELECT COUNT(*) AS ps FROM challenge_invite WHERE direct = 0 AND studio = 1 AND identite = ?');
                                            $ps->execute(array($id_intervieweur));
                                            $ps = $ps->fetch();
                                            $ps = $ps['ps'];
                                            $ps = Pourcentage($ps, $total);

                                            $pt = $bdd->prepare('SELECT COUNT(*) AS pt FROM challenge_invite WHERE direct = 0 AND studio = 0 AND identite = ?');
                                            $pt->execute(array($id_intervieweur));
                                            $pt = $pt->fetch();
                                            $pt = $pt['pt'];
                                            $pt = Pourcentage($pt, $total);

                                            // Et ensuite on affiche les données.
                                            echo '<td>' . $total . '</td>';
                                            echo '<td>' . $ds . '%</td>';
                                            echo '<td>' . $dt . '%</td>';
                                            echo '<td>' . $ps . '%</td>';
                                            echo '<td>' . $pt . '%</td></tr>';
                                        }

                                        $query->closeCursor();
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                            <div class="panel-footer">
                                Version provisoire de l'affichage des résultats.
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