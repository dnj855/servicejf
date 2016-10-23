<?php
$journee = cssGetAlreadySetInfos($bdd, $_GET['journee_id']);
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
        include('nav_menu.php')
        ?>
        <div class="container">
            <header class="page-header">
                <h1>le challenge des soirées sport</h1>
            </header>

            <section>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <ul class="nav nav-pills">
                                    <li class="dropdown">
                                        <a href="#" data-toggle='dropdown' role="button" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">Phase aller <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <?php
                                            for ($i = 1; $i <= 19; $i++) {
                                                echo '<li><a href="css.php?journee_id=' . $i . '" class="css_select_journee">Journée n°' . $i . '</a></li>';
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" data-toggle='dropdown' role="button" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">Phase retour <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <?php
                                            for ($i = 20; $i <= 38; $i++) {
                                                echo '<li><a href="css.php?journee_id=' . $i . '" class="css_select_journee">Journée n°' . $i . '</a></li>';
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <nav class="col-md-4">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <ul class="nav nav-pills nav-stacked">
                                    <li class="active"><a href="css.php"><span class="glyphicon glyphicon-pencil"></span> Saisie</a></li>
                                    <li><a href="css_resultats.php"><span class="glyphicon glyphicon-list-alt"></span> Résultats</a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <div class="col-md-8">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <?php if (!isset($_GET['journee_id'])) { ?>Choisir la journée à remplir<?php } else { ?>Journée n°<?php echo $_GET['journee_id']; ?> : <?php echo $equipes['equipe_home']; ?> - <?php
                                    echo $equipes['equipe_away'];
                                }
                                ?>
                            </div>
                            <?php if (isset($_GET['journee_id'])) { ?>
                                <div class="panel-body">
                                    <form method="post" action="css.php" class="form-horizontal">
                                        <div class="form-group">
                                            <label for='technicien_id' class="col-md-4 control-label">Qui réalisait la soirée ?</label>
                                            <div class="col-md-8">
                                                <select name="technicien_id" id='technicien_id' class="form-control">
                                                    <option value="">---Choisir---</option>
                                                    <?php selectUserSansCadre($bdd, $journee['id_technicien'], 2); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="pts_fcmetz" class="col-md-4 control-label">Résultat du FC Metz :</label>
                                            <div class="col-md-8">
                                                <select class="form-control" id='pts_fcmetz' name="pts_fcmetz">
                                                    <option value="3"<?php
                                                    if ($journee['pts_fcmetz'] == 3) {
                                                        echo ' selected';
                                                    }
                                                    ?>>Victoire</option>
                                                    <option value="1"<?php
                                                    if ($journee['pts_fcmetz'] == 1) {
                                                        echo ' selected';
                                                    }
                                                    ?>>Nul</option>
                                                    <option value="0"<?php
                                                    if ($journee['pts_fcmetz'] <> NULL AND $journee['pts_fcmetz'] == 0) {
                                                        echo ' selected';
                                                    }
                                                    ?>>Défaite</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="buts_fcmetz" class="col-md-4 control-label">Buts inscrits par le FC Metz :</label>
                                            <div class="col-md-8">
                                                <input type="text" id='buts_fcmetz' name="buts_fcmetz" maxlength="2" class="form-control" value="<?php echo $journee['buts_fcmetz']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for='buts_adversaire' class="col-md-4 control-label">Buts inscrits par l'adversaire :</label>
                                            <div class="col-md-8">
                                                <input type="text" id='buts_adversaire' name="buts_adversaire" maxlength="2" class="form-control" value="<?php echo $journee['buts_adversaire']; ?>">
                                                <input type="hidden" name="id_journee" value="<?php echo $_GET['journee_id']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-ok"></span> Envoyer</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php } ?>
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