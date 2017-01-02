<?php

include('auth.php');
$cph_include = 1;

if (!$_GET['action']) {
    header('location:index.php');
} else {
    include('cph/design.php');
}