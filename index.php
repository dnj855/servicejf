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


        <header class="jumbotron col-sm-12">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 text-center hidden-sm hidden-xs">
                        <img src="assets/img/logo.png" alt="Logo" class="logo">
                    </div>
                    <div class="col-sm-12 text-center hidden-md hidden-lg">
                        <img src="assets/img/logo.png" alt="Logo" class="logo">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <p>découvrez les jeux et festivités en cours</p>
                    </div>
                </div>
            </div>
        </header>
        <div class="container">

            <!-- Voici le menu pour les petits écrans -->
            <div class="row">
                <div class="col-sm-12 hidden-lg hidden-md">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-primary">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Le challenge de l'invité
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <?php include('index_panels/ci.php'); ?>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Le challenge des soirées sport
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <?php include('index_panels/css.php'); ?>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Le challenge de la présidentielle
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <?php include('index_panels/cp.php'); ?>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-heading" role="tab" id="headingFour">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        Le challenge du fichier gnou
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                <?php include('index_panels/fg.php'); ?>
                            </div>
                        </div>
                        <?php if ($_SESSION['actif']) { ?>
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingFive">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                            La boite à idées
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                                    <?php include('index_panels/bai.php'); ?>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="panel panel-primary">
                            <div class="panel-heading" role="tab" id="headingSix">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                        Les anciens challenges
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                                <?php include('index_panels/oc.php'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Et le menu pour les grands écrans -->
            <section>
                <div class="row">
                    <div class="col-md-5 col-md-offset-1 visible-md-block visible-lg-block text-right">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">Le challenge de l'invité</h4>
                            </div>
                            <?php include('index_panels/ci.php'); ?>
                        </div>
                    </div>
                    <div class="col-md-5 visible-md-block visible-lg-block text-left">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">Le challenge des soirées sport</h4>
                            </div>
                            <?php include('index_panels/css.php'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-md-offset-1  visible-md-block visible-lg-block text-right">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">Le challenge de la présidentielle</h4>
                            </div>
                            <?php include('index_panels/cp.php'); ?>
                        </div>
                    </div>
                    <div class="col-md-5 visible-md-block visible-lg-block text-left">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">Le challenge du fichier gnou</h4>
                            </div>
                            <?php include('index_panels/fg.php'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php if ($_SESSION['actif']) { ?>

                        <div class="col-md-5 col-md-offset-1 visible-md-block visible-lg-block text-right">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Une boite à idées</h4>
                                </div>
                                <?php include('index_panels/bai.php'); ?>

                            </div>
                        </div>

                    <?php } ?>
                    <?php if ($_SESSION['actif']) { ?>

                        <div class="col-md-5 visible-md-block visible-lg-block text-left">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Les anciens challenges</h4>
                                </div>
                                <?php include('index_panels/oc.php'); ?>
                            </div>
                        </div>

                    <?php } else { ?>
                        <div class="col-md-10 col-md-offset-1 text-center visible-md-block visible-lg-block">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Les anciens challenges</h4>
                                </div>
                                <?php include('index_panels/oc.php'); ?>
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