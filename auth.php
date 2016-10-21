<?php
session_start();
include('auth_inc_connectdb.php');

// On va récupérer le nombre de messages non lus.
$query = $bdd->prepare('SELECT COUNT(lu) AS mess_nonlus FROM mess WHERE id_receiver = ? AND lu = 0');
$query->execute(array($_SESSION['id']));
$mess_nonlus = $query->fetch();
$mess_nonlus = $mess_nonlus['mess_nonlus'];
$query = $bdd->prepare('SELECT COUNT(lu) AS mess_lus FROM mess WHERE id_receiver = ? AND lu = 1');
$query->execute(array($_SESSION['id']));
$mess_lus = $query->fetch();
$mess_lus = $mess_lus['mess_lus'];


if($_GET['log'] == 'yes') { // On regarde si l'utilisateur vient juste de se logger, auquel cas, on renvoie vers l'index.
	header('location:index.php');
}
elseif(isset($_SESSION['id'])) { // Dans tous les autres cas de figure, on regarde d'abord si l'utilisateur est déjà loggé. Auquel cas, on continue le chargement de la page.
}
elseif(isset($_GET['log'])) {
	include('auth_formulaire.php');
}
else {
	header('location:auth.php?log=new');
}
?>