<?php
$ranking = getCpRanking($bdd);
$results = getCpOrderedResults($bdd);
$final_winner = getCpFinalWinner($bdd);
?>
<div class="col-sm-12 col-md-8 col-md-offset-2">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="panel-title">Classement final</h4>
        </div>
        <table class="table table-condensed table-responsive table-bordered">
            <tr>
                <th></th>
                <th>Candidat</th>
                <th>Vainqueur final</th>
                <th>Duo de tête</th>
                <th>Suite du classement</th>
                <th>Coefficient</th>
                <th>Score total</th>
            </tr>
            <?php
            $i = 1;
            foreach ($ranking as $better) {
                ?>
                <tr<?php
                if ($better['better_id'] == $_SESSION['id']) {
                    echo ' class="active"';
                }
                ?>>
                    <td><?php
                        if ($last_points == $better['score']) {
                            echo '-';
                        } else {
                            echo $i;
                        }
                        ?> </td>
                    <td>
                        <a href='#' data-toggle='modal' data-target='#details<?php echo $better['better_id']; ?>'><?php echo $better['prenom'] . ' ' . $better['nom']; ?></a>
                        <div class="modal fade" id="details<?php echo $better['better_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel"><?php echo $better['prenom'] . ' ' . $better['nom']; ?> : <?php
                                            echo $better['score'] . ' points';
                                            ?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <?php include('details_user.php'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td><?php echo $better['final_points']; ?></td>
                    <td><?php echo $better['duo_points']; ?></td>
                    <td><?php echo $better['bet_points']; ?></td>
                    <td><?php echo $better['coeff_points']; ?></td>
                    <td><strong><?php echo $better['score']; ?></strong></td>
                </tr>
                <?php
                $i++;
                $last_points = $better['score'];
            }
            ?>
        </table>
    </div>
</div>
