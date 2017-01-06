<?php
include('auth.php');
if ($_SESSION['admin'] == 0) {
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gestion du challenge phénoménal handball</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/design.css" rel="stylesheet" type="text/css" />

    </head>

    <body>
        <?php
        include('nav_menu.php');
        ?>
        <div class="container">
            <header class="page-header">
                <h1>gestion du challenge phénoménal handball</h1>
            </header>

            <div class="row">
                <nav class="col-sm-4">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked">
                                <li<?php
                                if ($_GET['action'] == 'set_game') {
                                    echo ' class="active"';
                                }
                                ?>>
                                    <a href="ar_cph.php?action=set_game"><span class="glyphicon glyphicon-plus"></span> Créer une affiche</a>
                                </li>
                                <li<?php
                                if ($_GET['action'] == 'set_score') {
                                    echo ' class="active"';
                                }
                                ?>>
                                    <a href="ar_cph.php?action=set_score"><span class="glyphicon glyphicon-pencil"></span> Enregistrer un score</a>
                                </li>
                                <li<?php
                                if ($_GET['action'] == 'close_bet_phase') {
                                    echo ' class="active"';
                                }
                                ?>>
                                    <a href="ar_cph.php?action=close_bet_phase"><span class="glyphicon glyphicon-remove-sign"></span> Clore une phase de pronostics</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <section class="col-sm-8">
                    <?php
                    if (!isset($_GET['action'])) {
                        echo '<div class="well text-center">Choisir une action à gauche</div>';
                    } elseif ($_GET['action'] == 'set_game') {
                        include('ar_cph/set_game.php');
                    } elseif ($_GET['action'] == 'set_score') {
                        include('ar_cph/set_score.php');
                    } elseif ($_GET['action'] == 'close_bet_phase') {
                        include('ar_cph/close_bet_phase.php');
                    } else {
                        echo '<div class="well text-center">Erreur 404 : la page demandée n\'existe pas</div>';
                    }
                    ?>

                </section>
            </div>
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>