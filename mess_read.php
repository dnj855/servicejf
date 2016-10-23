<?php
include ('auth_mess.php'); //Page d'authentification spéciale avec la méthode pour les messages.
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Service j&f: - la messagerie interne</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <?php include('nav_menu.php') ?>

        <div class="container">
            <header class="page-header">
                <h1>la messagerie interne</h1>
            </header>
            <section>
                <div class="row">
                    <nav class="col-md-4">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a href="mess_formulaire.php"><span class="glyphicon glyphicon-pencil"></span> Ecrire un message</a></li>
                                    <li<?php if (!$mess_nonlus) { ?> class="disabled"<?php } ?>><a href="mess_nonlus.php"><span class="glyphicon glyphicon-envelope"></span> Messages non lus</a></li>
                                    <li class="active"><a href="mess_lus.php"><span class="glyphicon glyphicon-inbox"></span> Lire les messages</a></li>
                                    <li><a href="index.php"><span class="glyphicon glyphicon-chevron-left"></span> Retour à l'accueil</a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <?php echo $mess_titre; ?>
                                        <button class="btn btn-success btn-xs pull-right" type="button" data-toggle="collapse" data-target="#repondre" aria-expanded="false" aria-controls="repondre">
                                            <span class="glyphicon glyphicon-send"></span> Répondre
                                        </button>
                                    </div>
                                    <div class="panel-body">
                                        <p><?php echo $mess_texte; ?></p>
                                    </div>
                                    <div class="panel-footer">
                                        <em>Envoyé le <?php echo $mess_date; ?> par <?php echo $auteur_prenom; ?> <?php echo $auteur_nom; ?></em>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 collapse" id="repondre">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        Répondre à <?php echo $auteur_prenom; ?> :
                                    </div>
                                    <div class="panel-body">
                                        <form method="post" action="mess_traitement.php">
                                            <div class="form-group">
                                                <label for="message">Ton message :</label>
                                                <textarea id="message" name="message" class="form-control" rows="5"></textarea>
                                                <input type="hidden" name="expediteur" value="<?php echo $expediteur_id ?>">
                                                <input type="hidden" name="destinataire" value="<?php echo $auteur_id ?>">
                                                <input type="hidden" name="titre" value="RE : <?php echo $mess_titre ?>">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success pull-right"><span class="glyphicon glyphicon-check"></span> Envoyer !</button>
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