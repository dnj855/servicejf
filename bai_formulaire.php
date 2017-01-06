<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Service j&f: - boite à idées</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <?php include('nav_menu.php') ?>
        <div class="container">
            <header class="page-header">
                <h1>la boite à idées</h1>
            </header>
            <section>
                <?php if (isset($_POST['message'])) { ?>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <span class="glyphicon glyphicon-ok-circle"></span> Message bien reçu.<br/>Promis, on te lit au plus vite !
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col-md-8 col-md-offset-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Nous sommes toujours à l'écoute. Qu'as-tu à nous dire ?
                            </div>
                            <div class="panel-body">
                                <form method="post">
                                    <div class="form-group">
                                        <textarea name="message" class="form-control" rows="5" placeholder="Inscris ton message ici."></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary pull-right" <?php
                                        if (isset($_POST['message'])) {
                                            echo 'disabled="disabled"';
                                        }
                                        ?>><span class="glyphicon glyphicon-ok"></span> Envoyer</button>
                                    </div>
                                </form>
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