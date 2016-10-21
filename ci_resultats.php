<?php
include('auth.php');
include('fonctions.php');
?>

   <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Le challenge de l'invité FBLN - Les résultats</title>
        <link href="design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
    <?php
    include('nav_menu.php');
    include('auth_menu_utilisateur.php');
    ?>
    <div class="index">
    <p class="titre">le challenge invité : les résultats</p>

    <?php
        // On calcule d'abord le nombre total d'interviews qui ont été réalisées.
        $nb_total_itws = $bdd->query('SELECT COUNT(*) AS nb_total_itws FROM challenge_invite'); 
        $nb_total_itws = $nb_total_itws->fetch();

    ?>
    <p class="auth_modify_nom">Depuis la création du challenge, <?php echo $nb_total_itws['nb_total_itws'] ?> interviews ont été réalisées. </p>   


    <?php
        // Ensuite, on regarde qui a réalisé des interviews.
        $query=$bdd->query('SELECT DISTINCT personnel_fbln.id AS itw_id, prenom FROM challenge_invite JOIN personnel_fbln ON personnel_fbln.id = challenge_invite.identite');
    ?>
    <div class="ci_resultats">
    <table class="ci_resultats">
    <tr>
    <th></th><th class="ci_resultats">Nombre d'interviews</th><th class="ci_resultats">Combos parfaits</th><th class="ci_resultats">Directs téléphone</th><th class="ci_resultats">PAD studio</th><th class="ci_resultats">PAD téléphone</th></tr>

    <?php
        // Pour chaque intervieweur existant, on lance une boucle.
        while($intervieweur = $query->fetch())
        {
        	$id_intervieweur = $intervieweur['itw_id']; // On stocke l'id de l'intervieweur en question dans une variable.
            echo '<tr><td class="ci_resultats">' . $intervieweur['prenom'] . '</td>';

            // S'ensuivent toute une série de requêtes pour établir les différentes possibilités d'interviews.
            $total = $bdd->prepare('SELECT COUNT(*) AS total FROM challenge_invite WHERE identite = ?');
            $total->execute(array($id_intervieweur));
            $total = $total->fetch();
            $total = $total['total']; 

            $ds = $bdd->prepare('SELECT COUNT(*) AS ds FROM challenge_invite WHERE direct = 1 AND studio = 1 AND identite = ?');
            $ds->execute(array($id_intervieweur));
            $ds = $ds->fetch();
            $ds = $ds['ds'];
            $ds = Pourcentage($ds, $total);

            $dt = $bdd->prepare('SELECT COUNT(*) AS dt FROM challenge_invite WHERE direct = 1 AND studio = 0 AND identite = ?');
            $dt->execute(array($id_intervieweur));
            $dt = $dt->fetch();
            $dt = $dt['dt'];
            $dt = Pourcentage($dt, $total);

            $ps = $bdd->prepare('SELECT COUNT(*) AS ps FROM challenge_invite WHERE direct = 0 AND studio = 1 AND identite = ?');
            $ps->execute(array($id_intervieweur));
            $ps = $ps->fetch();
            $ps = $ps['ps'];
            $ps = Pourcentage($ps, $total);

            $pt = $bdd->prepare('SELECT COUNT(*) AS pt FROM challenge_invite WHERE direct = 0 AND studio = 0 AND identite = ?');
            $pt->execute(array($id_intervieweur));
            $pt = $pt->fetch();
            $pt = $pt['pt'];
            $pt = Pourcentage($pt, $total);       

            // Et ensuite on affiche les données.
            echo '<td class="ci_resultats">' . $total . '</td>';
            echo '<td class="ci_resultats">' . $ds . '%</td>';
            echo '<td class="ci_resultats">' . $dt . '%</td>';
            echo '<td class="ci_resultats">' . $ps . '%</td>';
            echo '<td class="ci_resultats">' . $pt . '%</td></tr>';   

        }

        $query->closeCursor();

    ?>    
    </table>
    </div>
    <p class="help">Version provisoire de l'affichage des résultats.</p>
    </div>
    <?php
    if ($_SESSION['admin'] == 1) {
        include('ci_resultats_diag.php');
    }
    ?>
    </body>
    </html>