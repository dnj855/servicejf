<?php

$teams = getCphTeams($bdd);
$phases = getCphPhases($bdd);

if ($_POST) {
    if (empty($_POST['team_home']) OR empty($_POST['team_away']) OR empty($_POST['game_phase'])) {
        if (empty($_POST['team_home'])) {
            $_SESSION['alert']['team_home'] = 'Tu as oublié de remplir l\'équipe à domicile.';
        }
        if (empty($_POST['team_away'])) {
            $_SESSION['alert']['team_away'] = 'Tu as oublié de remplir l\'équipe à l\'extérieur.';
        }
        if (empty($_POST['game_phase'])) {
            $_SESSION['alert']['game_phase'] = 'Tu as oublié de remplir la phase de jeu.';
        }
        include ('set_game_form.php');
    } else {
        $query = $bdd->prepare('INSERT INTO cph_games (team_home, team_away, game_phase) VALUES (:team_home, :team_away, :game_phase)');
        $query->execute(array(
            'team_home' => $_POST['team_home'],
            'team_away' => $_POST['team_away'],
            'game_phase' => $_POST['game_phase']
        ));
        include ('set_game_success.php');
    }
} else {
    include ('set_game_form.php');
}
