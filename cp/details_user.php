<div class="row">
    <div class="col-sm-12 col-md-4">
        <p class="text-center h5">Pronostic</p>
        <ol>
            <?php
            $bets = getCpOrderedBets($bdd, $better['better_id']);
            $final_bet = getCpFinalBet($bdd, $better['better_id']);
            for ($ii = 0; $ii <= 1; $ii++) {
                if ($final_bet['id'] == $bets[$ii]['id']) {
                    echo '<strong>';
                }
                if ($better['duo_points'] == 5 || $better['duo_points'] == 2) {
                    if ($bets[$ii]['id'] == $results[$ii]['id']) {
                        echo '<li class="text-success">' . $bets[$ii]['prenom'] . ' ' . $bets[$ii]['nom'] . '</li>';
                    } else {
                        echo '<li class="text-warning">' . $bets[$ii]['prenom'] . ' ' . $bets[$ii]['nom'] . '</li>';
                    }
                } else {
                    echo '<li class="text-danger">' . $bets[$ii]['prenom'] . ' ' . $bets[$ii]['nom'] . '</li>';
                }
                if ($final_bet['id'] == $bets[$ii]['id']) {
                    echo '</strong>';
                }
            }
            $good_bets = $better['bet_points'] / 2;
            for ($ii = 2;; $ii++) {
                if (!$bets[$ii]['id']) {
                    break;
                }
                if ($ii >= $good_bets + 2) {
                    echo '<li>' . $bets[$ii]['prenom'] . ' ' . $bets[$ii]['nom'] . '</li>';
                } else {
                    echo '<li class="text-success">' . $bets[$ii]['prenom'] . ' ' . $bets[$ii]['nom'] . '</li>';
                }
            }
            ?>
        </ol>
    </div>
    <div class="col-sm-12 col-md-4">
        <p class="text-center h5">Résultat final</p>
        <ol>
            <?php
            foreach ($results as $result) {
                if ($result['id'] == $final_winner['id']) {
                    echo '<strong>';
                }
                echo '<li>' . $result['prenom'] . ' ' . $result['nom'] . '</li>';
                if ($result['id'] == $final_winner['id']) {
                    echo '</strong>';
                }
            }
            ?>
        </ol>
    </div>
    <div class="col-sm-12 col-md-3 well well-sm">
        <p class="text-center h5">Points (coefficient <?php echo $better['coeff_points']; ?>)</p>
        <p class="text-center">
            <?php
            if ($better['duo_points'] == 5) {
                echo 'Duo dans l\'ordre :<br> 5 x ' . $better['coeff_points'] . ' = <strong>' . $better['coeff_points'] * 5 . ' points</strong>.';
            } elseif ($better['duo_points'] == 2) {
                echo 'Duo dans le désordre :<br> 2 x ' . $better['coeff_points'] . ' = <strong>' . $better['coeff_points'] * 2 . ' points</strong>.';
            } else {
                echo 'Pas de bon duo :<br> <strong>0 point</strong>.';
            }
            ?>
        </p>
        <p class="text-center">
            Suite du classement :<br>
            <?php
            if ($good_bets <= 1) {
                echo $good_bets . ' bon candidat';
            } else {
                echo $good_bets . ' bons candidats';
            }
            echo '<br>';
            if ($good_bets == 0) {
                echo $better['bet_points'] . ' x ' . $better['coeff_points'] . ' = <strong>' . $better['bet_points'] * $better['coeff_points'] . ' point</strong>.';
            } else {
                echo $better['bet_points'] . ' x ' . $better['coeff_points'] . ' = <strong>' . $better['bet_points'] * $better['coeff_points'] . ' points</strong>.';
            }
            ?>
        </p>
        <?php if ($final_winner) { ?>
            <p class="text-center"><?php
                echo 'Vainqueur final :<br>';
                if ($better['final_points'] == 4) {
                    echo '4 x ' . $better['coeff_points'] . ' = <strong>' . $better['coeff_points'] * 4 . ' points</strong>.';
                } else {
                    echo '<strong>0 point</strong>.';
                }
                ?>
            </p>
            <?php
        }
        ?>
    </div>
</div>