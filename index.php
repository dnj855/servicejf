<?php
include('auth.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Bienvenue sur le portail du service j&f:</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <?php include('nav_menu.php') ?>
        <div class="container">
            <header class="col-md-6 col-md-offset-3 text-center">
                <img src="logo.png" alt="Logo" width="500px" class="logo">
            </header>

            <section>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <legend>
                            découvrez les jeux et festivités en cours
                        </legend>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5 col-sm-offset-1 text-right">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Le challenge de l'invité
                            </div>
                            <div class="panel-body">
                                Direct ou PAD ? Studio ou téléphone ?<br />Le challenge de l'invité est le point fondateur du service j&f:
                            </div>
                            <ul class="list-group">
                                <?php if ($_SESSION['service'] == '1') { ?>
                                    <li class="list-group-item">
                                        <a href="ci.php">Page à remplir pour l'intervieweur</a>
                                    </li>
                                <?php } ?>
                                <li class="list-group-item">
                                    <a href="ci_resultats.php">Consultation des résultats provisoires</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-5 text-left">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Le challenge des soirées sport
                            </div>
                            <div class="panel-body">
                                Sur proposition du président d'honneur, voyons quel technicien porte le plus chance au FC Metz.
                            </div>
                            <ul class="list-group">
                                <?php if ($_SESSION['css'] == '1') { ?>
                                    <li class="list-group-item">
                                        <a href="css.php">La page à remplir après chaque journée de championnat</a>
                                    </li>
                                <?php } ?>
                                <li class="list-group-item">
                                    <a href="css_resultats.php">Consultation des résultats provisoires</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5 col-sm-offset-1 text-right">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Une boite à idées
                            </div>
                            <div class="panel-body">
                                Toujours à l'écoute, le service j&f: vous propose de lui donner vos meilleures idées de jeux et de festivités.
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a href="bai.php">Cliquez ici, tout simplement</a>
                                </li>
                            </ul>
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