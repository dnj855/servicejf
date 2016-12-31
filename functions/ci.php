<?php

function getCiResults($bdd, $id = '') {
    $resultats = array();
    $tableau_intervieweur = array();

    if ($id) {
        $tableau_intervieweur[0] = getUserIdentity($bdd, $id);
    } else {
        $query = $bdd->query('SELECT DISTINCT personnel_fbln.id AS itw_id FROM challenge_invite JOIN personnel_fbln ON personnel_fbln.id = challenge_invite.identite');
        $i = 0;
        while ($loop_intervieweur = $query->fetch()) {
            $tableau_intervieweur[$i]['id'] = $loop_intervieweur['itw_id'];
            $i++;
        }
    }

    foreach ($tableau_intervieweur as $intervieweur) {
        $id = $intervieweur['id'];
        $identite_intervieweur = getUserIdentity($bdd, $id);
        $prenom_intervieweur = $identite_intervieweur['prenom'];

        $total = $bdd->prepare('SELECT COUNT(*) AS total FROM challenge_invite WHERE identite = ?');
        $total->execute(array($id));
        $total = $total->fetch();
        $total = $total['total'];

        $ds = $bdd->prepare('SELECT COUNT(*) AS ds FROM challenge_invite WHERE direct = 1 AND studio = 1 AND identite = ?');
        $ds->execute(array($id));
        $ds = $ds->fetch();
        $ds = $ds['ds'];

        $dt = $bdd->prepare('SELECT COUNT(*) AS dt FROM challenge_invite WHERE direct = 1 AND studio = 0 AND identite = ?');
        $dt->execute(array($id));
        $dt = $dt->fetch();
        $dt = $dt['dt'];

        $ps = $bdd->prepare('SELECT COUNT(*) AS ps FROM challenge_invite WHERE direct = 0 AND studio = 1 AND identite = ? AND pad_obligatoire = 0');
        $ps->execute(array($id));
        $ps = $ps->fetch();
        $ps_2pts = $ps['ps'];

        $ps = $bdd->prepare('SELECT COUNT(*) AS ps FROM challenge_invite WHERE direct = 0 AND studio = 1 AND identite = ? AND pad_obligatoire = 1');
        $ps->execute(array($id));
        $ps = $ps->fetch();
        $ps_3pts = $ps['ps'];

        $ps = $ps_2pts + $ps_3pts;

        $pt = $bdd->prepare('SELECT COUNT(*) AS pt FROM challenge_invite WHERE direct = 0 AND studio = 0 AND identite = ?');
        $pt->execute(array($id));
        $pt = $pt->fetch();
        $pt = $pt['pt'];

        $total_calees = $bdd->prepare('SELECT COUNT(*) AS total_calees FROM challenge_invite WHERE caleur_id = ?');
        $total_calees->execute(array($id));
        $total_calees = $total_calees->fetch();
        $total_calees = $total_calees['total_calees'];

        $ds_calees = $bdd->prepare('SELECT COUNT(*) AS ds_calees FROM challenge_invite WHERE caleur_id = ? AND direct = 1 AND studio = 1');
        $ds_calees->execute(array($id));
        $ds_calees = $ds_calees->fetch();
        $ds_calees = $ds_calees['ds_calees'];

        $pts = $bdd->prepare('SELECT pts FROM challenge_invite_points WHERE id_intervieweur = ?');
        $pts->execute(array($id));
        $pts = $pts->fetch();
        $pts = $pts['pts'];

        $resultats[$id] = array(
            'prenom_intervieweur' => $prenom_intervieweur,
            'total' => $total,
            'direct_studio' => $ds,
            'direct_telephone' => $dt,
            'pad_studio' => $ps,
            'pad_telephone' => $pt,
            'ps_2pts' => $ps_2pts,
            'ps_3pts' => $ps_3pts,
            'total_calees' => $total_calees,
            'ds_calees' => $ds_calees,
            'pts' => $pts
        );
    }
    return $resultats;
}

function updateCiResults($bdd) {
    $boucle_resultats = getCiResults($bdd);

    foreach ($boucle_resultats as $id => $resultats) {

        $pts = 0;
        $pts_ds = ($resultats['direct_studio'] / $resultats['total']) * 3; // Les ds valent 3, au ratio du total réalisé.
        $pts_dt = ($resultats['direct_telephone'] / $resultats['total']) * 2; // Les dt valent 2, au ratio du total réalisé.
        $pts_pt = ($resultats['pad_telephone'] / $resultats['total']); // Les pt valent 1, au ratio du total réalisé.
        $pts_ps2 = ($resultats['ps_2pts'] / $resultats['total']) * 2; // Le PAD studio vaut 2.
        $pts_ps3 = ($resultats['ps_3pts'] / $resultats['total']) * 3; // Et quand le PAD était obligatoire, ça vaut 3.

        $pts = $pts_ps2 + $pts_ds + $pts_dt + $pts_pt + $pts_ps3;

        if ($resultats['total_calees'] > 0) { // On vérifie d'abord que la personne a calé des interviews pour éviter de faire une division par 0.
            $pts_bonus_calage = ($resultats['ds_calees'] / $resultats['total_calees']);
            $pts = $pts + $pts_bonus_calage;
        }

        $pts = $pts * 100;

        $query = $bdd->prepare('UPDATE challenge_invite_points SET pts = :pts WHERE id_intervieweur = :id');
        $query->execute(array(
            'pts' => $pts,
            'id' => $id
        ));
    }
}
