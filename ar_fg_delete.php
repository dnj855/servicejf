<?php

include('auth.php');
if ($_SESSION['admin'] != 1) {
    header('location:index.php');
}
$request = $bdd->prepare('UPDATE fg SET valid = 0 WHERE id = :id');
$request->execute(array(
    'id' => $_GET['id']
));
header('location:fg.php?action=read&month=' . $now->format('m') . '&year=' . $now->format('Y'));
