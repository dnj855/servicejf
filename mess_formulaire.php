<?php
include('auth.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Service j&f: - messagerie interne</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <?php include('nav_menu.php') ?>

        <div class="container">
            <header>
                <h1>la messagerie interne</h1>
            </header>

            <section class="row">
                <nav class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked">
                                <li class="active"><a href="mess_formulaire.php"><span class="glyphicon glyphicon-pencil"></span> Ecrire un message</a></li>
                                <li<?php if (!$mess_nonlus) { ?> class="disabled"<?php } ?>><a href="mess_nonlus.php"><span class="glyphicon glyphicon-star-empty"></span> Messages non lus</a></li>
                                <li><a href="mess_lus.php"><span class="glyphicon glyphicon-envelope"></span> Lire les messages</a></li>
                                <li><a href="index.php"><span class="glyphicon glyphicon-chevron-left"></span> Retour à l'accueil</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="col-md-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Ecrire un nouveau message
                        </div>
                        <div class="panel-body">
                            <form method="post" action="mess_traitement.php">
                                <div class="form-group">
                                    <label for="destinataire">Destinataire :</label>
                                    <select name="destinataire" class="form-control">
                                        <option value="">---Choisir---</option>

                                        <?php
                                        // Les deux boucles pour afficher les destinataires possibles.
                                        $req_service = $bdd->query('SELECT * FROM service_fbln ORDER BY nom');
                                        while ($service = $req_service->fetch()) {
                                            echo '<optgroup label="' . $service['nom'] . '">';
                                            $req = $bdd->prepare('SELECT id, prenom FROM personnel_fbln WHERE service_id = ? AND actif = 1 AND id != ? ORDER BY prenom');
                                            $req->execute(array($service['id'], $_SESSION['id']));
                                            while ($destinataire = $req->fetch()) {
                                                echo '<option value="' . $destinataire['id'] . '">' . $destinataire['prenom'] . '</option>';
                                            }
                                            echo '</optgroup>';
                                        }
                                        ?>
                                    </select>
                                    <p class="help-block">N'oubliez pas le destinataire ;-)</p>
                                </div>
                                <div class="form-group">
                                    <label for="titre">Titre :</label>
                                    <input type="text" id="titre" name="titre" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="message">Message :</label>
                                    <textarea rows="6" name="message" id="message" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="expediteur" value="<?php echo $_SESSION['id']; ?>">
                                    <button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-ok"></span> Envoyer</button>
                                    <button type="reset" class="btn btn-danger pull-left"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </body>
</html>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>