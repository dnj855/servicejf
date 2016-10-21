<?php
include('auth.php');
if($_SESSION['admin'] == 0) {
    header('location:index.php');
}
else {
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Espace prive / Portail j&f:</title>
        <link href="design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
    <?php include('nav_menu.php');
    include('auth_menu_utilisateur.php');
    ?>
    <div class="index">
    <p class="titre">zone d'administration du portail j&f:</p>
    <div class="ci_resultats">
    <p align="center">
    <a href="ar_affichage_personnel.php" class="menu">Gestion du personnel</a><br />
    <a href="ar_bai_consult.php" class="menu">Consultation des messages de la boite à idées</a><br />
    </p>
    </div>
    </div>
    </body>
    </html>
<?php
}

?>

