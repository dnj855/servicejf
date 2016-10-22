<?php
include('auth.php');
if ($_SESSION['admin'] == 0) {
    header('location:index.php');
}
//On profite pour faire les requêtes MySQL :
$donnees_service = $bdd->query('SELECT DISTINCT personnel_fbln.service_id, service_fbln.nom AS nom_service FROM personnel_fbln JOIN service_fbln ON personnel_fbln.service_id = service_fbln.id ORDER BY service_fbln.nom');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Le personnel de FBLN</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/design.css" rel="stylesheet" type="text/css" />

    </head>

    <body>
        <?php
        include('nav_menu.php');
        ?>
        <div class="container">
            <header class="col-sm-12">
                <h1>gestion du personnel</h1>
            </header>

            <nav class="row">
                <div class="col-sm-12 well well-sm">
                    <ul class="nav nav-pills nav-justified">
                        <li>
                            <a href="ar_ajout_personnel.php">Ajouter un joyeux participant</a>
                        </li>
                        <li>
                            <a href="ar_retour_personnel.php">Faire revenir un participant</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <section>
                <?php
                //Les messages si on vient de modifier un personnel :
                if (isset($_GET['error'])) {
                    ?>
                    <div class="row">
                        <?php
                        if ($_GET['error'] == 0) {
                            ?>
                            <div class="col-md-4 col-md-offset-4">
                                <div class="alert alert-success">
                                    <span class="glyphicon glyphicon-ok-sign"></span> Modifications effectuées.
                                </div>
                            </div>
                            <?php
                        } elseif ($_GET['error'] == 1) {
                            ?>
                            <div class="col-md-4 col-md-offset-4">
                                <div class="alert alert-danger">
                                    <span class="glyphicon glyphicon-remove-sign"></span> Une erreur s'est produite, réessayer.
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
                <div class="row">
                    <?php
                    while ($service = $donnees_service->fetch()) {

                        $donnees_query = $bdd->prepare('SELECT * FROM personnel_fbln WHERE service_id = ? AND actif = 1 ORDER BY cadre DESC, nom');
                        $donnees_query->execute(array($service['service_id']));
                        ?>

                        <div class="col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <?php echo $service['nom_service']; ?>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover table-condensed">
                                        <thead>
                                            <tr>
                                                <th>nom</th>
                                                <th>prénom</th>
                                                <th>pseudo</th>
                                                <th colspan="3">actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($personnel = $donnees_query->fetch()) {
                                                ?>
                                                <tr
                                                <?php
                                                //Petite mise en valeur si le personnel est un cadre.
                                                if ($personnel['cadre'] == '1') {
                                                    echo ' class="active"';
                                                }
                                                ?>
                                                    >
                                                    <td><?php echo $personnel['nom']; ?></td>
                                                    <td><?php echo $personnel['prenom']; ?></td>
                                                    <td><?php echo $personnel['pseudo']; ?></td>
                                                    <td><a href = "ar_modifier_personnel.php?id=<?php echo $personnel['id']; ?>"><span class="glyphicon glyphicon-cog"></span></a></td>
                                                    <td><a href = "ar_modif_mdp_personnel.php?id=<?php echo $personnel['id']; ?>"><span class="glyphicon glyphicon-lock"></span></a></td>
                                                    <td><a href = "ar_depart_personnel.php?id=<?php echo $personnel['id']; ?>"><span class="glyphicon glyphicon-remove"></span></td>
                                                </tr>
                                                <?php
                                            }
                                            $donnees_query->closeCursor();
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    $donnees_service->closeCursor();
                    ?>
                </div>
            </section>
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>