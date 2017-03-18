<li<?php
if ($_GET['action'] == 'home') {
    echo ' class="active"';
}
?>><a href="cp.php?action=home"><span class="glyphicon glyphicon-eye-open"></span> Voir le classement final</a></li>
<li<?php
if ($_GET['action'] == 'rules') {
    echo ' class="active"';
}
?>><a href="cp.php?action=rules"><span class="glyphicon glyphicon-list"></span> Lire le règlement</a></li>
