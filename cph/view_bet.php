<?php

if (!checkCphRegistration($bdd, $_SESSION['id'])) {
    echo '<div class="well">Cette page n\'est pas encore accessible. <a href="cph.php?action=home">Va pronostiquer le vainqueur final pour commencer.</a></div>';
}