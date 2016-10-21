<?php
include('auth.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Bienvenue sur le portail du service j&f:</title>
        <link href="design.css" rel="stylesheet" type="text/css" />
        <link href="auth.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
<?php include('auth_menu_utilisateur.php') ?>
<?php include('nav_menu.php') ?>
<div class="index">
	<p align="center"><img src="logo.png" alt="Logo" width="500px" class="logo"></p>
	<p class="index_titre">voici les jeux en cours :</p>
	<table class="index">
		<tr>
			<td class="index_td_left">
				<p class="index_titre_td">Le challenge de l'invité</p>
			</td>
			<td class="index_td_right">
				<p class="index_titre_td">Le challenge des soirées foot</p>
			</td>
		</tr>
		<tr>	
			<td class="index_td_left">
				<p class="index_description_td">
				Direct ou PAD ? Studio ou téléphone ?<br />Le challenge de l'invité est le point fondateur du service j&f:
				</p>
				<p class="index_liens">
				<?php if($_SESSION['service'] == '1') { ?>
				<a href="ci.php">Page à remplir pour l'intervieweur</a><br />
				<?php } ?>
				<a href="ci_resultats.php">Consultation des données</a>
				</p>
			</td>
			<td class="index_td_right">
				<p class="index_description_td">
				Sur proposition du président d'honneur, voyons quel technicien porte le plus chance au FC Metz.
				</p>
				<p class="index_liens">
				<?php if($_SESSION['css'] == '1') { ?>
				<a href="css.php">La page à remplir après chaque journée de championnat</a><br />
				<?php } ?>
				<a href="css_resultats.php">Consultation des données</a>
				</p>
			</td>
		</tr>
		<tr>
			<td class="index_td_left">
				<p class="index_titre_td">Une boite à idées</p>
			</td>
			<td class="index_td_right">
			</td>
		</tr>
		<tr>
			<td class="index_td_left">	
				<p class="index_description_td">
				Toujours à l'écoute, le service j&f: vous propose de nous donner vos meilleures idées de jeux et de festivités.
				</p>
				<p class="index_liens">
				<a href="bai.php">Cliquez ici, tout simplement</a>
			</td>
			<td class="index_td_right">
			</td>
		</tr>
	</table>
</div>

</body>
</html>