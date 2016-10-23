<?php

session_start();
include('auth_inc_connectdb.php');
include('fonctions.php');

if (isset($_SESSION['id'])) { // On regarde d'abord si l'utilisateur est déjà loggé. Auquel cas, on continue le chargement de la page.
// On va récupérer le nombre de messages non lus et lus.
    $query = $bdd->prepare('SELECT COUNT(lu) AS mess_nonlus FROM mess WHERE id_receiver = ? AND lu = 0 GROUP BY id_receiver');
    $query->execute(array($_SESSION['id']));
    $mess_nonlus = $query->fetch();
    $mess_nonlus = $mess_nonlus['mess_nonlus'];
    $query = $bdd->prepare('SELECT COUNT(lu) AS mess_lus FROM mess WHERE id_receiver = ? AND lu = 1');
    $query->execute(array($_SESSION['id']));
    $mess_lus = $query->fetch();
    $mess_lus = $mess_lus['mess_lus'];
} elseif ($_COOKIE['servicejfauth']) { // On regarde ensuite si l'utilisateur n'a pas un cookie de connection.
    setSessionVariables($bdd, $_COOKIE['servicejfauth']);   //Si c'est le cas, on réinitialise ses variables de session et on continue le chargement de la page.
} elseif (isset($_GET['log'])) {
    include('auth_formulaire.php');
} else {
    header('location:auth.php?log=new');
}
?>