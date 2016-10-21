<?php
include('auth.php');
$journee = $bdd->prepare('SELECT * FROM soirees_foot WHERE id_journee = ?');
$journee->execute(array($_GET['journee_id']));
$journee = $journee->fetch();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Le challenge des soirées sport du service j&f:</title>
        <link href="design.css" rel="stylesheet" type="text/css" />
    </head>

<body>
<?php include('auth_menu_utilisateur.php');
include('nav_menu.php') ?>
<div class="index">
<p class="titre">le challenge des soirées foot</p>
<p class="auth_modify_nom"><?php echo 'journée n°' . $_GET['journee_id'] . ' : ' . $equipe_home . ' - ' . $equipe_away ?></p>
<?php if($done == 1) {
    echo '<p class="formulaire_erreur">C\'est bien noté, merci !</p>';
}
?>
<div class="formulaire">
<form method="post" action="css.php?journee_id=<?php echo $_GET['journee_id'] ?>">
<table class="formulaire">
<tr>
<td>
    Qui réalisait la soirée ?
</td>
<td>
    <select name="technicien_id" class="formulaire">
        
        <?php
            if($journee['id_technicien'] <> NULL) { // Si la journée a déjà été saisie.
                $query = $bdd->prepare('SELECT prenom, id FROM personnel_fbln WHERE id = ?'); // On affiche d'abord le prénom du technicien déjà saisi.
                $query->execute(array($journee['id_technicien']));
                $identite = $query->fetch();
                echo '<option value="' . $identite['id'] . '">' . $identite['prenom'] . '</option>';
                $query->closeCursor();
                $query = $bdd->prepare('SELECT prenom, id FROM personnel_fbln WHERE service_id = 2 AND actif = 1 AND cadre = 0 AND id != ? ORDER BY prenom'); // Puis les autres.
                $query->execute(array($journee['id_technicien']));
                while ($identite = $query->fetch()) {
                    echo '<option value="' . $identite['id'] . '">' . $identite['prenom'] . '</option>';
            
                }

            }
            else { // Si la journée n'a pas encore été saisie.
                echo '<option value="">---Choisir---</option>';
                $query = $bdd->query('SELECT prenom, id FROM personnel_fbln WHERE service_id = 2 AND actif = 1 AND cadre = 0 ORDER BY prenom');
                while ($identite = $query->fetch()) {
                    echo '<option value="' . $identite['id'] . '">' . $identite['prenom'] . '</option>';
            
                }
            $query->closeCursor();
            }
        ?>
    </select>
</td>
</tr>
<tr>
<td>
    Résultat du FC Metz :
</td>
<td>
    <select name="pts_fcmetz" class="formulaire">
	   <option value="3">Victoire</option>
	   <option value="1">Nul</option>
	   <option value="0">Défaite</option>
    </select>
</td>
</tr>
<tr>
<td>
    Buts inscrits par le FC Metz :
</td>
<td>    
    <input type="text" name="buts_fcmetz" class="formulaire" value="<?php echo $journee['buts_fcmetz'] ?>">
</td>
</tr>
<tr>
<td>
    Buts inscrits par l'adversaire :
</td>
<td>
    <input type="text" name="buts_adversaire" class="formulaire" value="<?php echo $journee['buts_adversaire'] ?>">
    <input type="hidden" name="id_journee" value="<?php echo $_GET['journee_id'] ?>">
</td>
</tr>
<tr>
<td>
</td>
<td>
    <input type="button" value="Envoyer" onclick="Verifier_formulaire (this.form)" id="send" class="envoi_formulaire">
    <input type="reset" value="Annuler" class="envoi_formulaire">
</td>
</tr>
</table>
</form>
<script>
function Verifier_formulaire(formulaire){
  if (formulaire.technicien_id.value==""){
    alert ("Tu as oublié de remplir le nom du réalisateur.");
  }else{
    formulaire.submit();
  }
}
</script>
</div>
</div>
</body>