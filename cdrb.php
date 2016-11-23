<?php

include('auth.php');

if ($_SESSION['cdrb'] == 0 && isset($_POST['id'])) {
    $req = $bdd->prepare('INSERT INTO cdrb (id_participant, score_fcmetz, score_asnl) VALUES (:id, :score_fcmetz, :score_asnl)');
    $req->execute(array(
        'id' => $_POST['id'],
        'score_fcmetz' => $_POST['score_fcmetz'],
        'score_asnl' => $_POST['score_asnl']
    ));

    $query = $bdd->prepare('UPDATE personnel_fbln SET cdrb = 1 WHERE id = ?');
    $query->execute(array(
        $_SESSION['id']
    ));

    $_SESSION['cdrb'] = 1;
    header('location:cdrb.php');
} elseif ($_SESSION['cdrb'] == 0) {
    include ("cdrb_formulaire.php");
} else {
    include ("cdrb_pronostics.php");
}

