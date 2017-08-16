<div class="row">
    <div class="col">
        <div class="alert alert-info">
            <p class="text-right mb-0"><em>Tu n'as pas encore voté</em></p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col">
        <div class="card-deck">
            <?php
            $best_punchlines = getFgBestPunchlines($bdd);
            $i = 0;
            foreach ($best_punchlines as $month => $punchline) {
                foreach ($punchline as $id_punchline) {
                    $punchline_message = getFg($bdd, $id_punchline);
                    $datemonth = substr($punchline_message['date_message'], 5, 2);
                    $dateyear = substr($punchline_message['date_message'], 0, 4);
                    ?>
                    <div class="card border-info mb-3">
                        <div class="card-header border-info">
                            <h4 class="card-title mb-0 text-info"><?php echo ucwords($mois[$datemonth]);
                    ?></h4>
                        </div>
                        <div class="card-body">
                            <blockquote>
                                <?php echo nl2br(htmlspecialchars($punchline_message['message'])); ?>
                            </blockquote>
                        </div>
                        <div class="card-footer">

                            <form method="post" action="fg_bv.php">
                                <input type="hidden" name="id_punchline" value="<?php echo $punchline_message['id']; ?>">
                                <input type='hidden' name='vote_first' value="1">
                                <input type="submit" class="btn btn-outline-info btn-sm btn-block" value="Je vote">
                            </form>
                        </div>
                    </div>

                    <?php
                    if ($i == 2) {
                        echo '</div><div class="card-deck">';
                        $i = 0;
                    } else {
                        $i++;
                    }
                    if ($datemonth > '08' && $dateyear == '2017') {
                        break;
                    }
                }
            }
            ?>
        </div>
    </div>
</div>