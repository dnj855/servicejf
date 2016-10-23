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
                    <div class="col-md-8 col-md-offset-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Journée n°<?php echo $_GET['journee_id']; ?> : <?php echo $equipe_home; ?> - <?php echo $equipe_away; ?>
                            </div>
                            <div class="panel-body">
                                <form method="post" action="css.php?journee_id=<?php echo $_GET['journee_id']; ?>" class="form-horizontal">
                                    <div class="form-group">
                                        <label for='technicien_id' class="col-md-4 control-label">Qui réalisait la soirée ?</label>
                                        <div class="col-md-8">
                                            <select name="technicien_id" id='technicien_id' class="form-control">
                                                <?php
                                                if ($journee['id_technicien'] <> NULL) { // Si la journée a déjà été saisie.
                                                    $identite = getUserIdentity($bdd, $journee['id_technicien']);
                                                    echo '<option value="' . $identite['id'] . '">' . $identite['prenom'] . '</option>';
                                                    $query = $bdd->prepare('SELECT prenom, id FROM personnel_fbln WHERE service_id = 2 AND actif = 1 AND cadre = 0 AND id != ? ORDER BY prenom'); // Puis les autres.
                                                    $query->execute(array($journee['id_technicien']));
                                                    while ($identite = $query->fetch()) {
                                                        echo '<option value="' . $identite['id'] . '">' . $identite['prenom'] . '</option>';
                                                    }
                                                } else { // Si la journée n'a pas encore été saisie.
                                                    echo '<option value="">---Choisir---</option>';
                                                    $query = $bdd->query('SELECT prenom, id FROM personnel_fbln WHERE service_id = 2 AND actif = 1 AND cadre = 0 ORDER BY prenom');
                                                    while ($identite = $query->fetch()) {
                                                        echo '<option value="' . $identite['id'] . '">' . $identite['prenom'] . '</option>';
                                                    }
                                                    $query->closeCursor();
                                                }
                                                ?>
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
                                            <input type="hidden" name="id_journee" value="<?php echo $_GET['id_journee']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-ok"></span> Envoyer</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </body>
</html>