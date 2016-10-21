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
        <title>Les participants partis</title>
        <link href="design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
    <?php include('nav_menu.php');
    include('auth_menu_utilisateur.php');
    ?>
    <div class="index">
    <p class="titre">Faire revenir un participant</p>
    <div class="ar_personnel">
    <table class="ar_personnel">
    <?php
    $participants_partis = $bdd->query('SELECT id, nom, prenom FROM personnel_fbln WHERE actif = 0');
    while($pp=$participants_partis->fetch()){
        echo '<tr><td>' . $pp['prenom'] . ' ' . $pp['nom'] . '</td><td><a href="ar_retour_personnel_traitement.php?id=' . $pp['id'] . '" class="ar_personnel">faire revenir</a></td></tr>';
    }
?>
</table>
</div>
</div>
</body>
</html>