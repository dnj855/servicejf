<?php

include('auth.php');
$cp_include = 1;

if ($_GET['action']) {
    include('cp/design.php');
} else {
    echo "Erreur 404.";
}