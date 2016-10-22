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
        <title>Faire revenir un participant</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <?php
        include('nav_menu.php');
        ?>
        <div class="container">
            <header>
                <h1>faire revenir un participant</h1>
            </header>

            <section class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Les participants partis
                        </div>
                        <ul class="list-group">
                            <?php
                            $participants_partis = $bdd->query('SELECT id, nom, prenom FROM personnel_fbln WHERE actif = 0');
                            while ($pp = $participants_partis->fetch()) {
                                ?>

                                <li class="list-group-item">
                                    <?php echo $pp['prenom'] . ' ' . $pp['nom']; ?> <a href="ar_retour_personnel_traitement.php?id=<?php echo $pp['id']; ?>"><span class="glyphicon glyphicon-repeat pull-right"></span></a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
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