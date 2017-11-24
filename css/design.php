<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8" />
        <meta name = "viewport" content = "width=device-width, initial-scale=1">
        <title>Service j&f: - le challenge des soirées sport</title>
        <link href = "assets/css/bootstrap.min.css" rel = "stylesheet" type = "text/css" />
        <link href = "assets/css/bootstrap-theme.min.css" rel = "stylesheet" type = "text/css" />
        <link href = "assets/css/design.css" rel = "stylesheet" type = "text/css" />
    </head>

    <body>
        <?php
        include('nav_menu.php')
        ?>

        <div class="container">
            <header class="page-header">
                <h1>le challenge des soirées sport</h1>
            </header>
            <?php if ($_SESSION['css'] == 1) { ?>
                <nav class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <ul class="nav nav-pills nav-justified">
                                    <li
                                    <?php
                                    if ($_GET['action'] == 'write') {
                                        echo ' class="active"';
                                    }
                                    ?>
                                        ><a href="css.php?action=write"><span class="glyphicon glyphicon-pencil"></span> Saisie</a></li>
                                    <li
                                    <?php
                                    if ($_GET['action'] == 'read') {
                                        echo ' class="active"';
                                    }
                                    ?>
                                        ><a href="css.php?action=read"><span class="glyphicon glyphicon-list-alt"></span> Résultats</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                <?php
            }
            if ($_SESSION['season'] != 0) { // si une saison a déjà été choisie
                ?>
                <div class="row">
                    <div class="col-xs-12">
                        <?php
                        include('panel_season.php');
                        ?>
                    </div>
                </div>
            <?php }
            ?>

            <div class="row">
                <?php
                if (!isset($_GET['action'])) {
                    include('404.php');
                }
                if ($_SESSION['css'] != 1 && $_GET['action'] == 'write') {
                    include('403.php');
                } elseif ($_GET['action'] == 'read') {
                    include('check_season_results.php');
                } elseif ($_GET['action'] == 'write') {
                    include('form.php');
                } elseif ($_POST['new_season']) {
                    include ('form.php');
                } else {
                    include('404.php');
                }
                ?>
            </div>
        </div>
    </body>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.min.js"></script>

</html>