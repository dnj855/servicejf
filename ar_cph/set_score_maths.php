<?php

$game = getCphGame($bdd, $_POST['game_id']);
$score_home = $_POST['score_home'];
$score_away = $_POST['score_away'];
$query = $bdd->prepare('UPDATE cph_games SET score_home = :score_home, score_away = :score_away WHERE id = :id');
$query->execute(array(
    'score_home' => $score_home,
    'score_away' => $score_away,
    'id' => $game['id']
));
if ($score_home > $score_away) {
    $query = $bdd->prepare('UPDATE cph_games SET result = \'home\', winner = :team_home WHERE id = :id');
    $query->execute(array(
        'team_home' => $game['team_home'],
        'id' => $game['id']
    ));
} elseif ($score_home < $score_away) {
    $query = $bdd->prepare('UPDATE cph_games SET result = \'away\', winner = :team_away WHERE id = :id');
    $query->execute(array(
        'team_away' => $game['team_away'],
        'id' => $game['id']
    ));
} elseif ($score_home == $score_away) {
    $phase = getCphPhases($bdd, $game['game_phase']);
    if ($phase['draw']) {
        $query = $bdd->prepare('UPDATE cph_games SET result = \'draw\', winner = 0 WHERE id = :id');
        $query->execute(array(
            'id' => $game['id']
        ));
    } else {
        $query = $bdd->prepare('UPDATE cph_games SET result = \'draw\', winner = :winner WHERE id = :id');
        $query->execute(array(
            'winner' => $_POST['winner'],
            'id' => $game['id']
        ));
    }
}