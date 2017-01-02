<?php

if (!$cph_include) {
    header('location:../index.php');
}


if ($_POST) {
    $bet = getCphGamesBet($bdd, $_POST['game_id'], $_POST['better_id']);
    if (!$bet) { // On vérifie d'abord si le match a déjà été pronostiqué. Si ça n'est pas le cas, on crée la ligne dans la bdd.
        $query = $bdd->prepare('INSERT INTO cph_bets (game_id, better_id) VALUES (:game_id, :better_id)');
        $query->execute(array(
            'game_id' => $_POST['game_id'],
            'better_id' => $_SESSION['id']
        ));
    }

// Et ensuite on irrigue la ligne (nouvellement créée ou déjà existante, peu importe).
    // D'abord on regarde si le pronostic est nul (pour remplir la colonne result).

    if ($_POST['score_home'] > $_POST['score_away']) {
        $result = 'home';
    } elseif ($_POST['score_home'] < $_POST['score_away']) {
        $result = 'away';
    } else {
        $result = 'draw';
    }

// Et ensuite on se charge de la colonne "winner".
    $draw = checkIfDrawPhase($bdd, $_POST['game_id']);
    $game = getCphGame($bdd, $_POST['game_id']);

    if ($result == 'home') {
        $winner = $game['team_home'];
    } elseif ($result == 'away') {
        $winner = $game['team_away'];
    } else {
        if ($draw) {
            $winner = 0;
        } else {
            $winner = $_POST['winner'];
        }
    }

    $query = $bdd->prepare('UPDATE cph_bets SET score_home = :score_home, score_away = :score_away, result = :result, winner = :winner WHERE game_id = :game_id AND better_id = :better_id');
    $query->execute(array(
        'score_home' => $_POST['score_home'],
        'score_away' => $_POST['score_away'],
        'result' => $result,
        'better_id' => $_SESSION['id'],
        'game_id' => $_POST['game_id'],
        'winner' => $winner
    ));
    $_SESSION['success'][$_POST['game_id']] = 1;
    include ('set_bet_design.php');
} else {
    include ('set_bet_design.php');
}
