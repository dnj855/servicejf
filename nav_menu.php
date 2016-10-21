<div class="nav">
<table class="nav_table">
<tr>
	<td>
		<img class="logo_small" src="logosmall.png" alt="logosmall"/>
	</td>
	<td class="nav_td">
		<a href="index.php">Retour à l'accueil</a> - 
		<em class="nav_strong">Challenge invité : </em>
		<?php if($_SESSION['service'] == '1') { ?>
			<a href="ci.php">saisir un invité</a> / 
		<?php } ?>
		<a href="ci_resultats.php">consulter les résultats</a> - 
		<em class="nav_strong">Challenge des soirées foot : </em> 
		<?php if($_SESSION['css'] == '1') { ?>
			<a href="css.php">saisir une soirée foot</a> / 
		<?php } ?>
		<a href="css_resultats.php">consulter les résultats</a> - 			
	<a href="bai.php">Boite à idées</a>
	</td>
</tr>
</table>
</div>