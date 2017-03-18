<?php

include('auth.php');
$cp_include = 1;
if ($_GET['action']) {
    if ($_GET['action'] == 'delete_final_bet') {
        if (!checkCpIfDefinitive($bdd, $_SESSION['id'])) {
            deleteCpFinalBet($bdd, $_SESSION['id']);
            header('location:cp.php?action=home');
        } else {
            header('location:cp.php?action=home');
        }
    } elseif ($_GET['action'] == 'validate_bet') {
        validateBet($bdd, $_SESSION['id']);
        header('location:cp.php?action=home');
    } elseif ($_GET['action'] == 'delete_bet') {
        deleteCpBet($bdd, $_SESSION['id'], $_GET['rank']);
        header('location:cp.php?action=home');
    }
    include('cp/design.php');
} else {
    echo "Erreur 404.";
}