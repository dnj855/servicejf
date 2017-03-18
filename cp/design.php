<?php
if (!$cp_include) {
    header('location:../index.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Service j&f: - le challenge de la présidentielle</title>
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
                <h1>le challenge de la présidentielle</h1>
            </header>
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-justified">
                                <?php
                                $cp_situation = checkCpSituation($bdd, $_SESSION['id'], $now, $cp_date_debut, $cp_date_butoir);
                                if ($cp_situation == 'before_beginning') {
                                    include('menu/before_beginning.php');
                                } elseif ($cp_situation == 'betweentwolegs') {
                                    include('menu/betweentwolegs.php');
                                } elseif ($cp_situation == 'aftersecondleg') {
                                    include('menu/aftersecondleg.php');
                                } elseif ($cp_situation == 'play_without_definitive') {
                                    include('menu/play_without_definitive.php');
                                } elseif ($cp_situation == 'play_with_definitive') {
                                    include('menu/play_with_definitive.php');
                                } elseif ($cp_situation == 'inactive') {
                                    include('menu/inactive.php');
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                if ($_GET['action'] == 'home') {
                    include('home.php');
                } elseif ($_GET['action'] == 'view_my_bets') {
                    include('view_my_bets.php');
                } elseif ($_GET['action'] == 'view_all_bets') {
                    include('view_bets.php');
                } elseif ($_GET['action'] == 'rules') {
                    include('rules.php');
                }
                ?>
            </div>
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>