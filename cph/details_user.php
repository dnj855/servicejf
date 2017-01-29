<div class="row">
    <div class="col-sm-2 text-center">
        <h6>Match</h6>
    </div>
    <div class="col-sm-2 text-center">
        <h6>Score du match</h6>
    </div>
    <div class="col-sm-2 text-center">
        <h6>Prono</h6>
    </div>
    <div class="col-sm-1 text-center">
        <h6>Points 1N2</h6>
    </div>
    <div class="col-sm-1 text-center">
        <h6>Points du vainqueur</h6>
    </div>
    <div class="col-sm-1 text-center">
        <h6>Points de l'écart</h6>
    </div>
    <div class="col-sm-1 text-center">
        <h6>Points du bon score</h6>
    </div>
    <div class="col-sm-1 text-center">
        <h6>Total</h6>
    </div>
</div>
<?php
$details_games = getCphPlayedGames($bdd);
$details_final_bet = getCphFinalBet($bdd, $player['better_id']);
$j = 0;
foreach ($details_games as $details_game) {
    $details_teams = getCphTeamNames($bdd, $details_game['id']);
    $details_phase = getCphPhases($bdd, $details_game['game_phase']);
    $details_points = getCphPointsByGame($bdd, $details_game['id'], $player['better_id']);
    $details_bet = getCphGamesBet($bdd, $details_game['id'], $player['better_id']);
    $details_draw = checkIfDrawPhase($bdd, $details_game['id']);
    ?>
    <div class="row<?php
    if ($j == 0) {
        echo ' bg-info';
    }
    ?>">
        <div class="col-sm-2 text-center">
            <?php echo $details_teams['home'] . ' - ' . $details_teams['away']; ?><br/>
        </div>
        <div class="col-sm-2 text-center">
            <?php
            echo $details_game['score_home'] . ' - ' . $details_game['score_away'];
            if (!$details_draw && $details_game['score_home'] == $details_game['score_away'] && $details_game['score_home'] != 0) {
                $game_winner = getCphTeams($bdd, $details_game['winner']);
                echo ' <small>(' . $game_winner['team_name'] . ')</small>';
            }
            ?>
        </div>
        <div class="col-sm-2 text-center">
            <?php
            echo $details_bet['score_home'] . ' - ' . $details_bet['score_away'];
            if (!$details_draw && $details_bet['score_home'] == $details_bet['score_away'] && $details_bet['score_home'] != 0) {
                $bet_winner = getCphTeams($bdd, $details_bet['winner']);
                echo ' <small>(' . $bet_winner['team_name'] . ')</small>';
            }
            ?>
        </div>
        <div class="col-sm-1 text-center">
            <?php echo $details_points['points_resultat']; ?>
        </div>
        <div class="col-sm-1 text-center">
            <?php
            if (!$details_draw) {
                echo $details_points['points_resultat_final'];
            } else {
                echo '/';
            }
            ?>
        </div>
        <div class="col-sm-1 text-center">
            <?php echo $details_points['points_ecart']; ?>
        </div>
        <div class="col-sm-1 text-center">
            <?php echo $details_points['points_bon_score']; ?>
        </div>
        <div class="col-sm-1 text-center">
            <?php
            $total_points = $details_points['points_resultat'] + $details_points['points_resultat_final'] + $details_points['points_ecart'] + $details_points['points_bon_score'];
            echo '<strong>' . $total_points . '</strong>';
            ?>
        </div>
    </div>
    <?php
    if ($j == 1) {
        $j = 0;
    } else {
        $j++;
    }
}
?>
<div class="row">
    <p class="h5 text-center">Pronostic de vainqueur final : <?php
        echo $details_final_bet;
        if (!checkIfCphFinished($bdd)) {
            echo ' <small>(5 points bonus sont toujours en jeu)</small>';
        } else {
            $vainqueur_final = getCphFinalWinner($bdd);
            if ($vainqueur_final['team_name'] == $details_final_bet) {
                echo ' <small>(5 points bonus remportés)</small>';
            } else {
                echo ' <small>(0 point remporté)</small>';
            }
        }
        ?></p>
</div>