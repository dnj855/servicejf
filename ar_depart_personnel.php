<?php
include('auth.php');
if($_SESSION['admin'] == 0) {
    header('location:index.php');
}

        $_GET['id'] = (int) $_GET['id']; //Vérification de l'id reçue.

        $query = $bdd->prepare('SELECT * FROM personnel_fbln WHERE id = ?');
        $query->execute(array($_GET['id']));

        $personnel=$query->fetch();

        ?>

            <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <title>Signaler le départ de <?php echo $personnel['prenom'] . ' ' . $personnel['nom'];?></title>
        <link href="design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
    <?php include('nav_menu.php');
    include('auth_menu_utilisateur.php');
    ?>
    <div class="index">
    <p class="titre">Départ de <?php echo $personnel['prenom'] . ' ' . $personnel['nom'] ?></p>
    <div class="formulaire">
    <table class="formulaire">
    <form method="post" action="ar_depart_personnel_traitement.php">
    <tr><td><input type="checkbox" name="depart" class="formulaire"></td><td>Cocher la case pour confirmer.</td></tr>
    <tr><td></td><td>
    <input type="hidden" name="id" value="<?echo $personnel['id'] ?>">
    <input type="submit" class="envoi_formulaire"></td></tr>
    </form></table></div>
    </div>
    </body>
    </html>