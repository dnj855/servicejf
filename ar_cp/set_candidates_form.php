<?php
$registered_candidates = getCpCandidates($bdd); // Pour éviter les doublons, on présente d'abord les candidats qu'on a déjà enregistrés.
if ($registered_candidates) {
    ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="panel-title">
                Voici les candidats déjà enregistrés :</h4>
        </div>
        <div class="panel-body">
            <ul class="list-inline">
                <?php foreach ($registered_candidates as $candidate) { ?>
                    <li><?php echo $candidate['prenom'] . ' ' . $candidate['nom']; ?> <small><em><a href="ar_cp.php?action=set_candidates&del_id=<?php echo $candidate['id']; ?>"><span>&times;</span></a></em></small></li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
    <?php
}
?>


<!--Et ensuite, on propose le formulaire pour ajouter un nouveau candidat.-->
<div class="panel panel-primary">
    <div class="panel-heading">
        <h4 class="panel-title">Enregistrer un candidat :</h4>
    </div>
    <div class="panel-body">
        <form method="post">
            <div class="form-group">
                <label for="prenom" class="sr-only">Prénom :</label>
                <input type="text" id="prenom" name="prenom" placeholder="Prénom" class="form-control">
            </div>
            <div class="form-group">
                <label for="nom" class="sr-only">Nom :</label>
                <input type="text" id="nom" name="nom" placeholder="Nom" class="form-control">
            </div>
            <div class="form-group text-right">
                <input type="submit" class="btn btn-primary" value="Ajouter">
            </div>
        </form>
    </div>
</div>