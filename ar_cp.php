<?php
include('auth.php');
if ($_SESSION['admin'] == 0) {
    header('location:index.php');
}
if ($_GET['action'] == 'delete_result') {
    deleteCpResult($bdd, $_GET['rank']);
    header('location:ar_cp.php?action=set_score');
} elseif ($_GET['action'] == 'validate_results') {
    include('ar_cp/validate_results.php');
    header('location:cp.php?action=home');
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['final_winner'] != 0) {
    include('ar_cp/set_final_winner.php');
    header('location:cp.php?action=home');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gestion du challenge de la présidentielle</title>
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
                <h1>gestion du challenge de la présidentielle</h1>
            </header>

            <div class="row">
                <nav class="col-sm-4">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked">
                                <li<?php
                                if ($_GET['action'] == 'set_candidates') {
                                    echo ' class="active"';
                                }
                                ?>>
                                    <a href="ar_cp.php?action=set_candidates"><span class="glyphicon glyphicon-plus"></span> Enregistrer les candidats</a>
                                </li>
                                <li<?php
                                if ($_GET['action'] == 'set_score') {
                                    echo ' class="active"';
                                }
                                ?>>
                                    <a href="ar_cp.php?action=set_score"><span class="glyphicon glyphicon-pencil"></span> Enregistrer les résultats</a>
                                </li>
                                <li<?php
                                if ($_GET['action'] == 'close_bet') {
                                    echo ' class="active"';
                                }
                                ?>>
                                    <a href="ar_cp.php?action=close_bet"><span class="glyphicon glyphicon-off"></span> Clore les pronostics</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <section class="col-sm-8">
                    <?php
                    if (!isset($_GET['action'])) {
                        echo '<div class="well text-center">Choisir une action à gauche</div>';
                    } elseif ($_GET['action'] == 'set_candidates') {
                        include('ar_cp/set_candidates.php');
                    } elseif ($_GET['action'] == 'set_score') {
                        include('ar_cp/set_score.php');
                    } elseif ($_GET['action'] == 'close_bet') {
                        include('ar_cp/close_bet.php');
                    } elseif ($_GET['action'] == 'test') {
                        include('ar_cp/test.php');
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