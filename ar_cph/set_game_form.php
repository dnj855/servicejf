<div class="panel panel-primary">
    <div class="panel-heading">
        <h4 class="panel-title">Créer une affiche</h4>
    </div>
    <div class="panel-body">
        <form method="post" class='form-horizontal'>
            <div class="form-group<?php
            if ($_SESSION['alert']['team_home']) {
                echo ' has-error';
            }
            ?>">
                <label class="col-sm-3 control-label" for="team_home">Equipe à domicile :</label>
                <div class="col-sm-9">
                    <?php
                    if ($_POST['team_home']) {
                        $team = getCphTeams($bdd, $_POST['team_home']);
                        ?>
                        <select id="team_home" name="team_home" class="form-control">
                            <option value="<?php echo $team['id']; ?>"><?php echo $team['team_name']; ?></option>
                            <?php
                        } else {
                            ?>
                            <select id = "team_home" name = "team_home" class = "form-control">
                                <option value = ""> ---Choisir une équipe---</option>
                                <?php foreach ($teams as $team) {
                                    ?>
                                    <option value="<?php echo $team['id']; ?>"><?php echo $team['team_name']; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <?php if ($_SESSION['alert']['team_home']) { ?>
                            <span class="help-block">
                                <?php
                                echo $_SESSION['alert']['team_home'];
                                ?>
                            </span>
                        <?php } ?>
                </div>
            </div>
            <div class="form-group<?php
            if ($_SESSION['alert']['team_away']) {
                echo ' has-error';
            }
            ?>">
                <label class="col-sm-3 control-label" for="team_away">Equipe à l'extérieur :</label>
                <div class="col-sm-9">
                    <?php
                    if ($_POST['team_away']) {
                        $team = getCphTeams($bdd, $_POST['team_away']);
                        ?>
                        <select id="team_away" name="team_away" class="form-control">
                            <option value="<?php echo $team['id']; ?>"><?php echo $team['team_name']; ?></option>
                            <?php
                        } else {
                            ?>
                            <select id="team_away" name="team_away" class="form-control">
                                <option value="">---Choisir une équipe---</option>
                                <?php foreach ($teams as $team) { ?>
                                    <option value="<?php echo $team['id']; ?>"><?php echo $team['team_name']; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <?php if ($_SESSION['alert']['team_away']) { ?>
                            <span class="help-block">
                                <?php
                                echo $_SESSION['alert']['team_away'];
                                ?>
                            </span>
                        <?php } ?>
                </div>
            </div>
            <div class="form-group<?php
            if ($_SESSION['alert']['game_phase']) {
                echo ' has-error';
            }
            ?>">
                <label class="col-sm-3 control-label" for="game_phase">Phase de jeu :</label>
                <div class="col-sm-9">
                    <?php
                    if ($_POST['game_phase']) {
                        $phase = getCphPhases($bdd, $_POST['game_phase']);
                        ?>
                        <select id="game_phase" name="game_phase" class="form-control">
                            <option value="<?php echo $phase['id']; ?>"><?php echo $phase['game_phase']; ?></option>
                            <?php
                        } else {
                            ?>
                            <select id="game_phase" name="game_phase" class="form-control">
                                <option value="">---Choisir une phase---</option>
                                <?php foreach ($phases as $phase) { ?>
                                    <option value="<?php echo $phase['id']; ?>"><?php echo $phase['game_phase']; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <?php if ($_SESSION['alert']['game_phase']) { ?>
                            <span class="help-block">
                                <?php
                                echo $_SESSION['alert']['game_phase'];
                                ?>
                            </span>
                        <?php } ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="pull-right">
                        <a href="ar_cph.php?action=set_game" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Annuler</a>
                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Créer</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
if ($_SESSION['alert']) {
    unset($_SESSION['alert']);
}
?>
