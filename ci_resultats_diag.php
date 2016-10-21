<?php
include('auth.php');

$query = $bdd->query('SELECT id AS itw_id, prenom FROM personnel_fbln WHERE service_id = 1');

while($intervieweur = $query->fetch()) {

	// On récupère d'abord le total d'interviews réalisées par l'intervieweur.
	$total = $bdd->prepare('SELECT COUNT(*) AS total FROM challenge_invite WHERE identite = ?');
	$total->execute(array($intervieweur['itw_id']));
	$total = $total->fetch();
	$total = $total['total'];

	// Le nombre d'interviews selon les cas de figure. ds = direct studio. dt = direct téléphone. ps = PAD studio. pt = PAD téléphone.
    $ds = $bdd->prepare('SELECT COUNT(*) AS ds FROM challenge_invite WHERE direct = 1 AND studio = 1 AND identite = ?');
    $ds->execute(array($intervieweur['itw_id']));
    $ds = $ds->fetch();
    $ds = $ds['ds'];

    $dt = $bdd->prepare('SELECT COUNT(*) AS dt FROM challenge_invite WHERE direct = 1 AND studio = 0 AND identite = ?');
    $dt->execute(array($intervieweur['itw_id']));
    $dt = $dt->fetch();
    $dt = $dt['dt'];

    $ps = $bdd->prepare('SELECT COUNT(*) AS ps FROM challenge_invite WHERE direct = 0 AND studio = 1 AND identite = ? AND pad_obligatoire = 0');
    $ps->execute(array($intervieweur['itw_id']));
    $ps = $ps->fetch();
    $ps_2pts = $ps['ps'];

    $ps = $bdd->prepare('SELECT COUNT(*) AS ps FROM challenge_invite WHERE direct = 0 AND studio = 1 AND identite = ? AND pad_obligatoire = 1');
    $ps->execute(array($intervieweur['itw_id']));
    $ps = $ps->fetch();
    $ps_3pts = $ps['ps'];

    $pt = $bdd->prepare('SELECT COUNT(*) AS pt FROM challenge_invite WHERE direct = 0 AND studio = 0 AND identite = ?');
    $pt->execute(array($intervieweur['itw_id']));
    $pt = $pt->fetch();
    $pt = $pt['pt'];

    $total_calees = $bdd->prepare('SELECT COUNT(*) AS total_calees FROM challenge_invite WHERE caleur_id = ?');
    $total_calees->execute(array($intervieweur['itw_id']));
    $total_calees = $total_calees->fetch();
    $total_calees = $total_calees['total_calees'];

    $ds_calees = $bdd->prepare('SELECT COUNT(*) AS ds_calees FROM challenge_invite WHERE caleur_id = ? AND direct = 1 AND studio = 1');
    $ds_calees->execute(array($intervieweur['itw_id']));
    $ds_calees = $ds_calees->fetch();
    $ds_calees = $ds_calees['ds_calees'];

    // Ensuite on fait les calculs des ratios.

    $pts = 0;

    if($total>0) { // On vérifie que l'intervieweur a bien fait des interviews, pour éviter de faire une division par 0.

    $pts_ds = ($ds/$total)*3; // Les ds valent 3, au ratio du total réalisé.
    $pts_dt = ($dt/$total)*2; // Les dt valent 2, au ratio du total réalisé.
    $pts_pt = ($pt/$total); // Les pt valent 1, au ratio du total réalisé.
    $pts_ps2 = ($ps_2pts/$total)*2; // Le PAD studio vaut 2.
    $pts_ps3 = ($ps_3pts/$total)*3; // Et quand le PAD était obligatoire, ça vaut 3.

    $pts = $pts_ps2 + $pts_ds + $pts_dt + $pts_pt + $pts_ps3;

    }

    if ($total_calees>0) { // On vérifie d'abord que la personne a calé des interviews pour éviter de faire une division par 0.
        $pts_bonus_calage = ($ds_calees/$total_calees);
        $pts = $pts + $pts_bonus_calage;
    }

    echo $intervieweur['prenom'] . ' : ' . sprintf('%.1f',$pts) . '<br/>';

}



?>