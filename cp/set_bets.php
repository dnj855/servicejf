<?php
if ($_POST) { // Si on revient sur la page après avoir fait un pronostic, on traite.
    if ($_POST['final_bet']) {
        setCpFinalBet($bdd, $_SESSION['id'], $_POST['final_bet']);
    } elseif ($_POST['bet']) {
        setCpBet($bdd, $_SESSION['id'], $_POST['bet'], $_POST['rank']);
    }
}
$remaining_bets = checkCpIfRemainsBets($bdd, $_SESSION['id']);
$final_bet = getCpFinalBet($bdd, $_SESSION['id']);
?>
<div class="col-md-4 col-sm-12">
    <?php
    if (!$remaining_bets && !$final_bet) {

    } else {
        include('final_bet.php');
    }
    $bets = getCpOrderedBets($bdd, $_SESSION['id']);
    if ($bets) {
        include('bets_review.php');
    }
    ?>
</div>

<div class="col-md-8 col-sm-12">
    <?php
    include('bets_form.php');

    if (!$remaining_bets && $final_bet) {

    } else {

        include('date_bonus.php');
    }
    ?>
</div>