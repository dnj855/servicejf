<?php
include('auth.php');
if($_SESSION['admin'] == 0) {
    header('location:index.php');
}

if(isset($_POST['mdp']) AND isset($_POST['id'])) {
	$query = $bdd->prepare('UPDATE personnel_fbln SET mdp = :mdp WHERE id = :id');
	$query->execute(array(
		'mdp' => $_POST['mdp'],
		'id' => $_POST['id']
		));
	header('location:ar_affichage_personnel.php?error=0');
}
else
{
	header('Location: ar_affichage_personnel.php?error=1');
}

?>