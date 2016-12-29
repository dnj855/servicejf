<div class="panel panel-primary">
    <div class="panel-heading">
        <h4 class="panel-title">Clore une phase de pronostics</h4>
    </div>
    <div class="panel-body">
        <?php if ($_SESSION['alert']['success']) { ?>
            <div class = "alert alert-success alert-dismissible" role = "alert">
                <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close"><span aria-hidden = "true">&times;
                    </span></button>
                Phase de pronostics close.
                <?php
                unset($_SESSION['alert']);
                ?>
            </div>
            <?php
        }
        ?>
        <form method="post">
            <div class="form-group">
                <label for='game_phase'>Phase de pronostics à clore :</label>
                <select class="form-control" name='phase_id'>
                    <?php
                    $phases = getCphPhases($bdd);
                    foreach ($phases as $phase) {
                        ?>
                        <option value="<?php echo $phase['id']; ?>"><?php echo $phase['game_phase']; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-remove-sign"></span> Clore</button>
        </form>
    </div>
</div>