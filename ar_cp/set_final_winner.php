<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['final_winner'] != 0) { // Quand on revient sur la page après avoir enregistré le vainqueur final.
    $betters = getCpBetters($bdd);
    $final_result = $_POST['final_winner'];
    setCpFinalWinner($bdd, $final_result); // On enregistre le vainqueur dans la base.
    foreach ($betters as $better) {
        $final_bet = getCpFinalBet($bdd, $better['better_id']);
        if ($final_bet['id'] == $final_result) {
            setCpFinalPoints($bdd, $better['better_id'], 4); // Si le candidat avait bon, on lui donne ses 4 points.
        } else {
            setCpFinalPoints($bdd, $better['better_id'], 0); // Sinon, on enlève la valeur NULL de sa colonne.
        }
    }
} else {
    ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="panel-title">Qui a remporté l'élection ?</h4>
        </div>
        <div class="panel-body">
            <p class="text-left">Reste maintenant à entrer le nom du nouveau président de la République, pour clore le challenge :</p>
            <form method="post">
                <div class="form-group">
                    <select class="form-control" name="final_winner" id='final_winner'>
                        <option value="">--Choisir--</option>
                        <?php
                        $results = getCpOrderedResults($bdd);
                        for ($i = 0; $i <= 1; $i++) {
                            ?>
                            <option value='<?php echo $results[$i]['id']; ?>'><?php echo $results[$i]['prenom'] . ' ' . $results[$i]['nom']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
        </div>
    </div>
    <?php
}