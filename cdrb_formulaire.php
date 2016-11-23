<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Service j&f: - le challenge du derby lorrain</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/design.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <?php include('nav_menu.php') ?>
        <div class="container">
            <header class="page-header">
                <h1>le challenge du derby lorrain</h1>
            </header>
            <section class="row">
                <div class="col-md-8 col-md-offset-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    Entrer son pronostic
                                    <button class="btn btn-default btn-xs pull-right" type="button" data-toggle="collapse" data-target="#reglement" aria-expanded="false" aria-controls="reglement">
                                        <span class="glyphicon glyphicon-asterisk"></span> Règlement
                                    </button>
                                </div>
                                <div class="panel-body">
                                    <form method="post" class="form-inline">
                                        <div class="form-group">
                                            <label class="sr-only" for="score_asnl">Score de Nancy</label>
                                            <input type="number" class="form-control" id="score_asnl" name="score_asnl" placeholder="Score de l'ASNL">
                                        </div>
                                        -
                                        <div class="form-group">
                                            <label class="sr-only" for="score_fcmetz">Score du FC Metz</label>
                                            <input type="number" class="form-control" id="score_asnl" name="score_fcmetz" placeholder="Score du FC Metz">
                                            <input type='hidden' name="id" value="<?php echo $_SESSION['id'] ?>">
                                        </div>
                                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-check"></span> Envoyer</button>
                                    </form>
                                </div>
                                <div class="panel-footer">
                                    Attention, toute validation est définitive. Vérifiez bien votre pronostic avant de cliquer.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 collapse" id="reglement">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    Règlement du challenge du derby lorrain
                                </div>
                                <div class="panel-body">
                                    Le règlement est en cours de validation par les responsables du service jeux&festivités: Il sera publié dès son adoption.
                                </div>
                            </div>
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