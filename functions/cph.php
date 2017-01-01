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

function getCphGamesBet($bdd, $game_id, $better_id) {
    $query = $bdd->prepare('SELECT * FROM cph_bets WHERE better_id = :better_id AND game_id = :game_id');
    $query->execute(array(
        'game_id' => $game_id,
        'better_id' => $better_id
    ));
    $bet = $query->fetch();
    $query->closeCursor();
    return $bet;
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

function checkCphBegin($bdd) {
    $query = $bdd->query('SELECT * FROM cph_points');
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

function checkIfDrawPhase($bdd, $game_id) {
    $game = getCphGame($bdd, $game_id);
    $phase = getCphPhases($bdd, $game['game_phase']);
    if ($phase['draw']) {
        return 1;
    } else {
        return 0;
    }
}

function checkIfFinalGame($bdd, $game_id) {
    $game = getCphGame($bdd, $game_id);
    $phase = getCphPhases($bdd, $game['game_phase']);
    if ($phase['final']) {
        return 1;
    } else {
        return 0;
    }
}

function getCphTeamNames($bdd, $game_id) {
    $team_name = array();
    $query = $bdd->prepare('SELECT t.team_name FROM cph_teams t LEFT JOIN cph_games g ON g.team_home = t.id WHERE g.id = :game_id');
    $query->execute(array(
        'game_id' => $game_id
    ));
    $team_home = $query->fetch();
    $team_name['home'] = $team_home['team_name'];
    $query = $bdd->prepare('SELECT t.team_name FROM cph_teams t LEFT JOIN cph_games g ON g.team_away = t.id WHERE g.id = :game_id');
    $query->execute(array(
        'game_id' => $game_id
    ));
    $team_away = $query->fetch();
    $team_name['away'] = $team_away['team_name'];
    return $team_name;
}

function getCphAllBetters($bdd) {
    $query = $bdd->query('SELECT better_id FROM cph_score ORDER BY score');
    return $query->fetchAll();
}

function getCphFinalBet($bdd, $better_id) {
    $query = $bdd->prepare('SELECT t.team_name AS team FROM cph_teams t INNER JOIN cph_final_bet f ON f.final_bet = t.id WHERE better_id = :better_id');
    $query->execute(array(
        'better_id' => $better_id
    ));
    $final_bet = $query->fetch();
    return $final_bet['team'];
}

function getCphIdFinalBet($bdd, $better_id) {
    $query = $bdd->prepare('SELECT final_bet FROM cph_final_bet WHERE better_id = :better_id');
    $query->execute(array(
        'better_id' => $better_id
    ));
    $final_bet = $query->fetch();
    return $final_bet['final_bet'];
}

function getCphPlayedGames($bdd) {
    $query = $bdd->query('SELECT * FROM cph_games WHERE result IS NOT NULL');
    return $query->fetchAll();
}

function checkCphPointsByGame($bdd, $game_id, $better_id) {
    $query = $bdd->prepare('SELECT * FROM cph_points WHERE better_id = :better_id AND game_id = :game_id');
    $query->execute(array(
        'better_id' => $better_id,
        'game_id' => $game_id
    ));
    if ($query->fetch()) {
        return 1;
    } else {
        return 0;
    }
}

function setCphPointsByGame($bdd, $game_id, $better_id) {
    $query = $bdd->prepare('INSERT INTO cph_points (better_id, game_id) VALUES (:better_id, :game_id)');
    $query->execute(array(
        'game_id' => $game_id,
        'better_id' => $better_id
    ));
    return 1;
}

function updatePointsByGame($bdd, $game_id, $better_id, $points_resultat, $points_resultat_final, $points_ecart, $points_bon_score) {
    $query = $bdd->prepare('UPDATE cph_points SET points_resultat = :points_resultat, points_resultat_final = :points_resultat_final, points_ecart = :points_ecart, points_bon_score = :points_bon_score WHERE better_id = :better_id AND game_id = :game_id');
    $query->execute(array(
        'points_resultat' => $points_resultat,
        'points_resultat_final' => $points_resultat_final,
        'points_ecart' => $points_ecart,
        'points_bon_score' => $points_bon_score,
        'better_id' => $better_id,
        'game_id' => $game_id
    ));
    return 1;
}

function updateCphRanking($bdd) {
    $betters = getCphAllBetters($bdd);
    foreach ($betters as $better) { // D'abord on récupère les points inscrits dans chaque domaine.
        $query = $bdd->prepare('SELECT SUM(points_resultat) AS somme FROM cph_points WHERE better_id = :better_id');
        $query->execute(array(
            'better_id' => $better['better_id']
        ));
        $temp_points = $query->fetch();
        $query->closeCursor();
        $points_resultat = $temp_points['somme'];
        $query = $bdd->prepare('SELECT SUM(points_resultat_final) AS somme FROM cph_points WHERE better_id = :better_id');
        $query->execute(array(
            'better_id' => $better['better_id']
        ));
        $temp_points = $query->fetch();
        $query->closeCursor();
        $points_resultat_final = $temp_points['somme'];
        $query = $bdd->prepare('SELECT SUM(points_ecart) AS somme FROM cph_points WHERE better_id = :better_id');
        $query->execute(array(
            'better_id' => $better['better_id']
        ));
        $temp_points = $query->fetch();
        $query->closeCursor();
        $points_ecart = $temp_points['somme'];
        $query = $bdd->prepare('SELECT SUM(points_bon_score) AS somme FROM cph_points WHERE better_id = :better_id');
        $query->execute(array(
            'better_id' => $better['better_id']
        ));
        $temp_points = $query->fetch();
        $query->closeCursor();
        $points_bon_score = $temp_points['somme'];
        $query = $bdd->prepare('SELECT SUM(points_final) AS somme FROM cph_points WHERE better_id = :better_id');
        $query->execute(array(
            'better_id' => $better['better_id']
        ));
        $temp_points = $query->fetch();
        $query->closeCursor();
        $points_final = $temp_points['somme'];
        $score = $points_resultat + $points_resultat_final + $points_ecart + $points_bon_score + $points_final; // On additionne tout.
        $query = $bdd->prepare('UPDATE cph_score SET score = :score WHERE better_id = :better_id');
        $query->execute(array(
            'score' => $score,
            'better_id' => $better['better_id']
        ));
    }
    return 1;
}
