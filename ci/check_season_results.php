<?php

if ($_SESSION['season'] == 0) {
    include('form.php');
} else {
    include('results.php');
}