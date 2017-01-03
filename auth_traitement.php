<?php

session_start();
include('auth_inc_connectdb.php');
include('functions/main.php');
include('functions/css.php');
include('functions/fg.php');
include('functions/ci.php');
include('functions/cph.php');

if (isset($_SESSION['id'])) { // On vérifie que l'utilisateur n'est pas déjà logué.
    header('location:index.php');
} elseif (isset($_POST['auth_pseudo']) AND isset($_POST['auth_mdp'])) {
    $auth_pseudo = htmlspecialchars($_POST['auth_pseudo']);

    $query = $bdd->prepare('SELECT * FROM personnel_fbln WHERE pseudo = ?');
    $query->execute(array($auth_pseudo));
    $nbr = $query->rowCount(); // On vérifie que le pseudo saisi par l'utilisateur existe bien.
    $pseudo = $query->fetch();

    if ($nbr == 0 OR $pseudo['actif'] == 0) { // Si le pseudo n'existe pas dans la BDD, on le renvoie au formulaire d'identification
        header('location:auth.php?log=nopseudo');
    } else {

        if (check_password($_POST['auth_mdp'], $pseudo['mdp'])) { // On vérifie que le mot de passe entré par l'utilisateur correspond bien à celui présent dans la BDD. Si oui, on entre les champs correspondants dans des variables de session.
            if ($_POST['cookie']) {
                setcookie('servicejfauth', $pseudo['id'], time() + 2629800);
            }

            setSessionVariables($bdd, $pseudo['id']);
            header('location:index.php');
        } else { // Si ce n'est pas le cas, on le renvoie au formulaire d'identification.
            header('location:auth.php?log=no');
        }
    }
    $query->closeCursor();
} else {
    header('location:auth.php');
}
?>