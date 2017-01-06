<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">Voir tous les pronostics</h4>
                        </div>
                        <table class="table table-condensed table-striped">
                            <tr>
                                <th>Participant</th>
                                <th>Score ASNL</th>
                                <th>Score FC Metz</th>
                            </tr>
                            <?php
                            $pronostics = getCdrb($bdd);
                            foreach ($pronostics as $prono) {
                                ?>
                                <tr>
                                    <td><?php
                                        $identite = getUserIdentity($bdd, $prono['id_participant']);
                                        echo $identite['prenom'] . ' ';
                                        echo $identite['nom'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $prono['score_asnl'] ?>
                                    </td>
                                    <td>
                                        <?php echo $prono['score_fcmetz'] ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
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