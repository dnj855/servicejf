<?php

include('auth.php');
if ($_SESSION['admin'] == 0) {
    header('location:index.php');
}

if ($_POST['mdp1'] == $_POST['mdp2']) {
    $pass_hashe = hash_password($_POST['mdp1']);
    $query = $bdd->prepare('UPDATE personnel_fbln SET mdp = :mdp WHERE id = :id');
    $query->execute(array(
        'mdp' => $pass_hashe,
        'id' => $_POST['id']
    ));
    header('location:ar_affichage_personnel.php?error=0');
} else {
    header('location:ar_modif_mdp_personnel.php?id=' . $_POST['id'] . '&error=1');
}
?>