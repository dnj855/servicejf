<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
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
                <h1>le challenge phénoménal handball</h1>
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
                            <ul class="nav nav-tabs nav-justified">
                                <li <?php
                                if ($_GET['action'] == 'home') {
                                    echo 'class="active"';
                                }
                                ?>><a href="cph.php?action=home"><span class="glyphicon glyphicon-th-list"></span> Classement provisoire</a></li>
                                <li <?php
                                if ($_GET['action'] == 'set_bet') {
                                    echo 'class="active"';
                                }
                                ?>><a href="cph.php?action=set_bet"><span class="glyphicon glyphicon-pencil"></span> Enregistrer ses pronostics</a></li>
                                <li <?php
                                if ($_GET['action'] == 'view_bet') {
                                    echo 'class="active"';
                                }
                                ?>><a href="cph.php?action=view_bet"><span class="glyphicon glyphicon-eye-open"></span> Voir tous les pronostics</a></li>

                                <li <?php
                                if ($_GET['action'] == 'reglement') {
                                    echo 'class="active"';
                                }
                                ?>><a href="cph.php?action=reglement"><span class="glyphicon glyphicon-list-alt"></span> Lire le règlement</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <section class="col-md-8">
                    <?php
                    if ($_GET['action'] == 'home') {
                        include ('cph_home.php');
                    } elseif ($_GET['action'] == 'reglement') {
                        include ('cph_reglement.php');
                    } else {
                        echo 'Erreur 404';
                    }
                    ?>
                </section>
            </div>


            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>