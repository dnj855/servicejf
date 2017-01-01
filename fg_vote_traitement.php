<?php

include('auth.php');

if (!isset($_GET['id'])) {
    header("location:fg.php?action=read");
} else {
    $query = $bdd->prepare("INSERT INTO fg_vote (punchline_id, voter_id, vote_date) VALUES (:punchline, :voter, NOW())");
    $query->execute(array(
        'punchline' => $_GET['id'],
        'voter' => $_SESSION['id']
    ));
    $_SESSION['message'] = "Ton vote a bien été pris en compte, merci !";

    header("location:fg.php?action=read&month=" . $now->format('m') . '&year=' . $now->format('Y'));
}