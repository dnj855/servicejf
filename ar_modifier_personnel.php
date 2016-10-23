<?php
include('auth.php');
if ($_SESSION['admin'] == 0) {
    header('location:index.php');
}

if (isset($_GET['id'])) {
    $_GET['id'] = (int) $_GET['id']; //Vérification de l'id reçue. Si tout est bon, on connecte à la BDD et on propose le formulaire

    $query = $bdd->prepare('SELECT * FROM personnel_fbln WHERE id = ?');
    $query->execute(array($_GET['id']));

    $personnel = $query->fetch();
    $service_personnel = $personnel['service_id']; //On détermine à l'avance de quel service provient le salarié concerné.
    $query->closeCursor();

    $query_cadre = $bdd->prepare('SELECT cadre FROM personnel_fbln WHERE id = ?');
    $query_cadre->execute(array($_GET['id']));
    $donnees_cadre = $query_cadre->fetch(); //On détermine à l'avance si le personnel est cadre ou non.

    $query_admin = $bdd->prepare('SELECT admin FROM personnel_fbln WHERE id = ?');
    $query_admin->execute(array($_GET['id']));
    $donnees_admin = $query_admin->fetch(); //On détermine à l'avance si le personnel est administrateur du site.

    $query_css = $bdd->prepare('SELECT css FROM personnel_fbln WHERE id = ?');
    $query_css->execute(array($_GET['id']));
    $donnees_css = $query_css->fetch(); //On détermine à l'avance si le personnel est autorisé à participer au css.
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8" />
            <title>Modifier un participant</title>
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
                    <h1>modifier les informations générales</h1>
                </header>
                <section class="row">
                    <!--Navigation spécifique pour l'espace de gestion du personnel. Penser à changer la classe "active" !-->
                    <nav class="col-md-4">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <ul class="nav-pills nav nav-stacked">
                                    <li class="active"><a href="ar_modifier_personnel.php?id=<?php echo $_GET['id']; ?>"><span class="glyphicon glyphicon-cog"></span> Modifier les informations générales</a></li>
                                    <li><a href="ar_modif_mdp_personnel.php?id=<?php echo $_GET['id']; ?>"><span class="glyphicon glyphicon-lock"></span> Modifier le mot de passe</a></li>
                                    <li><a href="ar_depart_personnel.php?id=<?php echo $_GET['id']; ?>"><span class="glyphicon glyphicon-remove"></span> Faire partir le participant</a></li>
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
                                <form method="post" action="ar_modifier_personnel_traitement.php" class="form-horizontal">
                                    <?php include 'ar_formulaire_utilisateur.php'; ?>
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

    <?php
}
?>