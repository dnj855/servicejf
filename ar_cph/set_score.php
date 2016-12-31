<?php

if ($_SESSION['admin'] == 0) {
    header('location:index.php');
}

if ($_POST) {
    include ('set_score_maths.php');
    $_SESSION['alert'][$_POST['game_id']] = 1;
    include('set_score_form.php');
} else {
    include('set_score_form.php');
}
