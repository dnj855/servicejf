<?php
if (!checkCphRegistration($bdd, $_SESSION['id'])) {
    echo '<div class="well"><p class="lead text-center">Tu n\'es pas encore inscrit, cette page ne t\'est donc pas accessible.</p><p class="text-center"><a href="cph.php?action=home">Va pronostiquer le vainqueur final pour commencer.</a></p></div>';
}
$phases = getCphPhases($bdd);
?>
<section class="col-sm-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="panel-title">Voir tous les pronostics</h4>
        </div>
        <div class="table-responsive">
            <table class="table table-condensed table-striped">
                <tr>
                    <th></th>
                    <?php
                    foreach ($phases as $phase) {
                        $games = getCphGames($bdd, $phase['id']);
                        foreach ($games as $game) {
                            $teams = getCphTeamNames($bdd, $game['id']);
                            $gameArray[] = $game['id']; // Dans cet array, on stocke les matches dans l'ordre des phases de jeu pour pouvoir les réafficher correctement dans le reste du tableau.
                            echo '<th class="text-center">' . $teams['home'] . ' - ' . $teams['away'] . '<br/>' . $phase['game_phase'] . '</th>';
                        }
                    }
                    ?>
                </tr>
                <?php
                $betters = getCphAllBetters($bdd);
                foreach ($betters as $better) {
                    $better_identity = getUserIdentity($bdd, $better['better_id']);
                    ?>
                    <tr>
                        <td><?php echo $better_identity['prenom'] . ' ' . $better_identity['nom']; ?><br/><em>(<?php echo getCphFinalBet($bdd, $better['better_id']); ?>)</em></td>
                        <?php
                        foreach ($gameArray as $game_id) {
                            $bet = getCphGamesBet($bdd, $game_id, $better['better_id']);
                            echo '<td class="text-center">' . $bet['score_home'] . ' - ' . $bet['score_away'];
                            if (!checkIfDrawPhase($bdd, $game_id) && $bet['score_home'] == $bet['score_away'] && $bet['score_home'] != 0) {
                                $winner = getCphTeams($bdd, $bet['winner']);
                                echo '<br/><em>' . $winner['team_name'] . '</em>';
                            }
                            echo '</td>';
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
</section>