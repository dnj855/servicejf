<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $betters = getCpBetters($bdd);
    foreach ($betters as $better) {
        if (getCpFinalValidationDate($bdd, $better['better_id']) == 0) {
            $query = $bdd->prepare('INSERT INTO cp_definitive_bet (better_id, date) VALUES (:better_id, :date)');
            $query->execute(array(
                'better_id' => $better['better_id'],
                'date' => '2017-04-19'
            ));
        }
    }
    echo '<div class="alert alert-success">Tous les pronostics ont bien été clos.</div>';
} else {
    ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="panel-title">Attention !</h4>
        </div>
        <div class="panel-body">
            <p class="text-left">
                Si tu valides, cela rendra définitif tous les pronostics des candidats qui n'ont pas encore validé leur choix. A titre de précaution, ce bouton ne sera cliquable qu'en temps utile.
            </p>
            <p class="text-center">
                <?php if ($now < $cp_date_butoir) { ?>
                    <a href="#" class="btn btn-primary disabled">Je valide</a>
                <?php } else {
                    ?>
                <form method="post" class="text-center">
                    <button type="submit" class="btn btn-primary">Je valide</button>
                </form>
            <?php } ?>
            </p>
        </div>
    </div>
    <?php
}