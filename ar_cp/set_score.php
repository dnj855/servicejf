<?php
if ($_POST) { // Si on revient sur la page après avoir fait un pronostic, on traite.
    if ($_POST['result']) {
        setCpResult($bdd, $_POST['result'], $_POST['rank']);
    }
}
$remaining_results = checkCpIfRemainsResults($bdd);
$result_rank = (getCpCandidatesAmount($bdd)) - $remaining_results + 1;


if (!checkCpIfSecondLeg($bdd)) {
    if ($remaining_results) {
        ?>
        <div class="panel panel-primary">

            <div class="panel-heading">
                <h4 class="panel-title">Il reste <?php echo $remaining_results; ?> candidat<?php
                    if ($remaining_results != 1) {
                        echo 's';
                    }
                    ?> à classer</h4>
            </div>
            <div class="panel-body">
                <?php if ($result_rank - 1 != 0) { ?>
                    <div class="col-xs-12 col-md-6">
                        <?php
                    } else {
                        echo '<div>';
                    }
                    ?>
                    <p class="well well-sm text-center">Qui est arrivé <?php
                        echo $result_rank;
                        if ($result_rank == 1) {
                            echo 'er';
                        } else {
                            echo 'e';
                        }
                        ?>
                        ?</p>
                    <form method="post">
                        <div class="form-group">
                            <label for="result" class="sr-only">Résultat</label>
                            <select class="form-control" id='result' name="result">
                                <option value="">--Choisir--</option>
                                <?php
                                if ($result_rank - 1 != 0) {
                                    $r_results = getCpResultsWithoutAlreadySet($bdd);
                                } else {
                                    $r_results = getCpCandidates($bdd);
                                }
                                foreach ($r_results as $r_result) {
                                    echo '<option value="' . $r_result['id'] . '">' . $r_result['prenom'] . ' ' . $r_result['nom'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <p class="text-right">
                                <input type="submit" class="btn btn-primary" value="Valider">
                                <input type="hidden" name="rank" value="<?php echo $result_rank; ?>">
                            </p>
                        </div>
                    </form>
                </div>
                <?php if ($result_rank - 1 != 0) { ?>
                    <div class="col-xs-12 col-md-6">
                        <ol>
                            <?php
                            $results = getCpOrderedResults($bdd);
                            foreach ($results as $result) {
                                echo '<li>' . $result['prenom'] . ' ' . $result['nom'] . ' <a href="ar_cp.php?action=delete_result&rank=' . $result['rank'] . '"><small><em>modifier</em></small></a>';
                                echo '</li>';
                            }
                            ?>
                        </ol>
                    </div>
                <?php } ?>
            </div>

            <?php
        } else {
            $results = getCpOrderedResults($bdd);
            ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title">Si tout est bon, on valide</h4>
                </div>
                <div class="panel-body">
                    <ul class="list-inline">
                        <?php
                        $result_number = 1;
                        foreach ($results as $result) {
                            echo '<li>' . $result_number . '. ' . $result['prenom'] . ' ' . $result['nom'] . ' <a href="ar_cp.php?action=delete_result&rank=' . $result['rank'] . '">&times;</a></li>';
                            $result_number++;
                        }
                        ?>
                    </ul>
                    <p>
                        <a href="ar_cp.php?action=validate_results" class="btn btn-primary">Ok</a>
                    </p>
                </div>
            </div>
            <?php
        }
    } else {
        include('set_final_winner.php');
    }
