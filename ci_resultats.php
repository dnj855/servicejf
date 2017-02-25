<?php
include('auth.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
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

                <!--Affichage, le cas échéant, des messages d'erreur.-->
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


                <!--Affichage de la navigation par participant.-->
                <div class="row">
                    <nav class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <ul class="nav nav-pills">
                                    <li<?php
                                    if (!isset($_GET['id'])) {
                                        echo ' class="active"';
                                    }
                                    ?>><a href="ci_resultats.php">Classement général</a></li>
                                        <?php
                                        $array_id = getCiResults($bdd);
                                        foreach ($array_id as $id => $identite) {
                                            ?>
                                        <li<?php
                                        if ($_GET['id'] == $id) {
                                            echo ' class="active"';
                                        }
                                        ?>><a href="ci_resultats.php?id=<?php echo $id; ?>"><?php echo $identite['prenom_intervieweur']; ?></a></li>
                                            <?php
                                        }
                                        ?>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>


                <div class="row">

                    <!--Si l'utilisateur est autorisé, affichage de la navigation vers la saisie de résultats.-->
                    <?php if ($_SESSION['service'] == '1' && $_SESSION['actif']) { ?>
                        <nav class="col-md-3">
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

                    <?php if (!isset($_GET['id'])) { ?>
                        <!--Affichage du classement général seulement s'il n'y a pas d'id précisé dans la requête.-->
                        <div class="col-md-5 <?php
                        if ($_SESSION['service'] != '1' || !$_SESSION['actif']) {
                            echo 'col-md-offset-3';
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
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Points</th>

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
                                                    <td><a href="ci_resultats.php?id=<?php echo $id; ?>"><?php echo $identite['prenom']; ?></a></td>
                                                    <td><?php echo number_format($classement['pts']); ?></td>
                                                </tr>

                                                <?php
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="panel-footer">
                                    Cliquez sur les prénoms pour avoir les détails.
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" href="#liste_invites">
                                            Voir la liste complète des invités<span class="glyphicon glyphicon-chevron-down pull-right"></span>
                                        </a>
                                    </h4>
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
                                                echo'<li class = "list-group-item"><em>Invité par ' . $intervieweur['prenom'] . ' ' . $invite['date'] . ' :</em><br>' . $invite['nom'] . ' (' . $direct . ' ' . $studio . ')</li>';
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!--Si un id est précisé, on n'affiche que les résultats de la personne concernée.-->
                        <?php
                    } else {
                        $id = $_GET['id'];
                        $resultats = getCiResults($bdd, $id);
                        $identite = getUserIdentity($bdd, $id);
                        ?>
                        <div class="col-md-5 <?php
                        if ($_SESSION['service'] != '1') {
                            echo 'col-md-offset-3';
                        }
                        ?>">
                            <div class="panel-group" id="accordion" aria-multiselectable="true">
                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <?php echo $identite['prenom'] . ' ' . $identite['nom']; ?><span class="glyphicon glyphicon-chevron-down pull-right"></span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <strong><?php echo number_format($resultats[$id]['pts']); ?> points</strong> pour <?php echo $resultats[$id]['total']; ?> interviews réalisées.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                Directs studio : <?php echo $resultats[$id]['direct_studio']; ?><span class="glyphicon glyphicon-chevron-down pull-right"></span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="panel-body">
                                            Cela représente <?php echo Pourcentage($resultats[$id]['direct_studio'], $resultats[$id]['total']); ?> % des interviews réalisées par <?php echo $identite['prenom']; ?>.<br>
                                            Cela lui permet d'obtenir <?php echo number_format(300 * (ratio($resultats[$id]['direct_studio'], $resultats[$id]['total']))); ?> points.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                                PAD studio : <?php echo $resultats[$id]['pad_studio']; ?><span class="glyphicon glyphicon-chevron-down pull-right"></span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <div class="panel-body">
                                            Cela représente <?php echo Pourcentage($resultats[$id]['pad_studio'], $resultats[$id]['total']); ?> % des interviews réalisées par <?php echo $identite['prenom']; ?>.<br>
                                            <?php echo $resultats[$id]['ps_3pts']; ?> étai(en)t obligatoirement en PAD.<br>

                                            Cela lui permet d'obtenir <?php
                                            //Quelques calculs spéciaux pour cette catégorie uniquement.
                                            $ps_3pts = 3 * ratio($resultats[$id]['ps_3pts'], $resultats[$id]['total']);
                                            $ps_2pts = 2 * ratio($resultats[$id]['ps_2pts'], $resultats[$id]['total']);
                                            $ps = $ps_2pts + $ps_3pts;
                                            echo number_format(100 * $ps);
                                            ?> points.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingFour">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                                Directs téléphone : <?php echo $resultats[$id]['direct_telephone']; ?><span class="glyphicon glyphicon-chevron-down pull-right"></span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                        <div class="panel-body">
                                            Cela représente <?php echo Pourcentage($resultats[$id]['direct_telephone'], $resultats[$id]['total']); ?> % des interviews réalisées par <?php echo $identite['prenom']; ?>.<br>
                                            Cela lui permet d'obtenir <?php echo number_format(200 * (ratio($resultats[$id]['direct_telephone'], $resultats[$id]['total']))); ?> points.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingFive">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                                PAD téléphone : <?php echo $resultats[$id]['pad_telephone']; ?><span class="glyphicon glyphicon-chevron-down pull-right"></span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                                        <div class="panel-body">
                                            Cela représente <?php echo Pourcentage($resultats[$id]['pad_telephone'], $resultats[$id]['total']); ?> % des interviews réalisées par <?php echo $identite['prenom']; ?>.<br>
                                            Cela lui permet d'obtenir <?php echo number_format(100 * (ratio($resultats[$id]['pad_telephone'], $resultats[$id]['total']))); ?> points.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingSix">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                                                Interview(s) calée(s) : <?php echo $resultats[$id]['total_calees']; ?><span class="glyphicon glyphicon-chevron-down pull-right"></span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                                        <div class="panel-body">
                                            <?php echo $resultats[$id]['ds_calees']; ?> étai(en)t en direct et en studio.<br>
                                            Cela lui permet d'obtenir <?php echo number_format(100 * (ratio($resultats[$id]['ds_calees'], $resultats[$id]['total_calees']))); ?> points.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingSeven">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                                                Rappel du barème<span class="glyphicon glyphicon-chevron-down pull-right"></span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven">
                                        <div class="panel-body">
                                            Avant toute chose, notez bien que <strong>tous les points sont attribués au ratio du nombre d'interview réalisées</strong>.<br>
                                            Le direct studio a un coefficient de 3, tout comme le PAD studio lorsqu'il est obligatoire. Le direct téléphone et le PAD studio non obligatoire ont un coefficient de 2. Enfin, le PAD téléphone n'a pas de coefficient.<br>
                                            Les interviews calées sont comptabilisées lorsqu'elles aboutissent à un direct studio et peuvent apporter au maximum 100 points.<br><br>
                                            Le score maximum est de 400 points.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" href="#liste_invites">
                                            Tous les invités réalisés par <?php echo $identite['prenom']; ?><span class="glyphicon glyphicon-chevron-down pull-right"></span>
                                        </a>
                                    </h4>
                                </div>
                                <div id="liste_invites" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul class="list-group">
                                            <?php
                                            $query = $bdd->prepare('SELECT *, DATE_FORMAT(date_invite, \'le %d/%m/%Y\') AS date FROM challenge_invite WHERE identite = ? ORDER BY date_invite DESC');
                                            $query->execute(array($id));
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
                                                echo'<li class = "list-group-item"><strong>' . $invite['nom'] . '</strong> <small>(' . $direct . ' ' . $studio . ')</small><br>' . $invite['date'] . '</li>';
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
            </section>
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>