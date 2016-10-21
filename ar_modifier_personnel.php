<?php
include('auth.php');
if($_SESSION['admin'] == 0) {
    header('location:index.php');
}

    if(isset($_GET['id']))
    {
        $_GET['id'] = (int) $_GET['id']; //Vérification de l'id reçue. Si tout est bon, on connecte à la BDD et on propose le formulaire

        $query = $bdd->prepare('SELECT * FROM personnel_fbln WHERE id = ?');
        $query->execute(array($_GET['id']));

        $personnel=$query->fetch();
        $service_personnel = $personnel['service_id'];
        $query->closeCursor();

?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <title>Modifier la fiche de <?php echo $personnel['prenom'] . ' ' . $personnel['nom'];?></title>
        <link href="design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
    <?php include('nav_menu.php');
    include('auth_menu_utilisateur.php');
    ?>

    <div class="index">
    <p class="titre"><?php echo $personnel['prenom'] . ' ' . $personnel['nom'] . ' :';?></p>
    <div class="formulaire">
    <form class="formulaire" method="post" action="ar_modifier_personnel_traitement.php">
    <table class="formulaire">
    <tr><td>Nom :</td><td><input type="text" class="formulaire" name="nom" value="<?php echo $personnel['nom'];?>"></td></tr>
    <tr><td>Prénom :</td><td><input type="text" class="formulaire" name="prenom" value="<?php echo $personnel['prenom'];?>"></td></tr>
    <tr><td>Pseudo :</td><td><input type="text" class="formulaire" name="pseudo" value="<?php echo $personnel['pseudo'];?>"></td></tr>
    <tr><td>Service :</td><td><select name="service" class="formulaire">
    <?php
        $query_service = $bdd->prepare('SELECT nom, id FROM service_fbln WHERE id = ? ORDER BY nom'); // On affiche d'abord le service d'origine
        $query_service->execute(array($service_personnel));
        $service = $query_service->fetch();

            echo '<option value="' . $service['id'] . '">' . $service['nom'] . '</option>';

        $query_service = $bdd->prepare('SELECT nom, id FROM service_fbln WHERE id != ? ORDER BY nom'); // Puis on propose les autres
        $query_service->execute(array($service_personnel));

        while ($service = $query_service->fetch())
        {
            echo '<option value="' . $service['id'] . '">' . $service['nom'] . '</option>';
        }
        $query_service->closeCursor();
    ?>
    </select></td></tr>
    <tr><td>Cadre ?</td><td>
    <?php
        $query_cadre = $bdd->prepare('SELECT cadre FROM personnel_fbln WHERE id = ?');
        $query_cadre->execute(array($_GET['id']));
        $donnees_cadre = $query_cadre->fetch();

        if($donnees_cadre['cadre'] == '1') // On ne précoche pas le même bouton selon que la personne est cadre ou non.
        {
            echo '<input type="radio" name="cadre" value="1" checked="checked"/><label for="1"> Oui</label> <input type="radio" name="cadre" value="0" /><label for="0"> Non</label>';
        }
        else
        {
            echo '<input type="radio" name="cadre" value="1" /><label for="1"> Oui</label> <input type="radio" name="cadre" value="0" checked="checked" /><label for="0"> Non</label>';
        }
        $query_cadre->closeCursor();
        ?>

    </td></tr>
        <tr><td>Administrateur ?</td><td>
    <?php
        $query_cadre = $bdd->prepare('SELECT admin FROM personnel_fbln WHERE id = ?');
        $query_cadre->execute(array($_GET['id']));
        $donnees_cadre = $query_cadre->fetch();

        if($donnees_cadre['admin'] == '1') // On ne précoche pas le même bouton selon que la personne est cadre ou non.
        {
            echo '<input type="radio" name="admin" value="1" checked="checked"/><label for="1"> Oui</label> <input type="radio" name="admin" value="0" /><label for="0"> Non</label>';
        }
        else
        {
            echo '<input type="radio" name="admin" value="1" /><label for="1"> Oui</label> <input type="radio" name="admin" value="0" checked="checked" /><label for="0"> Non</label>';
        }
        $query_cadre->closeCursor();
        ?>

    </td></tr>
            <tr><td>Soirées foot ?</td><td>
    <?php
        $query_cadre = $bdd->prepare('SELECT css FROM personnel_fbln WHERE id = ?');
        $query_cadre->execute(array($_GET['id']));
        $donnees_cadre = $query_cadre->fetch();

        if($donnees_cadre['css'] == '1') // On ne précoche pas le même bouton selon que la personne est cadre ou non.
        {
            echo '<input type="radio" name="css" value="1" checked="checked"/><label for="1"> Oui</label> <input type="radio" name="css" value="0" /><label for="0"> Non</label>';
        }
        else
        {
            echo '<input type="radio" name="css" value="1" /><label for="1"> Oui</label> <input type="radio" name="css" value="0" checked="checked" /><label for="0"> Non</label>';
        }
        $query_cadre->closeCursor();
        ?>

    </td></tr>
    <tr><td></td><td>
    <input type="hidden" name="id" value="<?php echo $personnel['id']; ?>">
    <input type="submit" value="Envoyer !" class="envoi_formulaire">
    </td></tr></table>
    </form>
    </div>

    </body>
    </html>

    <?php
    }
?>