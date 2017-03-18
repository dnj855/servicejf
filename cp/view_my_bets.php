<div class="col-xs-12">
    <div class="alert alert-info">
        <p>
            <?php
            $validation_date = getCpFinalValidationDate($bdd, $_SESSION['id']);
            ?>
            <strong>Tu as définitivement validé ton pronostic le <?php echo $validation_date->format('d') . ' ' . $mois[$validation_date->format('m')]; ?>.</strong>
            Tes futurs points seront donc multipliés par <?php echo getCpDatePoints($validation_date); ?>.
        </p>
    </div>
</div>
<div class="col-md-6 col-xs-12">
    <?php
    $bets = getCpOrderedBets($bdd, $_SESSION['id']);
    include('bets_review.php');
    ?>
</div>
<div class="col-md-6 col-xs-12">
    <?php include('final_bet.php'); ?>
</div>