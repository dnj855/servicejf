<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bienvenue sur le portail du service j&f:</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/auth_design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <header class="jumbotron col-sm-12">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center ">
                        <h1>service jeux&festivités:</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <p>connexion obligatoire</p>
                    </div>
                </div>
            </div>
        </header>
        <div class="container">
            <div class="row">
                <section class="col-sm-6 col-sm-offset-3">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <form method="post" action="auth_traitement.php">
                                <fieldset>
                                    <?php if ($_GET['log'] != 'new') { ?>
                                        <div class="alert alert-danger alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                                    <div class="checkbox text-right">
                                        <label for="cookie">
                                            <input type="checkbox" value="1" name="cookie" id="cookie"> Se souvenir de moi
                                        </label>
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
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>