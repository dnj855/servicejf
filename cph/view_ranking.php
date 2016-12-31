<?php
if (!checkCphRegistration($bdd, $_SESSION['id'])) {
    echo '<div class="well">Cette page n\'est pas encore accessible. <a href="cph.php?action=home">Va pronostiquer le vainqueur final pour commencer.</a></div>';
}
?>
<div class="col-sm-8 col-sm-offset-2">
    <div class='panel panel-primary'>
        <div class="panel-heading">
            <h4 class="panel-title">Classement provisoire</h4>
        </div>
        <table class="table table-bordered table-condensed">
            <tr>
                <th>
                    #
                </th>
                <th>
                    Nom
                </th>
                <th>
                    Score
                </th>
            </tr>
            <?php
            $players = getCphRanking($bdd);
            $i = 1;
            foreach ($players as $player) {
                $user = getUserIdentity($bdd, $player['better_id']);
                ?>
                <tr<?php
                if ($player['better_id'] == $_SESSION['id']) {
                    echo ' class="active"';
                }
                ?>
                    >
                    <td><?php echo $i; ?></td>
                    <td><?php echo $user['prenom'] . ' ' . $user['nom']; ?></td>
                    <td><?php echo $player['score']; ?>
                </tr>
                <?php
                $i++;
            }
            ?>
        </table>
    </div>
</div>