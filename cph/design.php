<?php
if (!$cph_include) {
    header('location:../index.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Service j&f: - le challenge phénoménal handball</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <?php
        include('nav_menu.php')
        ?>
        <div class="container">
            <header class="page-header">
                <h1>le challenge phénoménal handball <small><em>ce challenge n'est plus actif</em></small></h1>
            </header>

            <?php if ($_SESSION['message']) { ?>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                            ?>
                        </div>
                    </div>
                </div>
            <?php }
            ?>
            <div class="row">
                <nav class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-justified">
                                <li <?php
                                if ($_GET['action'] == 'home') {
                                    echo 'class="active"';
                                }
                                ?>><a href="cph.php?action=home"><span class="glyphicon glyphicon-th-list"></span> Classement final</a></li>
                                <li <?php
                                if ($_GET['action'] == 'view_bet') {
                                    echo 'class="active"';
                                }
                                ?>><a href="cph.php?action=view_bet"><span class="glyphicon glyphicon-eye-open"></span> Voir tous les pronostics</a></li>
                                <li><a href="cph.php?action=reglement"><span class="glyphicon glyphicon-list-alt"></span> Lire le règlement</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <?php
                if ($_GET['action'] == 'home') {
                    echo '<section class="col-sm-12">';
                    include ('home.php');
                    echo '</section>';
                } elseif ($_GET['action'] == 'reglement') {
                    include ('reglement.php');
                } elseif ($_GET['action'] == 'view_bet') {
                    if (!checkCphRegistration($bdd, $_SESSION['id']) && !checkCphBegin($bdd)) {
                        echo '<div class="well"><p class="lead text-center">Tu n\'es pas encore inscrit, cette page ne t\'est donc pas accessible.</p><p class="text-center"><a href="cph.php?action=home">Va pronostiquer le vainqueur final pour commencer.</a></p></div>';
                    } else {
                        include ('view_bet.php');
                    }
                } elseif ($_GET['action'] == 'set_bet') {
                    if (!checkCphRegistration($bdd, $_SESSION['id'])) {
                        echo '<section class="col-sm-12"><div class="well"><p class="lead text-center">Tu n\'es pas encore inscrit, cette page ne t\'est donc pas accessible.</p><p class="text-center"><a href="cph.php?action=home">Va pronostiquer le vainqueur final pour commencer.</a></p></div></section>';
                    } else {
                        include ('set_bet.php');
                    }
                } else {
                    echo 'Erreur 404';
                }
                ?>
            </div>


            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>