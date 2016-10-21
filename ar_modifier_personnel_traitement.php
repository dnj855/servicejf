<?php
include('auth.php');
if($_SESSION['admin'] == 0) {
    header('location:index.php');
}

if (isset($_POST['prenom']) AND isset($_POST['nom']) AND isset($_POST['service']) AND isset($_POST['pseudo']) AND isset($_POST['cadre']) AND isset($_POST['id']))

{

	$prenom = htmlspecialchars($_POST['prenom']);
	$nom = htmlspecialchars($_POST['nom']);
	$pseudo = htmlspecialchars($_POST['pseudo']);
    $req = $bdd->prepare('UPDATE personnel_fbln SET nom = :nom, prenom = :prenom, pseudo = :pseudo, cadre = :cadre, service_id = :service, admin = :admin, css = :css WHERE id = :id');
    $req->execute(array(
    	'nom' => $nom,
    	'prenom' => $prenom,
    	'pseudo' => $pseudo,
    	'cadre' => $_POST['cadre'],
    	'service' => $_POST['service'],
    	'id' => $_POST['id'],
        'css' => $_POST['css'],
        'admin' => $_POST['admin']
    	));

    header('Location: ar_affichage_personnel.php?error=0');

}
else
{
	header('Location: ar_affichage_personnel.php?error=1');
}

?>