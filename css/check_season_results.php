<?php

if ($_SESSION['css_season'] == 0) {
    include('form.php');
} else {
    include('results.php');
}