<?php
if (!$cph_include) {
    header('location:../index.php');
}
if (!checkCphRegistration($bdd, $_SESSION['id']) && !checkCphBegin($bdd)) {
    echo '<div class="well"><p class="lead text-center">Tu n\'es pas encore inscrit, cette page ne t\'est donc pas accessible.</p><p class="text-center"><a href="cph.php?action=home">Va pronostiquer le vainqueur final pour commencer.</a></p></div>';
}
?>
<div class="col-sm-8 col-sm-offset-2">
    <div class='panel panel-primary'>
        <div class="panel-heading">
            <h4 class="panel-title">Classement <?php
                if (!checkIfCphFinished($bdd)) {
                    echo "provisoire";
                } else {
                    echo "final";
                }
                ?></h4>
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
                        Points
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
                        <td><?php
                            if ($player['score'] == $score_precedent) {
                                echo '-';
                            } else {
                                echo $i;
                            }
                            ?></td>
                        <td><a href="#" data-toggle="modal" data-target="#details<?php echo $player['better_id']; ?>"><?php echo $user['prenom'] . ' ' . $user['nom']; ?></a></td>
                    <div class="modal fade" id="details<?php echo $player['better_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel"><?php echo $user['prenom'] . ' ' . $user['nom']; ?> : <?php
                                        echo $player['score'];
                                        if ($player['score'] > 1) {
                                            echo ' points';
                                        } else {
                                            echo ' point';
                                        }
                                        ?></h4>
                                </div>
                                <div class="modal-body">
                                    <?php include('details_user.php'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <td><?php
                        echo $player['score'];
                        $score_precedent = $player['score'];
                        ?>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
            </table>
        <?php } ?>
    </div>
</div>