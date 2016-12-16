<?php
include('auth.php');
if (!$_GET) {
    header('location:index.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Service j&f: - le challenge du fichier gnou</title>
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
                <h1>le challenge du fichier gnou</h1>
            </header>

            <?php if ($_SESSION['message']) { ?>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $_SESSION['message'];
                            unset($_SESSION['message']);
                            ?>
                        </div>
                    </div>
                </div>
            <?php }
            ?>
            <div class="row">
                <nav class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked">
                                <li <?php
                                if ($_GET['action'] == 'write') {
                                    echo 'class="active"';
                                }
                                ?>><a href="fg.php?action=write"><span class="glyphicon glyphicon-pencil"></span> Poster une punchline</a></li>
                                <li <?php
                                if ($_GET['action'] == 'read' || $_GET['action'] == 'vote') {
                                    echo 'class="active"';
                                }
                                ?>><a href="fg.php?action=read&month=<?php echo $now->format('m'); ?>"><span class="glyphicon glyphicon-list-alt"></span> Lire les punchlines</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <section class="col-md-8">
                    <?php
                    if ($_GET['action'] == 'write') {
                        include ('fg_write.php');
                    } elseif ($_GET['action'] == 'read') {
                        include ('fg_read.php');
                    } elseif ($_GET['action'] == 'vote') {
                        include ('fg_vote.php');
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


