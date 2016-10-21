<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Bienvenue sur le portail du service j&f:</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <style>
            h1 {
                border-bottom: 1px solid #e5e5e5;
                margin-bottom: 20px;
                padding-bottom: 5px;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <header class="col-sm-12">
                <h1 class="text-center">Bienvenue sur le portail du service jeux&festivités:</h1>
            </header>
            <div class="row">
                <section class="col-sm-6 col-sm-offset-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h2 class="panel-title">Connexion obligatoire pour accéder au portail</h2>
                        </div>
                        <div class="panel-body">
                            <form method="post" action="auth_traitement.php">
                                <fieldset>
                                    <?php if ($_GET['log'] != 'new') { ?>
                                        <div class="alert alert-danger">
                                            <span class="glyphicon glyphicon-remove-sign"></span>
                                            <?php
                                            if ($_GET['log'] == 'no') {
                                                echo ' Les informations saisies ne sont pas correctes.';
                                            } elseif ($_GET['log'] == 'nopseudo') {
                                                echo ' Ce compte utilisateur n\'existe pas.';
                                            }
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="form-group">
                                        <label for="auth_pseudo" class="sr-only">Votre pseudo</label>
                                        <input type="text" name="auth_pseudo" id="auth_pseudo" placeholder="Votre pseudo" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="auth_mdp" class="sr-only">Votre mot de passe</label>
                                        <input type="password" name="auth_mdp" id="auth_mdp" placeholder="Votre mot de passe" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-check"></span> Se connecter !</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class='panel-footer'>
                            En cas d'oubli, le responsable du service j&f: se fera une joie de vous aider.
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</body>
</html>