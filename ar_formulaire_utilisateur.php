<div class="form-group">
    <label for="nom" class="col-md-3 control-label">Nom :</label>
    <div class="col-md-9">
        <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $personnel['nom']; ?>">
    </div>
</div>
<div class="form-group">
    <label for="prenom" class="col-md-3 control-label">Prénom :</label>
    <div class="col-md-9">
        <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $personnel['prenom']; ?>">
    </div>
</div>
<div class="form-group">
    <label for="pseudo" class="col-md-3 control-label">Pseudo :</label>
    <div class="col-md-9">
        <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php echo $personnel['pseudo']; ?>">
    </div>
</div>
<div class="form-group">
    <label for="service" class="col-md-3 control-label">Service :</label>
    <div class="col-md-9">
        <select id="service" class="form-control" name="service">
            <?php
            if (isset($personnel)) { //On vérifie si on modifie ou si on ajoute un personnel.
                $query_service = $bdd->prepare('SELECT nom, id FROM service_fbln WHERE id = ? ORDER BY nom'); // On affiche d'abord le service d'origine
                $query_service->execute(array($service_personnel));
                $service = $query_service->fetch();
                echo '<option value="' . $service['id'] . '">' . $service['nom'] . '</option>';
                $query_service = $bdd->prepare('SELECT nom, id FROM service_fbln WHERE id != ? ORDER BY nom'); // Puis on propose les autres
                $query_service->execute(array($service_personnel));

                while ($service = $query_service->fetch()) {
                    echo '<option value="' . $service['id'] . '">' . $service['nom'] . '</option>';
                }
                $query_service->closeCursor();
            } else {
                $query_service = $bdd->query('SELECT nom, id FROM service_fbln ORDER BY nom');
                while ($service = $query_service->fetch()) {
                    echo '<option value="' . $service['id'] . '">' . $service['nom'] . '</option>';
                }
            }
            ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Cadre :</label>
    <div class="col-md-9">
        <label class="radio-inline"><input type="radio" name="cadre" value="1" <?php
            if ($donnees_cadre['cadre'] == 1) {
                echo 'checked';
            }
            ?>>Oui</label>
        <label class="radio-inline"><input type="radio" name="cadre" value="0" <?php
            if ($donnees_cadre['cadre'] != 1) {
                echo 'checked';
            }
            ?>>Non</label>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Administrateur :</label>
    <div class="col-md-9">
        <label class="radio-inline"><input type="radio" name="admin" value="1" <?php
            if ($donnees_admin['admin'] == 1) {
                echo 'checked';
            }
            ?>>Oui</label>
        <label class="radio-inline"><input type="radio" name="admin" value="0" <?php
            if ($donnees_admin['admin'] != 1) {
                echo 'checked';
            }
            ?>>Non</label>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Soirées sport :</label>
    <div class="col-md-9">
        <label class="radio-inline"><input type="radio" name="css" value="1" <?php
            if ($donnees_css['css'] == 1) {
                echo 'checked';
            }
            ?>>Oui</label>
        <label class="radio-inline"><input type="radio" name="css" value="0" <?php
            if ($donnees_css['css'] != 1) {
                echo 'checked';
            }
            ?>>Non</label>
    </div>
    <input type="hidden" name="id" value="<?php echo $personnel['id']; ?>">
</div>
<div class="form-group">
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-ok"></span> Envoyer</button>
    </div>
</div>
</form>