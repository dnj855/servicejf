<?php
if (!checkCphRegistration($bdd, $_SESSION['id'])) {
    echo '<div class="well"><p class="lead text-center">Tu n\'es pas encore inscrit, cette page ne t\'est donc pas accessible.</p><p class="text-center"><a href="cph.php?action=home">Va pronostiquer le vainqueur final pour commencer.</a></p></div>';
}
?>
<div class="col-sm-8 col-sm-offset-2">
    <div class='panel panel-primary'>
        <div class="panel-heading">
            <h4 class="panel-title">Classement provisoire</h4>
        </div>
        <?php if (!checkCphBegin($bdd)) { ?>
            <div class='panel-body'>
                <p class="lead text-center">Sur cette page, dès le début du mondial, tu pourras voir le classement provisoire des pronostiqueurs.</p>
                <p class="text-center">En attendant, tu peux réaliser tes premiers pronostics <a href="cph.php?action=set_bet">en cliquant ici</a>.</p>
            </div>
        <?php } else {
            ?>
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
        <?php } ?>
    </div>
</div>