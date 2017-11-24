<?php
if ($_GET['day']) {
    $journee = cssGetAlreadySetInfos($bdd, $_GET['day'], $_SESSION['season']);
}

if ($alerte['no-alert']) { // Si les scripts de contrôle se sont bien passés, on affiche la confirmation.
    ?>
    <div class="col-xs-12 col-sm-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="panel-title">Modifier une journée déjà remplie</h2>
            </div>
            <div class="panel-body">
                <ul class="list-inline">
                    <?php
                    $alreadySetDays = getCssAlreadySetDay($bdd, $_SESSION['season']);
                    foreach ($alreadySetDays as $day) {
                        echo '<li><a href="css.php?action=write&day=' . $day . '">' . $day . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="panel-title">Journée bien enregistrée !</h2>
            </div>
            <div class="panel-body">
                <p class="lead text-center"><span class="glyphicon glyphicon-ok-circle"></span> C'est parfait, la journée a bien été enregistrée.</p>
                <p class="text-center"><a href='css.php?action=write'>En remplir une autre</a></p>
            </div>
        </div>
    </div>
    <?php
} else { // Sinon, on affiche la page (en cas de première connection) ou les erreurs.
    ?>

    <div class="col-xs-12 col-sm-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="panel-title">Modifier une journée déjà remplie</h2>
            </div>
            <div class="panel-body">
                <ul class="list-inline">
                    <?php
                    $alreadySetDays = getCssAlreadySetDay($bdd, $_SESSION['season']);
                    foreach ($alreadySetDays as $day) {
                        echo '<li><a href="css.php?action=write&day=' . $day . '">' . $day . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="panel-title">
                    <?php
                    if (!$_GET['day']) {
                        echo 'Créer une nouvelle journée';
                    } else {
                        echo 'Modifier la journée n°' . $_GET['day'] . '<small><a href="css.php?action=write"> (ou en créer une nouvelle)</a></small>';
                    }
                    ?>
                </h2>
            </div>
            <div class="panel-body">
                <form method='post' action="css.php?action=write<?php
                if ($_GET['day']) {
                    echo '&day=' . $_GET['day'];
                }
                ?>">
                    <div class="row">
                        <div class="col-xs-12">
                            <fieldset>
                                <legend>Le réalisateur</legend>
                            </fieldset>
                            <div class="form-group<?php
                            if ($alerte['technicien_id']) {
                                echo ' has-error';
                            }
                            ?>">
                                <select name="technicien_id" id='technicien_id' class="form-control">
                                    <option value="">---Choisir---</option>
                                    <?php
                                    if ($_POST['technicien_id']) {
                                        selectCssTechnicien($bdd, $_POST['technicien_id'], 2);
                                    } else {
                                        selectCssTechnicien($bdd, $journee['id_technicien'], 2);
                                    }
                                    ?>
                                </select>
                                <?php
                                if ($alerte['technicien_id']) {
                                    echo '<span class="help-block"><span class="glyphicon glyphicon-alert"></span> Merci de préciser le prénom du réalisateur.</span>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <fieldset>
                                <legend>Le match</legend>
                                <?php if (!$_GET['day']) { ?>
                                    <div class="form-group<?php
                                    if ($alerte['day']) {
                                        echo ' has-error';
                                    }
                                    ?>">
                                        <label for="day" class="control-label">Journée numéro :</label>
                                        <select name="day" id="day" class="form-control">
                                            <option value=''>---Choisir---</option>
                                            <?php
                                            $remainingDays = getCssRemainingDays($bdd, $_SESSION['season']);
                                            foreach ($remainingDays as $day) {
                                                echo '<option value="' . $day . '"';
                                                if ($_POST['day'] == $day) {
                                                    echo ' selected';
                                                }
                                                echo '>' . $day . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php
                                        if ($alerte['day']) {
                                            echo '<span class="help-block"><span class="glyphicon glyphicon-alert"></span> Merci de remplir une journée.</span>';
                                        }
                                        ?>
                                    </div>
                                <?php } else { ?>
                                    <input type="hidden" name="day" value="<?php echo $_GET['day']; ?>">
                                <?php } ?>
                                <div class="form-group<?php
                                if ($alerte['team']) {
                                    echo ' has-error';
                                }
                                ?>">
                                    <label for="team" class="control-label">Adversaire :</label>

                                    <select name="team" id="team" class="form-control">
                                        <option value="">---Choisir---</option>
                                        <?php
                                        if ($_GET['day']) {
                                            getCssTeamsNames($bdd, $_SESSION['season'], $_GET['day']);
                                        } elseif ($_POST['team']) {
                                            getCssTeamsNamesWithPost($bdd, $_POST['team']);
                                        } else {
                                            getCssTeamsNames($bdd, $_SESSION['season']);
                                        }
                                        ?>
                                    </select>
                                    <?php
                                    if ($alerte['team']) {
                                        echo '<span class="help-block"><span class="glyphicon glyphicon-alert"></span> Merci de choisir un adversaire.</span>';
                                    }
                                    ?>
                                </div>
                                <?php
                                if ($alerte['homeOrAway']) {
                                    echo '<div class="has-error">';
                                }
                                ?>
                                <div class = "radio">
                                    <label>
                                        <input type = "radio" id = "home" name = "homeOrAway" value = "home" <?php
                                        if ($journee['equipe_home'] == 11) {
                                            echo 'checked';
                                        }
                                        ?>>
                                        À Saint-Symphorien.
                                    </label>
                                </div>
                                <div class = "radio">
                                    <label>
                                        <input type = "radio" id = "away" name = "homeOrAway" value = "away" <?php
                                        if ($journee['equipe_away'] == 11) {
                                            echo 'checked';
                                        }
                                        ?>>
                                        À l'extérieur.
                                    </label>
                                </div>
                                <?php
                                if ($alerte['homeOrAway']) {
                                    echo '</div>';
                                }
                                ?>
                            </fieldset>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <fieldset>
                                <legend>Le score</legend>
                            </fieldset>
                            <div class="form-group<?php
                            if ($alerte['buts_fcmetz']) {
                                echo ' has-error';
                            }
                            ?>">
                                <label for="buts_fcmetz" class="control-label">Score du FC Metz :</label>
                                <input type="number" value="<?php
                                if ($journee) {
                                    echo $journee['buts_fcmetz'];
                                } else {
                                    echo $_POST['buts_fcmetz'];
                                }
                                ?>" name='buts_fcmetz' id='buts_fcmetz' class="form-control">
                                       <?php
                                       if ($alerte['buts_fcmetz']) {
                                           echo '<span class="help-block"><span class="glyphicon glyphicon-alert"></span> Merci de donner un score au FC Metz.</span>';
                                       }
                                       ?>
                            </div>
                            <div class="form-group<?php
                            if ($alerte['buts_adversaire']) {
                                echo ' has-error';
                            }
                            ?>">
                                <label for="buts_adversaire" class="control-label">Score de l'adversaire :</label>
                                <input type = "number" value = "<?php
                                if ($journee) {
                                    echo $journee['buts_adversaire'];
                                } else {
                                    echo $_POST['buts_adversaire'];
                                }
                                ?>" name = 'buts_adversaire' id = 'buts_adversaire' class = "form-control">
                                       <?php
                                       if ($alerte['buts_adversaire']) {
                                           echo '<span class="help-block"><span class="glyphicon glyphicon-alert"></span> Merci de donner un score à l\'adversaire.</span>';
                                       }
                                       ?>
                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-xs-12">
                            <input type = "hidden" name = "form_journee" value = "1">
                            <button type = "submit" class = "btn btn-primary pull-right"><span class = "glyphicon glyphicon-ok"></span> Envoyer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>