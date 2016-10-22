<?php
include('auth.php');
if ($_SESSION['admin'] == 0) {
    header('location:index.php');
}

$_GET['id'] = (int) $_GET['id']; //Vérification de l'id reçue.

$query = $bdd->prepare('SELECT * FROM personnel_fbln WHERE id = ?');
$query->execute(array($_GET['id']));

$personnel = $query->fetch();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Signaler le départ d'un participant</title>
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
                <h1>départ d'un participant</h1>
            </header>
            <section class="row">
                <!--Navigation spécifique pour l'espace de gestion du personnel. Penser à changer la classe "active" !-->
                <nav class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <ul class="nav-pills nav nav-stacked">
                                <li><a href="ar_modifier_personnel.php?id=<?php echo $_GET['id']; ?>"><span class="glyphicon glyphicon-cog"></span> Modifier les informations générales</a></li>
                                <li><a href="ar_modif_mdp_personnel.php?id=<?php echo $_GET['id']; ?>"><span class="glyphicon glyphicon-lock"></span> Modifier le mot de passe</a></li>
                                <li class="active"><a href="ar_depart_personnel.php?id=<?php echo $_GET['id']; ?>"><span class="glyphicon glyphicon-remove"></span> Faire partir le participant</a></li>
                                <li><a href="ar_affichage_personnel.php"><span class="glyphicon glyphicon-chevron-left"></span> Retour à la liste générale</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="col-md-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <?php echo $personnel['prenom'] . ' ' . $personnel['nom']; ?>
                        </div>
                        <div class="panel-body">
                            <form method="post" action="ar_depart_personnel_traitement.php">
                                <fieldset>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="depart">Cocher la case pour confirmer.</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="<?php echo $personnel['id']; ?>">
                                        <button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-ok"></span> Valider</button>
                                    </div>
                                </fieldset>
                            </form>
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