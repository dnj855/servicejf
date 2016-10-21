<?php
include('auth.php');
if($_SESSION['admin'] == 0) {
    header('location:index.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Consulter les messages de la boite à idées</title>
        <link href="design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
    <?php include('auth_menu_utilisateur.php') ?>
    <?php include('nav_menu.php') ?>
    <div class="index">
    <p class="titre">Consultation des messages de la boite à idées</p>
    <?php 
    //On va rappatrier les messages de la bai en formattant la date et en les classant.
    $bai = $bdd->query('SELECT auteur_id, message, DATE_FORMAT(date_message, \'le %d/%m/%Y\') AS dm FROM messages_bai ORDER BY date_message DESC LIMIT 0,30');
    while($messages = $bai->fetch()) {
    	//On va rappatrier le prénom et le nom de l'auteur du message.
    	$auteur_message = $bdd->prepare('SELECT prenom FROM personnel_fbln WHERE id = ?');
    	$auteur_message->execute(array($messages['auteur_id']));
    	$auteur_message = $auteur_message->fetch();
    	echo '<div class="ar_personnel"><p class="auteur_message">Envoyé ' . $messages['dm'] . ' par ' . $auteur_message['prenom'] . '</p>' . nl2br(htmlspecialchars($messages['message'])) . '</div>';
    }
    ?>

    </body>
    </html>