<?php
include('auth.php');
if($_SESSION['admin'] == 0) {
    header('location:index.php');
}
else {

	if (isset($_POST['prenom']) AND isset($_POST['nom']) AND isset($_POST['service']) AND isset($_POST['pseudo']) AND isset($_POST['cadre']))
	{
        $prenom = htmlspecialchars($_POST['prenom']); // On rend propre les valeurs saisies.
        $nom = htmlspecialchars($_POST['nom']);
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = htmlspecialchars($_POST['mdp']);
        $_POST['service'] = (int) $_POST['service'];

        $ajout_personnel = $bdd->prepare('INSERT INTO personnel_fbln (nom, prenom, service_id, pseudo, cadre, css, mdp, admin, actif) VALUES (:nom, :prenom, :service, :pseudo, :cadre, :css, :mdp, :admin, 1)');

        $ajout_personnel->execute(array(
        	'nom' => $nom,
        	'prenom' => $prenom,
        	'pseudo' => $pseudo,
        	'cadre' => $_POST['cadre'],
        	'service' => $_POST['service'],
            'mdp' => $mdp,
            'css' => $_POST['css'],
            'admin' => $_POST['admin'],
        	));

        $ajout_personnel->closeCursor();

	}

	header('Location:ar_affichage_personnel.php');
}
?>