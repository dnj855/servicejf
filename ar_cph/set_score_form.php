<div class="panel panel-primary">
    <div class="panel-heading">
        <h4 class="panel-title">Enregistrer un score</h4>
    </div>
    <div class="panel-body">
        <?php
        $phases = getCphPhases($bdd);
        foreach ($phases as $phase) {
            ?>
            <ul class="list-group">
                <?php
                $games = getCphGames($bdd, $phase['id']);
                foreach ($games as $game) {
                    $team_home = getCphTeams($bdd, $game['team_home']);
                    $team_away = getCphTeams($bdd, $game['team_away']);
                    $score_home = getCphGamesScore($bdd, $game['id'], 1);
                    $score_away = getCphGamesScore($bdd, $game['id'], 0);
                    ?>
                    <li class="list-group-item text-center">
                        <form method="post" class="form-inline">
                            <div class='form-group<?php
                            if ($_SESSION['alert'][$game['id']]) {
                                echo ' has-success';
                            }
                            ?>'>
                                <label class='sr-only' for='score_home'>Score de l'équipe à domicile</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><?php echo $team_home['team_name']; ?></div>
                                    <input type="number" class="form-control" id='score_home' name='score_home' placeholder="<?php
                                    if (!empty($score_home)) {
                                        echo $score_home;
                                    } else {
                                        echo 'Entrer le score';
                                    }
                                    ?>">
                                </div>
                            </div>
                            -
                            <div class='form-group<?php
                            if ($_SESSION['alert'][$game['id']]) {
                                echo ' has-success';
                            }
                            ?>'>
                                <label class='sr-only' for='score_away'>Score de l'équipe à l'extérieur</label>
                                <div class='input-group'>
                                    <input type="number" class="form-control" id='score_away' name='score_away' placeholder="<?php
                                    if (!empty($score_away)) {
                                        echo $score_away;
                                    } else {
                                        echo 'Entrer le score';
                                    }
                                    ?>">
                                    <div class="input-group-addon"><?php echo $team_away['team_name']; ?></div>
                                </div>
                            </div>
                            <input type="hidden" name='game_id' value='<?php echo $game['id']; ?>'>
                            <button class="btn btn-primary" type="submit">Enregistrer</button>
                        </form>
                    </li>
                <?php }
                ?>
            </ul>
            <?php
        }

        if ($_SESSION['alert']) {
            unset($_SESSION['alert']);
        }
        ?>
    </div>
</div>