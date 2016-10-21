<?php
include('auth.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Messagerie interne du service j&f:</title>
		<link href="design.css" rel="stylesheet" type="text/css" />
	</head>

	<body>
		<?php include('auth_menu_utilisateur.php');
		include('nav_menu.php') ?>

		<div class="index">
			<p class="titre">messagerie interne du service j&f:</p>
			<p class="auth_modify_nom">Nombre de messages non lus : <?php echo $mess_nonlus ?></p>
<?php
			if($_GET['mess'] == 'ok') { ?>
			<p class="auth_modify_erreur">Message envoyé !</p>
<?php		} ?>
			<div class="mess_menu"><a href="mess_formulaire.php" class="mess_menu">Ecrire un nouveau message</a></div>
			<div class="ar_personnel">
			<?php
				if ($mess_nonlus != 0) { // S'il y a des messages non lus.
			?>

						<table class="mess">
						<caption class="ar_personnel">Non lu :</caption>
			<?php
						$query = $bdd->prepare('SELECT personnel_fbln.prenom, mess.id AS mess_id, mess.titre AS mess_titre FROM mess JOIN personnel_fbln ON id_sender = personnel_fbln.id WHERE lu = 0 AND id_receiver = ? ORDER BY mess.id DESC');
						$query->execute(array($_SESSION['id']));
						while($non_lu = $query->fetch()) {
						echo '<tr><td class="mess_expediteur">De ' . $non_lu['prenom'] . '</td><td class="mess_titre"><a href="mess_read.php?id=' . $non_lu['mess_id'] . '" class="mess_titre">' . $non_lu['mess_titre'] . '</a></td></tr>';
						}
						echo '</table>';

				}
				?>
						<table class="mess">
						<caption class="ar_personnel">Lu :</caption>

				<?php

				if($mess_lus != 0) { // On affiche les messages lus.
			
						$query = $bdd->prepare('SELECT personnel_fbln.prenom, mess.id AS mess_id, mess.titre AS mess_titre FROM mess JOIN personnel_fbln ON id_sender = personnel_fbln.id WHERE lu = 1 AND id_receiver = ? ORDER BY mess.id DESC');
						$query->execute(array($_SESSION['id']));
						while($non_lu = $query->fetch()) {
						echo '<tr><td class="mess_expediteur">De ' . $non_lu['prenom'] . '</td><td class="mess_titre"><a href="mess_read.php?id=' . $non_lu['mess_id'] . '" class="mess_titre">' . $non_lu['mess_titre'] . '</a></td></tr>';
						}
						echo '</table>';

				}
				else {
					echo '<tr><td colspan=3 class="mess_expediteur">Vous n\'avez aucun message déjà lu.</td></tr></table>';
				}
			?>
			</div>	
		</div>
	</body>