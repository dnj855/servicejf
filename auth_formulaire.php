<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Bienvenue sur le portail du service j&f:</title>
        <link href="auth.css" rel="stylesheet" type="text/css" />
        <link href="design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
    <div class="index">
    <p class="titre">connexion au portail du service j&f:</p>
    <?php if($_GET['log'] == 'no') {
        echo '<p class="formulaire_erreur">Les informations saisies ne sont pas correctes.</p>';
    }
    elseif ($_GET['log'] == 'nopseudo') {
        echo '<p class="formulaire_erreur">Ce compte utilisateur n\'existe pas.</p>';
    } ?>
    <div class="formulaire">
    <table class="formulaire">
    <form method="post" action="auth_traitement.php">
    <tr>
    <td>Votre pseudo :</td>
    <td><input type="text" name="auth_pseudo" class="formulaire"></td>
    </tr>
    <tr>
    <td>Votre mot de passe :</td>
    <td><input type="password" name="auth_mdp" class="formulaire"></td>
    </tr>
    <tr>
    <td></td>
    <td><input type="submit" class="envoi_formulaire" value="Se connecter"></td>
    </tr>
    </form>
    </table>
    </div>
    <p class="help">En cas d'oubli du pseudo ou du mot de passe, le responsable du service j&f: se fera une joie de vous aider.</p>
    </div>
    </body>
    </html>