<?php

session_start();
include('auth_inc_connectdb.php');

if(isset($_SESSION['id'])) { // On vérifie que l'utilisateur n'est pas déjà logué.
	header('location:index.php');
}
elseif(isset($_POST['auth_pseudo']) AND isset($_POST['auth_mdp'])) {
	$auth_pseudo = htmlspecialchars($_POST['auth_pseudo']);
	$auth_mdp = htmlspecialchars($_POST['auth_mdp']);
	/* On vérifie que l'utilisateur a bien saisi des données, puis on les traite pour enlever les éventuelles balises html */

	$query = $bdd->prepare('SELECT * FROM personnel_fbln WHERE pseudo = ?');
	$query->execute(array($auth_pseudo));
	$nbr = $query->rowCount(); // On vérifie que le pseudo saisi par l'utilisateur existe bien.
	$pseudo = $query->fetch();

	if($nbr == 0 OR $pseudo['actif'] == 0) { // Si le pseudo n'existe pas dans la BDD, on le renvoie au formulaire d'identification
		header('location:auth.php?log=nopseudo');
	}	
	else {

		if ($pseudo['mdp'] == $auth_mdp) { // On vérifie que le mot de passe entré par l'utilisateur correspond bien à celui présent dans la BDD. Si oui, on entre les champs correspondants dans des variables de session.
			$_SESSION['id'] = $pseudo['id'];
			$_SESSION['prenom'] = $pseudo['prenom'];
			$_SESSION['nom'] = $pseudo['nom'];
			$_SESSION['admin'] = $pseudo['admin'];
			$_SESSION['service'] = $pseudo['service_id'];
			$_SESSION['css'] = $pseudo['css'];
			header('location:auth.php?log=yes');
		}
		else { // Si ce n'est pas le cas, on le renvoie au formulaire d'identification.
			header('location:auth.php?log=no');
		}

	}
	$query->closeCursor();
}
else {
	header('location:auth.php');
}

?>