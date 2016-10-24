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
            <header class="page-header">
                <h1>le challenge invité</h1>
            </header>

            <section>
                <?php if ($_GET['error'] == '0') { ?>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                                        <li><a href="ci.php"><span class="glyphicon glyphicon-pencil"></span> Saisie</a></li>
                                        <li class="active"><a href="ci_resultats.php"><span class="glyphicon glyphicon-list-alt"></span> Résultats</a></li>
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
                                <h4 class="panel-title">Classement provisoire après <?php
                                    $query = $bdd->query('SELECT COUNT(*) AS nb_total FROM challenge_invite');
                                    $nb_total = $query->fetch();
                                    echo $nb_total['nb_total'];
                                    ?> interviews réalisées</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Points</th>
                                            <th>Nombre d'interviews</th>
                                            <th>Direct studio</th>
                                            <th>Direct téléphone</th>
                                            <th>PAD studio</th>
                                            <th>PAD téléphone</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        updateCiResults($bdd);
                                        $query = $bdd->query('SELECT id_intervieweur, pts FROM challenge_invite_points WHERE pts IS NOT NULL ORDER BY pts DESC');

                                        while ($classement = $query->fetch()) {
                                            $id = $classement['id_intervieweur'];
                                            $identite = getUserIdentity($bdd, $id);
                                            $resultats = getCiResults($bdd, $id);
                                            ?>
                                            <tr>
                                                <td><?php echo $identite['prenom']; ?></td>
                                                <td><?php echo number_format($classement['pts']); ?></td>
                                                <td><?php echo $resultats[$id]['total']; ?></td>
                                                <td><?php echo Pourcentage($resultats[$id]['direct_studio'], $resultats[$id]['total']); ?> %</td>
                                                <td><?php echo Pourcentage($resultats[$id]['direct_telephone'], $resultats[$id]['total']); ?> %</td>
                                                <td><?php echo Pourcentage($resultats[$id]['pad_studio'], $resultats[$id]['total']); ?> %</td>
                                                <td><?php echo Pourcentage($resultats[$id]['pad_telephone'], $resultats[$id]['total']); ?> %</td>
                                            </tr>

                                            <?php
                                        }
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
                <div class="row">
                    <div class="col-md-8 col-md-offset-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h5 class="panel-title">
                                    <a role="button" data-toggle="collapse" href="#liste_invites">
                                        Voir la liste complète des invités
                                    </a>
                                </h5>
                            </div>
                            <div id="liste_invites" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul class="list-group">
                                        <?php
                                        $query = $bdd->query('SELECT *, DATE_FORMAT(date_invite, \'le %d/%m/%Y\') AS date FROM challenge_invite ORDER BY date_invite DESC');
                                        while ($invite = $query->fetch()) {
                                            if ($invite['direct']) {
                                                $direct = 'direct';
                                            } else {
                                                $direct = 'pad';
                                            }
                                            if ($invite['studio']) {
                                                $studio = 'studio';
                                            } else {
                                                $studio = 'téléphone';
                                            }
                                            $intervieweur = getUserIdentity($bdd, $invite['identite']);
                                            echo'<li class = "list-group-item">Invité par ' . $intervieweur['prenom'] . ' ' . $invite['date'] . ' : ' . $invite['nom'] . ' (' . $direct . ' ' . $studio . ')</li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
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