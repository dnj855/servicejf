<?php
include('auth.php');
if($_SESSION['admin'] == 0) {
    header('location:index.php');
}

if(isset($_GET['id'])) {
	$query = $bdd->prepare('UPDATE personnel_fbln SET actif = 1 WHERE id = ?');
	$query->execute(array($_GET['id']));
	header('location:ar_affichage_personnel.php?error=0');
}
else {
	header('location:ar_affichage_personnel.php?error=1');
}

?>