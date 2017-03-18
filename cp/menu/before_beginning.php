<li<?php
if ($_GET['action'] == 'home') {
    echo ' class="active"';
}
?>><a href="cp.php?action=home"><span class="glyphicon glyphicon-home"></span> Accueil du challenge</a></li>
<li<?php
if ($_GET['action'] == 'rules') {
    echo ' class="active"';
}
?>><a href="cp.php?action=rules"><span class="glyphicon glyphicon-list"></span> Lire le règlement</a></li>