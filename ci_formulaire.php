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
        <?php include('nav_menu.php') ?>
        <div class="container">
            <header>
                <h1>le challenge invité</h1>
            </header>

            <section>
                <nav class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked">
                                <li class="active"><a href="ci.php">Saisie</a></li>
                                <li><a href="ci_resultats.php">Résultats</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="col-md-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Saisir un nouvel invité
                        </div>
                        <div class="panel-body">
                            <form method="post" class="form-horizontal">
                                <fieldset>
                                    <legend>L'interview</legend>
                                    <div class="form-group">
                                        <label for="identite" class="col-md-3 control-label">Qui es-tu :</label>
                                        <div class="col-md-9">
                                            <select name="identite" id="identite" class="form-control">
                                                <option value="">---Choisir---</option>
                                                <?php
                                                $query = $bdd->query('SELECT prenom, id FROM personnel_fbln WHERE service_id = 1 AND actif = 1 ORDER BY prenom');
                                                while ($identite = $query->fetch()) {
                                                    echo '<option value="' . $identite['id'] . '">' . $identite['prenom'] . '</option>';
                                                }
                                                $query->closeCursor();
                                                ?>
                                            </select>
                                            <p class="help-block">N'oubliez pas de faire un choix dans la liste.</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">En studio :</label>
                                        <div class="col-md-9">
                                            <label class="radio-inline"><input type="radio" name="studio" value="1">Oui</label>
                                            <label class="radio-inline"><input type="radio" name="studio" value="0">Non</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">En direct :</label>
                                        <div class="col-md-9">
                                            <label class="radio-inline"><input type="radio" name="direct" value="1">Oui</label>
                                            <label class="radio-inline"><input type="radio" name="direct" value="0">Non</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-9 col-md-offset-3">
                                            <label class="checkbox-inline"><input type="checkbox" name="pad_obligatoire">PAD obligatoire</label>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>L'invité</legend>
                                    <div class="form-group">
                                        <label for='nom' class="col-md-3 control-label">Son nom :</label>
                                        <div class="col-md-9">
                                            <input type="text" id='nom' name="nom" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="caleur" class="col-md-3 control-label">Calé par :</label>
                                        <div class="col-md-9">
                                            <select name="caleur" id="caleur" class="form-control">
                                                <option value="">---Choisir---</option>
                                                <?php
                                                $query = $bdd->query('SELECT prenom, id FROM personnel_fbln WHERE service_id = 1 AND actif = 1 ORDER BY prenom');
                                                while ($identite = $query->fetch()) {
                                                    echo '<option value="' . $identite['id'] . '">' . $identite['prenom'] . '</option>';
                                                }
                                                $query->closeCursor();
                                                ?>
                                            </select>
                                            <p class="help-block">N'oubliez pas de faire un choix dans la liste.</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-ok"></span> Envoyer</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
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