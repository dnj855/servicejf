<?php

include('auth.php');

if (!$_GET['action']) {
    header('location:index.php');
} else {
    include('cph_design.php');
}