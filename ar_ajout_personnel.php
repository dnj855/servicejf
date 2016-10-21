<?php
include('auth.php');
if($_SESSION['admin'] == 0) {
    header('location:index.php');
}
?>
<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <title>Ajouter un nouveau participant au service j&f:</title>
        <link href="design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
    <?php include('nav_menu.php');
    include('auth_menu_utilisateur.php');
    ?>
    <div class="index">
    <p class="titre">ajouter un nouveau participant au service j&f:</p>
    <div class="formulaire">
    <table class="formulaire">
    <form method="post" action="ar_ajout_personnel_traitement.php">
    <tr><td>Nom :</td><td><input type="text" name="nom" class="formulaire"></td></tr>
    <tr><td>Prénom :</td><td><input type="text" name="prenom" class="formulaire"></td></tr>
    <tr><td>Pseudo :</td><td><input type="text" name="pseudo" class="formulaire"></td></tr>
    <tr><td>Mot de passe :</td><td><input type="password" name="mdp" class="formulaire"></td></tr>
    <tr><td>Service :</td><td><select name="service" class="formulaire">
        <?php

        $query_service = $bdd->prepare('SELECT nom, id FROM service_fbln ORDER BY nom');
        $query_service->execute(array($service_personnel));

        while ($service = $query_service->fetch())
        {
            echo '<option value="' . $service['id'] . '">' . $service['nom'] . '</option>';
        }
        $query_service->closeCursor();
    ?>
    </select></td></tr>
    <tr><td>Cadre ?</td><td>
    <input type="radio" name="cadre" value="1" /><label for="1"> Oui</label> <input type="radio" name="cadre" value="0" checked="checked"/><label for="0"> Non</label>

    </td></tr>
    <tr><td>Administrateur ?</td><td><input type="radio" name="admin" value="1" /><label for="1"> Oui</label> <input type="radio" name="admin" value="0" checked="checked"/><label for="0"> Non</label></td></tr>
    <tr><td>Soirées foot ?</td><td><input type="radio" name="css" value="1" /><label for="1"> Oui</label> <input type="radio" name="css" value="0" checked="checked"/><label for="0"> Non</label></td></tr>
    <tr><td></td><td><input type="submit" value="Envoyer !" class="envoi_formulaire"></td></tr>
    </form>
    </table>
    </div>
    </div>
    </body>
    </html>