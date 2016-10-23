<?php
include('auth.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Service j&f: - messagerie interne</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <?php include 'nav_menu.php'; ?>

        <div class="container">
            <header class="page-header">
                <h1>la messagerie interne</h1>
            </header>

            <section>
                <?php if ($_GET['mess'] == 'ok') { ?>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <span class="glyphicon glyphicon-ok-circle"></span> Message envoyé !
                            </div>
                        </div>
                    </div>
                <?php } ?>
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
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <?php
                                if ($mess_lus != 0) {
                                    echo 'Lire les messages';
                                } else {
                                    echo 'Vous n\'avez aucun message.';
                                }
                                ?>
                            </div>
                            <?php
                            $query = $bdd->prepare('SELECT personnel_fbln.prenom, mess.id AS mess_id, mess.titre AS mess_titre, DATE_FORMAT(date_message, \'%d/%m/%Y\') AS date FROM mess JOIN personnel_fbln ON id_sender = personnel_fbln.id WHERE lu = 1 AND id_receiver = ? ORDER BY mess.id DESC');
                            $query->execute(array($_SESSION['id']));
                            while ($message = $query->fetch()) {
                                ?>
                                <div class="list-group">
                                    <a href="mess_read.php?id=<?php echo $message['mess_id']; ?>" class="list-group-item">
                                        <h5 class="list-group-item-heading"><?php echo $message['mess_titre']; ?></h5>
                                        <p class="list-group-item-text">Envoyé le <?php echo $message['date']; ?> par <?php echo $message['prenom']; ?></p>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>


        <!--jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>