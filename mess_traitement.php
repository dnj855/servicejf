<?php

include('auth.php');

if (isset($_POST['destinataire']) and isset($_POST['message']) and isset($_POST['titre']) and isset($_POST['expediteur'])) {
    $query = $bdd->prepare('INSERT INTO mess (id_sender, id_receiver, message, titre, lu, date_message) VALUES (:id_sender, :id_receiver, :message, :titre, 0, NOW())');
    $message = htmlspecialchars($_POST['message']);
    $titre = htmlspecialchars($_POST['titre']);
    $query->execute(array(
        'id_sender' => $_POST['expediteur'],
        'id_receiver' => $_POST['destinataire'],
        'message' => $message,
        'titre' => $titre
    ));
    header('location:mess_lus.php?mess=ok');
} else {
    header('location:mess_lus.php');
}