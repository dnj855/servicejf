<li<?php
if ($_GET['action'] == 'view_my_bets') {
    echo ' class="active"';
}
?>><a href="cp.php?action=view_my_bets"><span class="glyphicon glyphicon-pencil"></span> Revoir mes pronostics</a></li>
<li<?php
if ($_GET['action'] == 'home') {
    echo ' class="active"';
}
?>><a href="cp.php?action=home"><span class="glyphicon glyphicon-eye-open"></span> Voir tous les pronostics</a></li>
<li<?php
if ($_GET['action'] == 'rules') {
    echo ' class="active"';
}
?>><a href="cp.php?action=rules"><span class="glyphicon glyphicon-list"></span> Lire le règlement</a></li>
