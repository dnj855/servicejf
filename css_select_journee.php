	<?php
	include('auth.php');
	?>

	<!DOCTYPE html>
	<html>
    <head>
        <meta charset="utf-8" />
        <title>Le challenge des soirées sport du service j&f:</title>
        <link href="design.css" rel="stylesheet" type="text/css" />
    </head>
	<body>
	<?php include('auth_menu_utilisateur.php');
	include('nav_menu.php') ?>
	<div class="index">
	<p class="titre">le challenge des soirées foot du service j&f:</p>
	<p class="auth_modify_nom">Choisir la journée à remplir</p>
	<div class="css_select_journee">
	<table class="formulaire">
	<tr>
	<td class="css_select_journee_left">Phase aller</td>
	<td class="css_select_journee_right">Phase retour</td>
	</tr>
	<tr>
	<td class="css_select_journee_left">

<?php	

	for($i = 1; $i <= 19; $i++) {
		echo '<a href="css.php?journee_id=' . $i . '" class="css_select_journee">Journée n°' . $i . '</a><br/>';
	}

?>
	
	</td>
	<td class="css_select_journee_right">

<?php

	for($i = 20; $i <= 38; $i++) {
		echo '<a href="css.php?journee_id=' . $i . '" class="css_select_journee">Journée n°' . $i . '</a><br/>';
	}	

?>

	</td>
	</tr>
	</table>
	</div>
	</div>
	</body>
	</html>