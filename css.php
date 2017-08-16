<?php

include('auth.php');

// ci-dessous, les quelques cas où on a besoin d'inclure form.php AVANT le design (pour une redirection ultérieure)

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['form_season']) {
    include ('css/form.php');
} elseif ($_GET['season'] == 'reset_season') {
    include ('css/form.php');
}

include('css/design.php');




// if (!isset($_POST['technicien_id'])) { // Si l'utilisateur n'a pas rempli de formulaire.
//
//    /* On récupère le nom de l'équipe à domicile en fonction de la journée choisie */
//
//    $equipes = getTeams($bdd, $_GET['journee_id']);
//
//    /* Et enfin on inclut le formulaire qui va bien */
//
//    include('css_formulaire.php');
//} elseif (isset($_POST['technicien_id']) and isset($_POST['pts_fcmetz']) and isset($_POST['buts_fcmetz']) and isset($_POST['buts_adversaire'])) { // Si l'utilisateur a rempli le formulaire, on écrit les infos dans la base...
//    $_POST['buts_adversaire'] = (int) $_POST['buts_adversaire'];
//    $_POST['buts_fcmetz'] = (int) $_POST['buts_fcmetz'];
//
//    $req = $bdd->prepare('UPDATE soirees_foot SET id_technicien = :id_technicien, pts_fcmetz = :pts_fcmetz, buts_adversaire = :buts_adversaire, buts_fcmetz = :buts_fcmetz WHERE id_journee = :id_journee');
//    $req->execute(array(
//        'id_technicien' => $_POST['technicien_id'],
//        'pts_fcmetz' => $_POST['pts_fcmetz'],
//        'buts_fcmetz' => $_POST['buts_fcmetz'],
//        'buts_adversaire' => $_POST['buts_adversaire'],
//        'id_journee' => $_POST['id_journee']
//    ));
//
//    $req->closeCursor();
//
//    header('location:css_resultats.php?error=0');
//} else {
//    include('css_formulaire.php');
//}