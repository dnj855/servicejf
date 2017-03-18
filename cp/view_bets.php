<?php
$betters = getCpBetters($bdd);
foreach ($betters as $better) {
    $better_id = $better['better_id'];
    ?>
    <div class="col-md-4 col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <?php
                    echo $better['prenom'] . ' ' . $better['nom'];
                    ?>
                </h4>
            </div>
            <div class="panel-body">
                <?php
                if (checkCpIfDefinitive($bdd, $better['better_id'])) {
                    $date = getCpFinalValidationDate($bdd, $better_id);
                    $points = getCpDatePoints($date);
                    echo '<p class="text-center well well-sm">définitif depuis le ' . $date->format('d') . ' ' . $mois[$date->format('m')] . ' <small>(coefficient ' . $points . ')</small></p>';
                }
                ?>
                <ol>
                    <?php
                    $bets = getCpOrderedBets($bdd, $better_id);
                    $final_bet = getCpFinalBet($bdd, $better_id);
                    foreach ($bets as $bet) {
                        if ($final_bet['id'] == $bet['id']) {
                            echo '<strong>';
                        }
                        echo '<li>' . $bet['prenom'] . ' ' . $bet['nom'];
                        echo '</li>';
                        if ($final_bet['id'] == $bet['id']) {
                            echo '</strong>';
                        }
                    }
                    ?>
                </ol>
            </div>
        </div>
    </div>
    <?php
}
