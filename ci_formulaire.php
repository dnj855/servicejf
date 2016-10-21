<?php
include('auth.php');
?>
    <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Le challenge de l'invité FBLN</title>
        <link href="design.css" rel="stylesheet" type="text/css" />
        <link href="auth.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
    <?php include('auth_menu_utilisateur.php');
    include('nav_menu.php') ?>
    <div class="index">
    <p class="titre">le challenge invité du service jeux&festivités:</p>
    <div class="formulaire">
    <form method="post" action="ci.php">
    <table class="formulaire">
    <tr>
    <td>
    Qui es-tu ?
    </td>
    <td>
    <select name="identite" class="formulaire">
    <option value="">---Choisir---</option>
    <?php
        $query = $bdd->query('SELECT prenom, id FROM personnel_fbln WHERE service_id = 1 AND actif = 1 ORDER BY prenom');
        while ($identite = $query->fetch()) {
            echo '<option value="' . $identite['id'] . '">' . $identite['prenom'] . '</option>';
            
        }
        $query->closeCursor();
    ?>
    </select>
    </td>
    </tr>
    <tr>
    <td>
    En studio ou pas ?
    </td>
    <td>
    <input type="radio" name="studio" value="1" /> Studio
    <input type="radio" name="studio" value="0" /> Téléphone
    </td>
    </tr>
    <tr>
    <td>
    En direct ou en PAD ?
    </td>
    <td>
    <input type="radio" name="direct" value="1" /> En direct
    <input type="radio" name="direct" value="0" /> En PAD
    </td>
    </tr>
    <tr>
    <td>
    Calé par :
    </td>
    <td>
    <select name="caleur" class="formulaire">
        <option value="">---Choisir---</option>
    <?php
        $query = $bdd->query('SELECT prenom, id FROM personnel_fbln WHERE service_id = 1 AND actif = 1 ORDER BY prenom');
        while ($identite = $query->fetch()) {
            echo '<option value="' . $identite['id'] . '">' . $identite['prenom'] . '</option>';
            
        }
        $query->closeCursor();
    ?>
    </select>
    </td>
    </tr>
    <tr>
    <td>
    Et son petit nom ?
    </td>
    <td>
    <input type="text" name="nom" size="30" class="formulaire" />
    </td>
    </tr>
    <tr>
    <td>
    PAD obligatoire :
    </td>
    <td><input type="checkbox" name="pad_obligatoire"/>
    </td>
    </tr>
    <tr>
    <td colspan=2 align="center">
    <input type="button" value="Envoyer" onclick="Verifier_formulaire (this.form)" id="send" class="envoi_formulaire">
    <input type="reset" value="Annuler" class="envoi_formulaire">
    </td>
    </tr>
    </table>
    </form>
    </div>
<script>
function Verifier_formulaire(formulaire){
  if (formulaire.identite.value==""){
    alert ("Tu as oublié de remplir ton nom.");
  }else{
    formulaire.submit();
  }
}
</script>
    </div>
    </body>
    </html>