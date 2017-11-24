<?php

include('auth.php');

// ci-dessous, les quelques cas où on a besoin d'inclure form.php AVANT le design (pour une redirection ultérieure)

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['form_season']) {
    include ('ci/form.php');
} elseif ($_GET['season'] == 'reset_season') {
    include ('ci/form.php');
}

include('ci/design.php');
