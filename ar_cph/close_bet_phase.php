<?php

if ($_POST) {
    $query = $bdd->prepare('UPDATE cph_games SET bet_open = 0 WHERE game_phase = :id');
    $query->execute(array(
        'id' => $_POST['phase_id']
    ));
    $_SESSION['alert']['success'] = 1;
    include('close_bet_phase_form.php');
} else {
    include('close_bet_phase_form.php');
}
