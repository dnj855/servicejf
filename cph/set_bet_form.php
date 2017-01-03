<?php
$phases = getCphPhases($bdd);

if (!$cph_include) {
    header('location:../index.php');
}

foreach ($phases as $phase) {
    ?>
    <ul class="list-group">
        <?php
        $games = getCphGames($bdd, $phase['id']);
        foreach ($games as $game) {
            $team_home = getCphTeams($bdd, $game['team_home']);
            $team_away = getCphTeams($bdd, $game['team_away']);
            $bet = getCphGamesBet($bdd, $game['id'], $_SESSION['id']);
            $bet_open = $game['bet_open'];
            ?>
            <li class="list-group-item">
                <p><?php
                    echo $phase['game_phase'];
                    if (!$bet_open) {
                        echo ' <em>(phase de pronostics close)</em>';
                    }
                    ?></p>
                <form method="post">
                    <fieldset<?php
                    if (!$bet_open) {
                        echo ' disabled';
                    }
                    if ($_SESSION['success'][$game['id']]) {
                        echo ' class="has-success"';
                    }
                    ?>>
                        <div class='form-group'>
                            <label class='sr-only' for='score_home'>Score de l'équipe à domicile</label>
                            <div class="input-group">
                                <div class="input-group-addon"><?php echo $team_home['team_name']; ?></div>
                                <input type="number" class="form-control" id='score_home' name='score_home' <?php
                                if (!empty($bet['score_home'])) {
                                    echo 'value="' . $bet['score_home'] . '"';
                                } else {
                                    echo 'placeholder="Entrer le score"';
                                }
                                ?>>
                            </div>
                        </div>
                        <div class='form-group'>
                            <label class='sr-only' for='score_away'>Score de l'équipe à l'extérieur</label>
                            <div class='input-group'>
                                <div class="input-group-addon"><?php echo $team_away['team_name']; ?></div>
                                <input type="number" class="form-control" id='score_away' name='score_away' <?php
                                if (!empty($bet['score_away'])) {
                                    echo 'value="' . $bet['score_away'] . '"';
                                } else {
                                    echo 'placeholder="Entrer le score"';
                                }
                                ?>>
                            </div>
                        </div>
                        <?php if (!$phase['draw'] && $bet['score_home'] == $bet['score_away'] && $bet['score_home']) { ?>
                            <div class='form-group'>
                                <label for="winner" class="sr-only">Vainqueur (en cas de match nul)</label>

                                <?php
                                if ($bet['winner']) {
                                    $winner = getCphTeams($bdd, $bet['winner'])
                                    ?>
                                    <strong>Vainqueur :</strong> <?php
                                    echo $winner['team_name'];
                                } else {
                                    ?>
                                    <select name="winner" class="form-control">
                                        <option value=''>---Vainqueur---</option>
                                        <option value="<?php echo $team_home['id']; ?>"><?php echo $team_home['team_name']; ?></option>
                                        <option value="<?php echo $team_away['id']; ?>"><?php echo $team_away['team_name']; ?></option>
                                    </select>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <div class="form-group text-right">
                            <input type="hidden" name='game_id' value='<?php echo $game['id']; ?>'>
                            <input type='hidden' name='better_id' value='<?php echo $_SESSION['id']; ?>'>
                            <button class="btn btn-primary" type="submit">Enregistrer</button>
                        </div>
                    </fieldset>
                </form>
            </li>
        <?php }
        ?>
    </ul>
    <?php
}

if ($_SESSION['success']) {
    unset($_SESSION['success']);
}
?>