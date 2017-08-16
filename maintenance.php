<?php
include ('auth.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Challenge des soirées sports</title>
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
                <h1 class="text-center">Challenge des soirées sport</h1>
            </header>
            <div class="row">
                <section class="col-sm-6 col-sm-offset-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h2 class="panel-title">Maintenance en cours</h2>
                        </div>
                        <div class="panel-body">
                            <p class="lead text-center">
                                Pour être encore plus proche de vous, le service jeux&festivités: travaille activement sur ce challenge.<br />Il reviendra très vite sous une nouvelle forme !
                            </p>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 75%">
                                    <span class="sr-only">45% Complete</span>
                                </div>
                            </div>
                            <p class="text-center">Revenez nous voir très vite, on aura plein de nouveautés pour vous !</p>
                        </div>
                </section>
            </div>
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>