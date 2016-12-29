<?php

if ($_SESSION['admin'] == 0) {
    header('location:index.php');
}

if ($_POST) {
    $query = $bdd->prepare('UPDATE cph_games SET score_home = :score_home, score_away = :score_away WHERE id = :id');
    $query->execute(array(
        'score_home' => $_POST['score_home'],
        'score_away' => $_POST['score_away'],
        'id' => $_POST['game_id']
    ));
    $_SESSION['alert'][$_POST['game_id']] = 1;
    include('set_score_form.php');
} else {
    include('set_score_form.php');
}
