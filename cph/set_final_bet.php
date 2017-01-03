<?php
if (!$cph_include) {
    header('location:../index.php');
}
?>

<div class="col-sm-8 col-sm-offset-2">
    <div class="panel panel-primary">
        <div class="panel-body">
            <p class="lead text-center">Dans quelques instants, tu pourras pronostiquer les matches du mondial de handball 2017.</p>
            <p>Mais avant cela, il te faut valider ton inscription au challenge en désignant l'équipe qui, d'après toi, remportera le tournoi <strong>(si tu as trouvé le bon vainqueur final, tu remporteras 5 points bonus à la fin du tournoi)</strong> :</p>
            <form method="post">
                <div class="form-group<?php
                if ($error == 'no_choice') {
                    echo ' has-error';
                }
                ?>">
                    <label for='final_bet' class="sr-only">Vainqueur final</label>
                    <select id='final_bet' name='final_bet' class="form-control">
                        <option value="">---Choisir---</option>
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
                    <button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-check"></span> Je m'inscris</button>
                </div>
            </form>
        </div>
    </div>
</div>