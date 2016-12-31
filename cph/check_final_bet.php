<div class="col-sm-8 col-sm-offset-2">
    <div class="panel panel-primary">
        <div class="panel-body">
            <p class="lead text-center">Attention, ton vote est définitif.</p>
            <p>Vérifie bien que tu as choisi la bonne équipe et valide :</p>
            <form method="post">
                <div class="form-group">
                    <label for='final_bet' class="sr-only">Vainqueur final</label>
                    <select id='final_bet' name='checked_final_bet' class="form-control">
                        <option value="<?php echo $final_bet['id']; ?>"><?php echo $final_bet['team_name']; ?></option>
                        <?php
                        $teams = getCphTeams($bdd);
                        foreach ($teams as $team) {
                            ?><option value="<?php echo $team['id']; ?>"><?php echo $team['team_name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <?php if ($error == 'no_choice') { ?>
                        <span class="help-block"><span class="glyphicon glyphicon-exclamation-sign"></span> Il faut forcément choisir un vainqueur final pour s'inscrire.</span>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-check"></span> Je valide mon choix</button>
                </div>
            </form>
        </div>
    </div>
</div>