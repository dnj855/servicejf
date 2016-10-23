<?php

include('auth.php'); // Comme sur toutes les pages du site, avec notamment l'include de la BDD.

if (isset($_POST['old_mdp'])) { // On vérifie que le mot de passe saisi correspond bien au mot de passe de l'utilisateur.
    $req = $bdd->prepare('SELECT mdp FROM personnel_fbln WHERE id = ?');
    $req->execute(array($_SESSION[id]));
    $mdp = $req->fetch();
    if (check_password($_POST['old_mdp'], $mdp['mdp'])) {
        $old_mdp_ok = 1;
    }
    $req->closeCursor();
}

if (isset($_POST['modify_pseudo_only'])) { // Si l'utilisateur n'a modifié que son pseudo.
    $pseudo = htmlspecialchars($_POST['modify_pseudo_only']); // On rend la donnée saisie propre.
    $_SESSION['pseudo'] = $pseudo; // On modifie la supervariable de session qui est utile ailleurs sur le site.
    $req = $bdd->prepare('UPDATE personnel_fbln SET pseudo = :pseudo WHERE id = :id'); // On écrit le nouveau pseudo dans la BDD.
    $req->execute(array(
        'pseudo' => $pseudo,
        'id' => $_SESSION['id']
    ));

    header('location:auth_modifier_utilisateur.php?log=done'); // Et on renvoie la page actuelle avec la bonne variable $_GET.
} elseif (isset($_POST['modify_pseudo']) AND isset($_POST['old_mdp']) AND isset($_POST['new_mdp_1']) AND isset($_POST['new_mdp_2'])) { // Si l'utilisateur a décidé de changer aussi son mot de passe.
    if ($_POST['new_mdp_1'] != $_POST['new_mdp_2']) { // On vérifie d'abord que l'utilisateur a bien rentré deux fois le nouveau mot de passe.
        header('location:auth_modifier_utilisateur.php?log=mdp_wrong'); // Si ce n'est pas le cas, on le renvoie avec une variable $_GET.
    } elseif ($old_mdp_ok != 1) { // Si le mot de passe saisi ne correspond pas à celui de la BDD, on ne va pas plus loin et on renvoie avec une variable $_GET.
        header('location:auth_modifier_utilisateur.php?log=noid');
    } else { // Dans tous les autres cas, on modifier la base en conséquence.
        $new_pass_hash = hash_password($_POST['new_mdp_1']);
        $req = $bdd->prepare('UPDATE personnel_fbln SET mdp = :mdp WHERE id = :id');
        $req->execute(array(
            'mdp' => $new_pass_hash,
            'id' => $_SESSION['id']
        ));
        header('location:auth_modifier_utilisateur.php?log=done'); // ET on renvoie vers la page actuelle avec la bonne variable $_GET.
    }
} else {
    include('auth_modifier_utilisateur_formulaire.php');
}
?>