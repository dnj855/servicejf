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
        <title>Ajouter un nouveau participant au service j&f:</title>
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
                <h1>ajouter un nouveau participant</h1>
            </header>

            <section class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <form method="post" action="ar_ajout_personnel_traitement.php" class="form-horizontal">
                                <?php include 'ar_formulaire_utilisateur.php'; ?>
                        </div>
                        <div class="panel-footer">
                            Ne pas oublier de créer un mot de passe au participant après l'avoir ajouté.
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