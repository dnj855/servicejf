<?php
include('auth.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bienvenue sur le portail du service j&f:</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <?php include('nav_menu.php') ?>
        <div class="container">
            <header class="col-md-6 col-md-offset-3 text-center hidden-sm hidden-xs">
                <img src="assets/img/logo.png" alt="Logo" width="500px" class="logo">
            </header>

            <header class="col-sm-12 text-center hidden-lg hidden-md">
                <img src="assets/img/logo.png" alt="Logo" width="100%" class="logo">
            </header>

            <section>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <legend>
                            découvrez les jeux et festivités en cours
                        </legend>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 visible-md-block visible-lg-block col-md-offset-1 text-right">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">Le challenge de l'invité</h4>
                            </div>
                            <div class="panel-body">
                                Direct ou PAD ? Studio ou téléphone ?<br />Le challenge de l'invité est le point fondateur du service j&f:
                            </div>
                            <ul class="list-group">
                                <?php if ($_SESSION['service'] == '1' && $_SESSION['actif']) { ?>
                                    <li class="list-group-item">
                                        <a href="ci.php">Page à remplir pour l'intervieweur</a>
                                    </li>
                                <?php } ?>
                                <li class="list-group-item">
                                    <a href="ci_resultats.php">Consultation des résultats provisoires</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12 text-center hidden-lg hidden-md">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">Le challenge de l'invité</h4>
                            </div>
                            <div class="panel-body">
                                Direct ou PAD ? Studio ou téléphone ?<br />Le challenge de l'invité est le point fondateur du service j&f:
                            </div>
                            <ul class="list-group">
                                <?php if ($_SESSION['service'] == '1' && $_SESSION['actif']) { ?>
                                    <li class="list-group-item">
                                        <a href="ci.php">Page à remplir pour l'intervieweur</a>
                                    </li>
                                <?php } ?>
                                <li class="list-group-item">
                                    <a href="ci_resultats.php">Consultation des résultats provisoires</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-5 visible-md-block visible-lg-block text-left">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">Le challenge des soirées sport</h4>
                            </div>
                            <div class="panel-body">
                                Sur proposition du président d'honneur, voyons quel technicien porte le plus chance au FC Metz.
                            </div>
                            <ul class="list-group">
                                <?php if ($_SESSION['css'] == '1' && $_SESSION['actif']) { ?>
                                    <li class="list-group-item">
                                        <a href="css.php">La page à remplir après chaque journée de championnat</a>
                                    </li>
                                <?php } ?>
                                <li class="list-group-item">
                                    <a href="css_resultats.php">Consultation des résultats provisoires</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12 text-center hidden-lg hidden-md">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">Le challenge des soirées sport</h4>
                            </div>
                            <div class="panel-body">
                                Sur proposition du président d'honneur, voyons quel technicien porte le plus chance au FC Metz.
                            </div>
                            <ul class="list-group">
                                <?php if ($_SESSION['css'] == '1' && $_SESSION['actif']) { ?>
                                    <li class="list-group-item">
                                        <a href="css.php">La page à remplir après chaque journée de championnat</a>
                                    </li>
                                <?php } ?>
                                <li class="list-group-item">
                                    <a href="css_resultats.php">Consultation des résultats provisoires</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 visible-md-block visible-lg-block col-md-offset-1 text-right">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">Le challenge de la présidentielle</h4>
                            </div>
                            <div class="panel-body">
                                A l'occasion de l'élection présidentielle, le service j&f: vous propose un challenge joyeux et festif.
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <em>Challenge en cours de développement</em>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12 text-center hidden-lg hidden-md">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">Le challenge de la présidentielle</h4>
                            </div>
                            <div class="panel-body">
                                A l'occasion de l'élection présidentielle, le service j&f: vous propose un challenge joyeux et festif.
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <em>Challenge en cours de développement</em>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-5 visible-md-block visible-lg-block text-left">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">Le challenge du fichier gnou</h4>
                            </div>
                            <div class="panel-body">
                                Recensez toutes les punchlines entendues sur la plateforme. A la fin de la saison, nous élirons la meilleure.
                            </div>
                            <ul class="list-group">
                                <?php if ($_SESSION['actif']) { ?>
                                    <li class="list-group-item">
                                        <a href="fg.php?action=write">Poster une punchline</a>
                                    </li>
                                <?php } ?>
                                <li class="list-group-item">
                                    <a href="fg.php?action=read&month=<?php echo $now->format('m'); ?>&year=<?php echo $now->format('Y'); ?>">Lire les punchlines</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12 text-center hidden-lg hidden-md">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">Le challenge du fichier gnou</h4>
                            </div>
                            <div class="panel-body">
                                Recensez toutes les punchlines entendues sur la plateforme. A la fin de la saison, nous élirons la meilleure.
                            </div>
                            <ul class="list-group">
                                <?php if ($_SESSION['actif']) { ?>
                                    <li class="list-group-item">
                                        <a href="fg.php?action=write">Poster une punchline</a>
                                    </li>
                                <?php } ?>
                                <li class="list-group-item">
                                    <a href="fg.php?action=read&month=<?php echo $now->format('m'); ?>&year=<?php echo $now->format('Y'); ?>">Lire les punchlines</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php if ($_SESSION['actif']) { ?>

                        <div class="col-md-5 visible-md-block visible-lg-block col-md-offset-1 text-right">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Une boite à idées</h4>
                                </div>
                                <div class="panel-body">
                                    Toujours à l'écoute, le service j&f: vous propose de lui donner vos meilleures idées de jeux et de festivités.
                                </div>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <a href="bai.php">Cliquez ici, tout simplement</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-12 text-center hidden-lg hidden-md">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Une boite à idées</h4>
                                </div>
                                <div class="panel-body">
                                    Toujours à l'écoute, le service j&f: vous propose de lui donner vos meilleures idées de jeux et de festivités.
                                </div>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <a href="bai.php">Cliquez ici, tout simplement</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($_SESSION['actif']) { ?>

                        <div class="col-md-5 visible-md-block visible-lg-block text-left">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Les anciens challenges</h4>
                                </div>
                                <div class="panel-body">
                                    Ici, vous pouvez retrouver tous les anciens challenges réalisés par le service.
                                </div>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <a href="cph.php?action=home">Le challenge phénoménal handball</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-12 text-center hidden-lg hidden-md">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Les anciens challenges</h4>
                                </div>
                                <div class="panel-body">
                                    Ici, vous pouvez retrouver tous les anciens challenges réalisés par le service.
                                </div>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <a href="cph.php?action=home">Le challenge phénoménal handball</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-10 col-md-offset-1 text-center ">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Les anciens challenges</h4>
                                </div>
                                <div class="panel-body">
                                    Ici, vous pouvez retrouver tous les anciens challenges réalisés par le service.
                                </div>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <a href="cph.php?action=home">Le challenge phénoménal handball</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                </div>

            </section>
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>