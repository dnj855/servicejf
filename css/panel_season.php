<?php

echo '<div class="well well-sm text-right">';
echo '<em>Saison en cours de ';
if ($_GET['action'] == 'write') {
    echo 'modification';
} elseif ($_GET['action'] == 'read') {
    echo 'consultation';
}
echo ' : ';
echo getCssSeason($bdd, $_SESSION['css_season']) . ' ';
echo '<a href="css.php?action=' . $_GET['action'] . '&season=reset_season"><small>(modifier)</small></a>'; // le lien de réinitialisation de saison
echo '</em>';
echo '</div>';
