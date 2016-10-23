<?php

include('auth.php');
if ($_SESSION['service'] != '1') {
    header('location:index.php');
}

if (isset($_POST['identite']) AND isset($_POST['studio']) AND isset($_POST['direct']) AND isset($_POST['nom']) AND isset($_POST['caleur'])) {

    $nom = htmlspecialchars($_POST['nom']);

    if (isset($_POST['pad_obligatoire'])) {
        $pad_obligatoire = 1;
    } else {
        $pad_obligatoire = 0;
    }


    $req = $bdd->prepare('INSERT INTO challenge_invite (identite, studio, direct, nom, caleur_id, pad_obligatoire, date_invite) VALUES (:identite, :studio, :direct, :nom, :caleur, :pad_obligatoire, :date_invite)');
    $req->execute(array(
        'identite' => $_POST['identite'],
        'studio' => $_POST['studio'],
        'direct' => $_POST['direct'],
        'nom' => $nom,
        'caleur' => $_POST['caleur'],
        'pad_obligatoire' => $pad_obligatoire,
        'date_invite' => dateFrtoUs($_POST['date_invite'])
    ));


    header('location:ci_resultats.php?error=0');
} else {

    include("ci_formulaire.php");
}
?>