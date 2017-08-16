<?php
$seasons = getCssSeasons($bdd);
$new_season['saison_debut'] = $seasons[0]['saison_fin'];
$new_season['saison_fin'] = $new_season['saison_debut'] + 1;
?>

<div class="col-xs-12 col-md-6 col-md-offset-3">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h1 class="panel-title">Choix de la saison</h1>
        </div>
        <div class="panel-body">
            <form method="post" action="css.php">
                <div class="form-group">
                    <label for='saison'>Saison à <?php if ($_GET['action'] == 'write') { ?>
                            modifier
                        <?php } elseif ($_GET['action'] == 'read') {
                            ?>
                            consulter
                        <?php } ?>
                    </label>
                    <select class="form-control" id='saison' name="season">
                        <?php
                        foreach ($seasons as $season) {
                            echo '<option value="' . $season['id'] . '">';
                            echo $season['saison_debut'];
                            echo '-';
                            echo $season['saison_fin'];
                            echo '</option>';
                        }
                        ?>
                    </select>
                </div>
                <?php // if ($_GET['action'] == 'write') { ?>
                <!--                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="new_season" value='<?php echo $new_season['saison_debut']; ?>'> Ou bien coche la case pour créer automatiquement la saison <?php echo $new_season['saison_debut'] . '-' . $new_season['saison_fin']; ?>.
                                        </label>
                                    </div>-->
                <?php // } ?>
                <input type='hidden' name='form_season' value='1'>
                <!-- Ce sera utile sur la page form pour distinguer qu'on vient d'un formulaire de saison. -->
                <input type="hidden" name="action" value='<?php echo $_GET['action']; ?>'>
                <!-- Ce sera utile sur la page form pour distinguer si on voulait modifier ou consulter les données. -->
                <button type="submit" class="btn btn-primary pull-right">Page suivante <span class="glyphicon glyphicon-arrow-right"></span></button>

            </form>
        </div>
    </div>
</div>