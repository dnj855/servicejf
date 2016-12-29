<?php
if ($_SESSION['admin'] == 0) {
    header('location:index.php');
}
?>

<div class = "alert alert-success alert-dismissible" role = "alert">
    <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close"><span aria-hidden = "true">&times;
        </span></button>
    L'affiche a bien été créée.
</div>

