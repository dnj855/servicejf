<?php
include('auth.php');
if($_SESSION['admin'] == 0) {
    header('location:index.php');
}

$query = $bdd->prepare('SELECT nom, prenom, id FROM personnel_fbln WHERE id = ?');
$query->execute(array($_GET['id']));
$personnel = $query->fetch();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Modifier le mot de passe de <?php echo $personnel['prenom'] . ' ' . $personnel['nom'] ?></title>
        <link href="design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
    <?php include('nav_menu.php');
    include('auth_menu_utilisateur.php');
    ?>
    <div class="index">
    <p class="titre">Modifier le mot de passe de <?php echo $personnel['prenom'] . ' ' . $personnel['nom'] ?></p>
    <div class="formulaire">
    <form class="formulaire" method="post" action="ar_modif_mdp_personnel_traitement.php">
    <table class="formulaire">
    <tr><td>Nouveau mot de passe</td><td><input type="password" name="mdp" class="formulaire"></td></tr>
    <tr><td></td><td><input type="hidden" name="id" value="<?php echo $personnel['id'] ?>">
    <input type="submit" value="Validation (définitive !)" class="envoi_formulaire">
    <?php $query->closeCursor() ?>
    </td></tr></table>
    </form>
    </div>
    </div>
    </body>
    </html>