<div id="auth_menu">
<p class="menu">
<strong>Bonjour <?php echo $_SESSION['prenom'] ?></strong><br />
<a href="auth_modifier_utilisateur.php" class="menu">Modifier mon compte</a><br />
<?php
if ($mess_nonlus == 0) {
	echo '<a href="mess.php" class="menu">Messagerie interne</a><br />';
}
else {
	echo '<a href="mess.php" class="menu">Messages non lus : ' . $mess_nonlus . '</a><br />';
}
if ($_SESSION['admin'] == 1) {
	echo '<a href="ar_index.php" class="menu">Administration du site</a><br /><a href="ar_affichage_personnel.php" class="menu"><em>Gestion du personnel</em></a><br /><a href="ar_bai_consult.php" class="menu"><em>Messages de la boite à idées</em></a><br />';
} ?>
<a href="auth_logout.php" class="menu">Me déconnecter</a>
</p>
</div>