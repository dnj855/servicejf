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
        <?php
        include('nav_menu.php')
        ?>

        <div class="container">
            <header>
                <h1>la messagerie interne</h1>
            </header>

            <section class="row">
                <nav class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="mess_formulaire.php"><span class="glyphicon glyphicon-pencil"></span> Ecrire un message</a></li>
                                <li class="<?php if ($mess_nonlus) { ?>active<?php } else { ?>disabled<?php } ?>"><a href="mess_nonlus.php"><span class="glyphicon glyphicon-star-empty"></span> Messages non lus</a></li>
                                <li><a href="mess_lus.php"><span class="glyphicon glyphicon-envelope"></span> Lire les messages</a></li>
                                <li><a href="index.php"><span class="glyphicon glyphicon-chevron-left"></span> Retour à l'accueil</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="col-md-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Messages non lus <span class="badge"><?php echo $mess_nonlus; ?></span>
                        </div>
                        <?php
                        $query = $bdd->prepare('SELECT personnel_fbln.prenom, mess.id AS mess_id, mess.titre AS mess_titre, DATE_FORMAT(date_message, \'%d/%m/%Y\') AS date FROM mess JOIN personnel_fbln ON id_sender = personnel_fbln.id WHERE lu = 0 AND id_receiver = ? ORDER BY date_message DESC');
                        $query->execute(array($_SESSION['id']));
                        while ($non_lu = $query->fetch()) {
                            ?>
                            <div class = "list-group">
                                <a href = "mess_read.php?id=<?php echo $non_lu['mess_id']; ?>" class="list-group-item">
                                    <h4 class="list-group-heading"><?php echo $non_lu['mess_titre']; ?></h4>
                                    <p class="list-group-item-text">Envoyé le <?php echo $non_lu['date']; ?> par <?php echo $non_lu['prenom']; ?></p>
                                </a>
                            </div>
                        <?php } ?>
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