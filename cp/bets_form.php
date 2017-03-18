<?php
if (!$remaining_bets && $final_bet) {
    ?>
    <div class="panel panel-primary">
        <div class="panel-body">
            <h4>Tu as fini ton pronostic. Si tu es satisfait, tu peux le valider définitivement.<br/>
                <small>Cela permettra de multiplier tes points par <?php echo getCpDatePoints(); ?>.</small></h4>
            <p class="text-center"><a href="cp.php?action=validate_bet" class="btn btn-success btn-lg">Je valide</a></p>
        </div>
    </div>
    <?php
} elseif (!$remaining_bets && !$final_bet) {
    include('final_bet.php');
} else {
    ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="panel-title">Enregistrer mes pronostics</h4>
        </div>
        <div class="panel-body">
            <p class="text-center lead">Il te reste encore <?php echo $remaining_bets; ?> candidat<?php if ($remaining_bets != 1) { ?>s<?php } ?> à classer.</p>
            <p class="text-center">Qui vois-tu arriver en <?php
                $bet_rank = (getCpCandidatesAmount($bdd)) - $remaining_bets + 1;
                echo $bet_rank;
                if ($bet_rank == 1) {
                    echo 'ère';
                } else {
                    echo 'e';
                }
                ?>
                position au premier tour ?
            </p>
            <form method="post">
                <div class="form-group">
                    <label for="bet" class="sr-only">Mon pronostic</label>
                    <select class="form-control" id='bet' name="bet">
                        <option value="">--Choisir--</option>
                        <?php
                        if ($bet_rank - 1 != 0) {
                            $r_bets = getCpCandidatesWithoutAlreadyBet($bdd, $_SESSION['id']);
                        } else {
                            $r_bets = getCpCandidates($bdd);
                        }
                        foreach ($r_bets as $r_bet) {
                            echo '<option value="' . $r_bet['id'] . '">' . $r_bet['prenom'] . ' ' . $r_bet['nom'] . '</option>';
                        }
                        ?>
                    </select>
                    <span class="help-block"><span class="glyphicon glyphicon-info-sign"></span> Tes pronostics sont automatiquement sauvegardés. Cela signifie que tu peux les laisser de côté et revenir plus tard si tu souhaites encore patienter.</span>
                </div>
                <div class="form-group">
                    <p class="text-right">
                        <input type="submit" class="btn btn-primary" value="Valider">
                        <input type="hidden" name="rank" value="<?php echo $bet_rank; ?>">
                    </p>
                </div>
            </form>
        </div>
    </div>
    <?php
}