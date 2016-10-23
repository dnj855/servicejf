<?php

include('auth.php');
if ($_SESSION['css'] != 1) {
    header('index.php');
}

if (isset($_GET['journee_id']) and ! isset($_POST['technicien_id'])) { // Si l'utilisateur n'a pas rempli de formulaire.

    /* On récupère le nom de l'équipe à domicile en fonction de la journée choisie */

    $query = $bdd->prepare('SELECT nom FROM soirees_foot_equipes JOIN soirees_foot ON soirees_foot_equipes.id = soirees_foot.equipe_home WHERE id_journee = ?');
    $query->execute(array($_GET['journee_id']));
    $query = $query->fetch();
    $equipe_home = $query['nom'];

    /* On récupère ensuite le nom de l'équipe à l'extérieur, toujours pour la journée choisie */

    $query = $bdd->prepare('SELECT nom FROM soirees_foot_equipes JOIN soirees_foot ON soirees_foot_equipes.id = soirees_foot.equipe_away WHERE id_journee = ?');
    $query->execute(array($_GET['journee_id']));
    $query = $query->fetch();
    $equipe_away = $query['nom'];

    /* Et enfin on inclut le formulaire qui va bien */

    include('css_formulaire.php');
} elseif (isset($_POST['technicien_id']) and isset($_POST['pts_fcmetz']) and isset($_POST['buts_fcmetz']) and isset($_POST['buts_adversaire']) and isset($_GET['journee_id'])) { // Si l'utilisateur a rempli le formulaire, on écrit les infos dans la base...
    $_POST['buts_adversaire'] = (int) $_POST['buts_adversaire'];
    $_POST['buts_fcmetz'] = (int) $_POST['buts_fcmetz'];

    $req = $bdd->prepare('UPDATE soirees_foot SET id_technicien = :id_technicien, pts_fcmetz = :pts_fcmetz, buts_adversaire = :buts_adversaire, buts_fcmetz = :buts_fcmetz WHERE id_journee = :id_journee');
    $req->execute(array(
        'id_technicien' => $_POST['technicien_id'],
        'pts_fcmetz' => $_POST['pts_fcmetz'],
        'buts_fcmetz' => $_POST['buts_fcmetz'],
        'buts_adversaire' => $_POST['buts_adversaire'],
        'id_journee' => $_POST['id_journee']
    ));

    $req->closeCursor();
    $done = 1; // ... puis on remplit la variable $done qui permet l'affichage du message de réussite.

    /* On récupère le nom de l'équipe à domicile en fonction de la journée choisie */

    $query = $bdd->prepare('SELECT nom FROM soirees_foot_equipes JOIN soirees_foot ON soirees_foot_equipes.id = soirees_foot.equipe_home WHERE id_journee = ?');
    $query->execute(array($_GET['journee_id']));
    $query = $query->fetch();
    $equipe_home = $query['nom'];

    /* On récupère ensuite le nom de l'équipe à l'extérieur, toujours pour la journée choisie */

    $query = $bdd->prepare('SELECT nom FROM soirees_foot_equipes JOIN soirees_foot ON soirees_foot_equipes.id = soirees_foot.equipe_away WHERE id_journee = ?');
    $query->execute(array($_GET['journee_id']));
    $query = $query->fetch();
    $equipe_away = $query['nom'];

    include('css_resultats.php');
} else {
    include('css_formulaire.php');
}
?>