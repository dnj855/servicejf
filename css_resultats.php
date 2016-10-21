<?php
include('auth.php');
include('fonctions.php');
?>

   <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Le challenge des soirées foot - Les résultats</title>
        <link href="design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
    <?php
    include('nav_menu.php');
    include('auth_menu_utilisateur.php');
    ?>
    <div class="index">
    <p class="titre">le challenge des soirées foot : les résultats</p>

    <?php
        // On calcule d'abord le nombre total d'interviews qui ont été réalisées.
        $nb_total_soirees = $bdd->query('SELECT COUNT(*) AS nb_total_soirees FROM soirees_foot WHERE pts_fcmetz IS NOT NULL'); 
        $nb_total_soirees = $nb_total_soirees->fetch();

    ?>
    <p class="auth_modify_nom">Les résultats après <?php echo $nb_total_soirees['nb_total_soirees'] ?> soirées foot.</p>   


    <?php
        // Ensuite, on regarde qui a réalisé des interviews.
        $query=$bdd->query('SELECT DISTINCT personnel_fbln.id AS technicien_id, prenom FROM soirees_foot JOIN personnel_fbln ON personnel_fbln.id = soirees_foot.id_technicien');
    ?>
    <div class="ci_resultats">
    <table class="ci_resultats">
    <tr>
    <th></th><th class="ci_resultats">Matches réalisés</th><th class="ci_resultats">Ratio victoires/matches réalisés</th><th class="ci_resultats">Nombre de points moyens</th><th class="ci_resultats">Différence de buts</th></tr>

    <?php
        // Pour chaque technicien existant, on lance une boucle.
        while($technicien = $query->fetch())
        {
        	$id_technicien = $technicien['technicien_id']; // On stocke l'id du technicien en question dans une variable.
            echo '<tr><td class="ci_resultats">' . $technicien['prenom'] . '</td>';

            // S'ensuivent toute une série de requêtes pour établir les différentes possibilités d'interviews.
            $total = $bdd->prepare('SELECT COUNT(*) AS total FROM soirees_foot WHERE id_technicien = ?');
            $total->execute(array($id_technicien));
            $total = $total->fetch();
            $total = $total['total']; 

            $ratio = $bdd->prepare('SELECT COUNT(*) AS ratio FROM soirees_foot WHERE pts_fcmetz = 3 AND id_technicien = ?');
            $ratio->execute(array($id_technicien));
            $ratio = $ratio->fetch();
            $ratio = $ratio['ratio'];
            $ratio = round($ratio / $total, 2);

            $moyenne_pts = $bdd->prepare('SELECT AVG(pts_fcmetz) AS moyenne_pts FROM soirees_foot WHERE id_technicien = ?');
            $moyenne_pts->execute(array($id_technicien));
            $moyenne_pts = $moyenne_pts->fetch();
            $moyenne_pts = round($moyenne_pts['moyenne_pts'], 2);

            $sum_buts_fcmetz = $bdd->prepare('SELECT SUM(buts_fcmetz) AS sum_buts_fcmetz FROM soirees_foot WHERE id_technicien = ?');
            $sum_buts_fcmetz->execute(array($id_technicien));
            $sum_buts_fcmetz = $sum_buts_fcmetz->fetch();
            $sum_buts_fcmetz = $sum_buts_fcmetz['sum_buts_fcmetz'];

            $sum_buts_adversaire = $bdd->prepare('SELECT SUM(buts_adversaire) AS sum_buts_adversaire FROM soirees_foot WHERE id_technicien = ?');
            $sum_buts_adversaire->execute(array($id_technicien));
            $sum_buts_adversaire = $sum_buts_adversaire->fetch();
            $sum_buts_adversaire = $sum_buts_adversaire['sum_buts_adversaire'];

            $goal_average = $sum_buts_fcmetz - $sum_buts_adversaire;       

            // Et ensuite on affiche les données.
            echo '<td class="ci_resultats">' . $total . '</td>';
            echo '<td class="ci_resultats">' . $ratio . '</td>';
            echo '<td class="ci_resultats">' . $moyenne_pts . '</td>';
            echo '<td class="ci_resultats">' . $goal_average . '</td></tr>';   

        }

        $query->closeCursor();

    ?>    
    </table>
    </div>
    <p class="help">Légende : le meilleur technicien selon le reglement du challenge est celui qui a son ratio qui s'approche le plus de 1.<br />Version provisoire de l'affichage des résultats.</p>
    </div>
    <?php
    if ($_SESSION['admin'] == 1) {
        include('ci_resultats_diag.php');
    }
    ?>
    </body>
    </html>