<?php

include('auth.php'); // Comme sur toutes les pages du site, avec notamment l'include de la BDD.
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Modifier mon compte</title>
        <link href="auth.css" rel="stylesheet" type="text/css" />
        <link href="design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>

    <?php
    include('auth_menu_utilisateur.php');
    include('nav_menu.php');
    $query=$bdd->prepare('SELECT * FROM personnel_fbln WHERE id = ?'); // On va récupérer les données de l'utilisateur connecté.
    $query->execute(array($_SESSION['id']));
    $utilisateur = $query->fetch();
    ?>
    <div class="index">
    <p class="titre">
    modifier mon compte
    </p>
    <p class="auth_modify_nom">
    <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom'] ?>
    </p>

    <?php // Affichage des possibles messages d'erreur.
    if ($_GET['log'] == 'done') { // Si tout s'est bien passé.
        echo '<p class="auth_modify_erreur">C\'est bien noté, merci !</p>';
    }
    elseif ($_GET['log'] == 'mdp_wrong') { // Si les deux mots de passe ne sont pas les mêmes.
        echo '<p class="auth_modify_erreur">Les deux mots de passes saisis ne correspondent pas.</p>';
    }
    elseif ($_GET['log'] == 'noid') {
        echo '<p class="auth_modify_erreur">Mauvais ancien mot de passe.</p>';
    }

    ?>

    <div class="formulaire">
	<form method="post" action="auth_modifier_utilisateur.php">
    <table class="formulaire">
    <tr>
    <td>Modifier mon pseudo :</td>
    <td><input type="text" name="modify_pseudo_only" class="formulaire" value="<?php echo $utilisateur['pseudo'] ?>"></td>
    </tr>
    <tr>
    <td>
    </td>
    <td><input type="hidden" name="id" value="<?php echo $_SESSION['id'] ?>"><input type="submit" class="envoi_formulaire" value="Modifier seulement mon pseudo"></td>
    </tr>
    </table>
    </form>
    </div>

    <div class="formulaire_bis">
    <form method="post" action="auth_modifier_utilisateur.php">
    <table class="formulaire">
    <tr>
    <td>Modifier mon pseudo :</td>
    <td><input type="text" name="modify_pseudo" class="formulaire" value="<?php echo $utilisateur['pseudo'] ?>"></td>
    </tr>
    <tr>
    <td>Mon ancien mot de passe :</td>
    <td><input type="password" name="old_mdp" class="formulaire"></td>
    </tr>
    <tr>
    <td>Mon nouveau mot de passe :</td>
    <td><input type="password" name="new_mdp_1" class="formulaire"></td>
    </tr>
    <tr>
    <td>Retaper mon nouveau mot de passe :</td>
    <td><input type="password" name="new_mdp_2" class="formulaire"></td>
    </tr>
    <tr>
    <td></td>
    <td><input type="hidden" name="id" value="<?php echo $_SESSION['id'] ?>"><input type="submit" class="envoi_formulaire" value="Modifier mon compte"></td>
    </tr>
    </table>
    </form>
    </div>

    <?php $query->closeCursor() ?>
    </div>
    </body>
    </html>