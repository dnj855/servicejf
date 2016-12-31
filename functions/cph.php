<?php

function getCphTeams($bdd, $id = '') {
    if ($id) {
        $query = $bdd->prepare('SELECT * FROM cph_teams WHERE id = :id');
        $query->execute(array(
            'id' => $id
        ));
        return $query->fetch();
    } else {
        $query = $bdd->query('SELECT * FROM cph_teams');
        return $query->fetchAll();
    }
}

function getCphPhases($bdd, $id = '') {
    if ($id) {
        $query = $bdd->prepare('SELECT * FROM cph_game_phase WHERE id = :id');
        $query->execute(array(
            'id' => $id
        ));
        return $query->fetch();
    } else {
        $query = $bdd->query('SELECT * FROM cph_game_phase');
        return $query->fetchAll();
    }
}

function getCphGames($bdd, $phase_id) {
    $query = $bdd->prepare('SELECT * FROM cph_games WHERE game_phase = :phase_id');
    $query->execute(array(
        'phase_id' => $phase_id
    ));
    return $query->fetchAll();
}

function getCphGame($bdd, $game_id) {
    $query = $bdd->prepare('SELECT * FROM cph_games WHERE id = :id');
    $query->execute(array(
        'id' => $game_id
    ));
    return $query->fetch();
}

function getCphGamesScore($bdd, $game_id, $home) {
    if ($home == 1) {
        $query = $bdd->prepare('SELECT score_home AS score FROM cph_games WHERE id = :id');
        $query->execute(array(
            'id' => $game_id
        ));
        $score = $query->fetch();
        $query->closeCursor();
    } elseif ($home == 0) {
        $query = $bdd->prepare('SELECT score_away AS score FROM cph_games WHERE id = :id');
        $query->execute(array(
            'id' => $game_id
        ));
        $score = $query->fetch();
        $query->closeCursor();
    }
    return $score['score'];
}

function checkCphRegistration($bdd, $better_id) {
    $query = $bdd->prepare('SELECT * FROM cph_final_bet WHERE better_id = :better_id');
    $query->execute(array(
        'better_id' => $better_id
    ));
    if (!$query->fetch()) {
        return 0;
    } else {
        return 1;
    }
}

function getCphRanking($bdd) {
    $query = $bdd->query('SELECT * FROM cph_score ORDER BY score DESC');
    return $query->fetchAll();
}
