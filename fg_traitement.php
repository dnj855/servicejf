<?php

include('auth.php');

if (!$_POST) {
    header('location:index.php');
} else {
    if (!$_POST['date_message']) {
        $date = new DateTime();
        $date = $date->format('Y-m-d 00:00:00');
    } else {
        $date = dateFrtoUs($_POST['date_message']);
    }
    $request = $bdd->prepare('INSERT INTO fg(message, sender, date_message) VALUES(:message, :sender_id, :date_message)');
    $request->execute(array(
        'message' => $_POST['message'],
        'sender_id' => $_POST['sender_id'],
        'date_message' => $date
    ));
    header('location:fg.php?action=read&month=' . $now->format('m') . '&year=' . $now->format('Y'));
}