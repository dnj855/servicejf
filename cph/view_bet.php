<?php
if (!$cph_include) {
    header('location:../index.php');
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
                $players = getCphRanking($bdd);
                foreach ($players as $player) {
                    $user = getUserIdentity($bdd, $player['better_id']);
                    ?>
                    <tr>
                        <td> <a href="#" data-toggle="modal" data-target="#details<?php echo $player['better_id']; ?>"><?php echo $user['prenom'] . ' ' . $user['nom']; ?></a><br/><em>(<?php echo getCphFinalBet($bdd, $player['better_id']); ?>)</em></td>
                    <div class="modal fade" id="details<?php echo $player['better_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel"><?php echo $user['prenom'] . ' ' . $user['nom']; ?> : <?php
                                        echo $player['score'];
                                        if ($player['score'] > 1) {
                                            echo ' points';
                                        } else {
                                            echo ' point';
                                        }
                                        ?></h4>
                                </div>
                                <div class="modal-body">
                                    <?php include('details_user.php'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    foreach ($gameArray as $game_id) {
                        $bet = getCphGamesBet($bdd, $game_id, $player['better_id']);
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