<?php
include('auth.php');
if($_SESSION['admin'] == 0) {
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Le personnel de FBLN</title>
        <link href="design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
    <?php include('nav_menu.php');
    include('auth_menu_utilisateur.php');
    ?>
    <div class="index">
    <p class="titre">la liste du personnel de FBLN</p>
    <p class="auth_modify_nom"><a href = "ar_ajout_personnel.php" class="menu">Ajouter un joyeux participant</a></p>
    <p class="auth_modify_nom"><a href="ar_retour_personnel.php" class="menu">Faire revenir un participant parti</a></p>

    <?php
    //Les messages si on vient de modifier un personnel :
    if(isset($_GET['error'])) {
        if($_GET['error'] == 0) {
            echo '<p class="formulaire_erreur">Modifications effectuées.</p>';
        }
        elseif($_GET['error'] == 1) {
            echo '<p class="formulaire_erreur">Une erreur s\'est produite, réessayer.</p>';
        }
    }

        $donnees_service = $bdd->query('SELECT DISTINCT personnel_fbln.service_id, service_fbln.nom AS nom_service FROM personnel_fbln JOIN service_fbln ON personnel_fbln.service_id = service_fbln.id ORDER BY service_fbln.nom');

        while($service=$donnees_service->fetch())
        {

            $donnees_query = $bdd->prepare('SELECT * FROM personnel_fbln WHERE service_id = ? AND actif = 1 ORDER BY cadre DESC, nom');
            $donnees_query->execute(array($service['service_id']));
            echo '<div class="ar_personnel"><table class="ar_personnel"><caption class="ar_personnel">'. $service['nom_service'] . '</caption><tr><th class="ar_personnel">nom</th><th class="ar_personnel">prénom</th><th class="ar_personnel">pseudo</th><th colspan=3 class="ar_personnel">actions</th></tr>';

            while($personnel=$donnees_query->fetch())
            {
                echo '<tr';

                if($personnel['cadre'] == '1')
                {
                    echo ' class="ar_personnel_cadre"';
                }

                echo '><td class="ar_personnel">' . $personnel['nom'] . '</td><td class="ar_personnel">' . $personnel['prenom'] . '</td><td class="ar_personnel">' . $personnel['pseudo'] . '</td><td class="ar_personnel"><a href = "ar_modifier_personnel.php?id=' . $personnel['id'] .'" class="ar_personnel">modifier</a></td><td class="ar_personnel"><a href="ar_modif_mdp_personnel.php?id=' . $personnel['id'] . '" class="ar_personnel">mot de passe</a></td><td class="ar_personnel"><a href = "ar_depart_personnel.php?id=' . $personnel['id'] . '" class="ar_personnel">départ</td></tr>';
            }

            echo '</table></div>';

            $donnees_query->closeCursor();

        }

        $donnees_service->closeCursor();

    ?>    
    </div>
    </body>
</html>