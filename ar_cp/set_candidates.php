<?php

if ($_POST) {
    $query = $bdd->prepare("INSERT INTO cp_candidates(prenom, nom) VALUES (:prenom, :nom)");
    $query->execute(array(
        'prenom' => $_POST['prenom'],
        'nom' => $_POST['nom']
    ));
    include('set_candidates_form.php');
} elseif ($_GET['del_id']) {
    $query = $bdd->prepare("DELETE FROM cp_candidates WHERE id=:id");
    $query->execute(array(
        'id' => $_GET['del_id']
    ));
    include('set_candidates_form.php');
} else {
    include('set_candidates_form.php');
}