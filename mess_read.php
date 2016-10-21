<?php
include('auth.php');
if(!isset($_GET['id'])) {
	header('location:mess.php');
}

// On va piocher les infos nécessaires dans la BDD.

$query = $bdd->prepare('SELECT * FROM mess WHERE id = ?');
$query->execute(array($_GET['id']));
$query = $query->fetch();

$auteur_id = $query['id_sender'];
$mess_titre = $query['titre'];
$mess_texte = nl2br($query['message']);

$query = $bdd->prepare('SELECT prenom FROM personnel_fbln WHERE id = ?');
$query->execute(array($auteur_id));
$query = $query->fetch();

$auteur_prenom = $query['prenom'];

$query = $bdd->prepare('UPDATE mess SET lu = 1 WHERE id = ?');
$query->execute(array($_GET['id']));
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Messagerie interne du service j&f:</title>
        <link href="design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
    <?php include('auth_menu_utilisateur.php') ?>
    <?php include('nav_menu.php') ?>   

    <div class="index">
    	<p class="titre">messagerie interne du service j&f:</p>
    	<p class="auth_modify_nom"><?php echo $mess_titre ?></p>
    	<p class="auteur_message"><?php echo 'reçu de ' . $auteur_prenom ?></p>
    	<div class="ar_personnel"><?php echo $mess_texte ?></div>
    	<div class="mess_formulaire_reponse">
    	<table class="formulaire">
    	<caption class="ar_personnel">Répondre :</caption>
    	<form class="formulaire" method="post" action="mess_traitement.php">
    	<tr><td>Ta réponse :</td>
    	<td><textarea class="formulaire" name="message" rows="10" cols="45"></textarea></td>
		</tr>
		<tr><td></td><td><input type="submit" value="Envoyer" class="envoi_formulaire"><input type="hidden" name="expediteur" value="<?php echo $_SESSION['id'] ?>"><input type="hidden" name="destinataire" value="<?php echo $auteur_id ?>"><input type="hidden" name="titre" value="RE : <?php echo $mess_titre ?>">
		</td>
		</tr>
    	</form>
    	</table>
    	</div>
	</div>
	</body>
</html>