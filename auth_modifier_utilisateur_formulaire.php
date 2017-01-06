<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Service j&f: - modifier mon compte</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>

        <?php
        include('nav_menu.php');
        $query = $bdd->prepare('SELECT * FROM personnel_fbln WHERE id = ?'); // On va récupérer les données de l'utilisateur connecté.
        $query->execute(array($_SESSION['id']));
        $utilisateur = $query->fetch();
        ?>
        <div class="container">
            <header class="page-header">
                <h1>modifier mon compte</h1>
            </header>



            <section>

                <?php
                // Affichage des possibles messages d'erreur.
                if ($_GET['log'] == 'done') { // Si tout s'est bien passé.
                    ?>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="alert alert-dismissible alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <span class="glyphicon glyphicon-ok"></span> La modification a bien été effectuée ! <a href="index.php" class="alert-link">Retour à l'accueil.</a>
                            </div>
                        </div>
                    </div>
                    <?php
                } elseif ($_GET['log'] == 'mdp_wrong') { // Si les deux mots de passe ne sont pas les mêmes.
                    ?>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="alert alert-dismissible alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <span class="glyphicon glyphicon-info-sign"></span> Les deux mots de passes saisis ne correspondent pas.
                            </div>
                        </div>
                    </div>
                <?php } elseif ($_GET['log'] == 'noid') {
                    ?>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="alert alert-dismissible alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <span class="glyphicon glyphicon-remove-sign"></span> L'ancien mot de passe n'est pas correct.
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <div class="row">
                    <div class="col-md-8 col-md-offset-4">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingPseudo">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsePseudo" aria-expanded="false" aria-controls="collapseOne">
                                            <span class="glyphicon glyphicon-cog"></span> Modifier mon pseudo
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapsePseudo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        <form method="post" action="auth_modifier_utilisateur.php">
                                            <div class="form-group">
                                                <label for="modify_pseudo_only">Nouveau pseudo :</label>
                                                <input type="text" maxlength="35" id="modify_pseudo_only" name="modify_pseudo_only" class="form-control" value="<?php echo $utilisateur['pseudo']; ?>">
                                                <input type="hidden" name="id" value="<?php echo $_SESSION['id'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success pull-right"><span class="glyphicon glyphicon-check"></span> Envoyer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingMdp">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseMdp" aria-expanded="false" aria-controls="collapseTwo">
                                            <span class="glyphicon glyphicon-lock"></span> Modifier mon mot de passe
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseMdp" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                        <form method="post" action="auth_modifier_utilisateur.php">
                                            <div class="form-group">
                                                <label for="old_mdp">Mon ancien mot de passe :</label>
                                                <input type="password" name="old_mdp" id="old_mdp" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="new_mdp_1">Mon nouveau mot de passe :</label>
                                                <input type="password" name="new_mdp_1" id="new_mdp_1" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="new_mdp_2">Retaper mon nouveau mot de passe :</label>
                                                <input type="password" name="new_mdp_2" id="new_mdp_2" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" name="modify_pseudo" value="<?php echo $utilisateur['pseudo']; ?>">
                                                <input type="hidden" name="id" value="<?php echo $_SESSION['id'] ?>">
                                                <button type="submit" class="btn btn-warning pull-right"><span class="glyphicon glyphicon-check"></span> Envoyer</button>
                                            </div>
                                        </form>
                                    </div>
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