<div class="panel panel-primary">
    <div class="panel-heading">
        <h4 class="panel-title">Mon pronostic pour le premier tour</h4>
    </div>
    <div class="panel-body">
        <ol>
            <?php
            $final_bet = getCpFinalBet($bdd, $_SESSION['id']);
            foreach ($bets as $bet) {
                if ($final_bet['id'] == $bet['id']) {
                    echo '<strong>';
                }
                echo '<li>' . $bet['prenom'] . ' ' . $bet['nom'];
                if (!checkCpIfDefinitive($bdd, $_SESSION['id'])) {
                    echo ' <a href="cp.php?action=delete_bet&rank=' . $bet['bet_rank'] . '"><small><em>modifier</em></small></a>';
                }
                echo '</li>';
                if ($final_bet['id'] == $bet['id']) {
                    echo '</strong>';
                }
            }
            ?>
        </ol>
    </div>
</div>