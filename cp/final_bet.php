<div class="panel panel-primary">
    <div class="panel-heading">
        <h4 class="panel-title">Mon pronostic de vainqueur final</h4>
    </div>
    <div class="panel-body">
        <?php
        $final_bet = getCpFinalBet($bdd, $_SESSION['id']);
        if ($final_bet) {
            ?>
            <p class="well well-sm text-center"><?php echo $final_bet['prenom'] . ' ' . $final_bet['nom']; ?></p>
            <?php if (!checkCpIfDefinitive($bdd, $_SESSION['id'])) { ?>
                <p class = "text-right"><a href = "cp.php?action=delete_final_bet" class = "btn btn-primary">Modifier</a></p>
                <?php
            }
        } else {
            ?>
            <form method="post">
                <div class="form-group">
                    <label for='final_bet' class="sr-only">Vainqueur final :</label>
                    <select class="form-control" id='final_bet' name="final_bet">
                        <option value="">--Choisir--</option>
                        <?php
                        $select_final_bet = getCpCandidates($bdd);
                        foreach ($select_final_bet as $candidate) {
                            echo '<option value="' . $candidate['id'] . '">' . $candidate['prenom'] . ' ' . $candidate['nom'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group text-right">
                    <input type="submit" class="btn btn-primary" value="Valider">
                </div>
            </form>
            <?php
        }
        ?>
    </div>
</div>
