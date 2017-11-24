<?php

function newGetCiResults($bdd, $saison, $id = '') {
    // Dans un premier temps, on récupère les différentes données dans la base.
    if ($id) {
        $query = $bdd->prepare('SELECT DISTINCT p.nom, p.prenom, p.id, COUNT(c.id) nb_itw, SUM(IF(c.direct = 1 && c.studio = 1, 1, 0)) ds, SUM(IF(c.direct = 1 && c.studio = 0, 1, 0)) dt, SUM(IF(c.direct = 0 && c.studio = 1, 1, 0)) ps, SUM(IF(c.direct = 0 && c.studio = 0, 1, 0)) pt, SUM(IF(pad_obligatoire = 1 && c.direct = 0 && c.studio = 1, 1, 0)) pad_obligatoire FROM challenge_invite c JOIN personnel_fbln p ON c.identite = p.id WHERE c.saison_id = :saison_id AND c.identite = :id GROUP BY c.identite HAVING nb_itw >=5 ORDER BY nb_itw DESC');
        $query->execute(array(
            'saison_id' => $saison,
            'id' => $id
        ));
    } else {
        $query = $bdd->prepare('SELECT DISTINCT p.nom, p.prenom, p.id, COUNT(c.id) nb_itw, SUM(IF(c.direct = 1 && c.studio = 1, 1, 0)) ds, SUM(IF(c.direct = 1 && c.studio = 0, 1, 0)) dt, SUM(IF(c.direct = 0 && c.studio = 1, 1, 0)) ps, SUM(IF(c.direct = 0 && c.studio = 0, 1, 0)) pt, SUM(IF(pad_obligatoire = 1 && c.direct = 0 && c.studio = 1, 1, 0)) pad_obligatoire FROM challenge_invite c JOIN personnel_fbln p ON c.identite = p.id WHERE c.saison_id = :saison_id GROUP BY c.identite HAVING nb_itw >=5 ORDER BY nb_itw DESC');
        $query->execute(array(
            'saison_id' => $saison
        ));
    }
    // Dans un deuxième temps, on les transforme en points.
    $points = getCiPoints($bdd, $saison, $query->fetchAll(PDO::FETCH_ASSOC));
    if (!$points) {
        return '';
    } else {
        foreach ($points as $id => $point) {
            $players[$id] = $point['pts_total'];
        }
        arsort($players); // Ici on classe en fonction du nombre de points.
        $rank = 1;
        // Et enfin, on réattribue les données annexes après avoir classé.
        foreach ($players as $id => $player) {
            $results[$id] = array();
            $results[$id]['rank'] = $rank;
            $results[$id]['pts_total'] = $player;
            $results[$id]['id'] = $points[$id]['id'];
            $results[$id]['prenom'] = $points[$id]['prenom'];
            $results[$id]['nom'] = $points[$id]['nom'];
            $results[$id]['nb_itw'] = $points[$id]['nb_itw'];
            $results[$id]['pts_ds'] = $points[$id]['pts_ds'];
            $results[$id]['pts_dt'] = $points[$id]['pts_dt'];
            $results[$id]['pts_pt'] = $points[$id]['pts_pt'];
            $results[$id]['pts_pad_non_obligatoire'] = $points[$id]['pts_pad_non_obligatoire'];
            $results[$id]['pts_pad_obligatoire'] = $points[$id]['pts_pad_obligatoire'];
            $results[$id]['pts_bonus_calage'] = $points[$id]['pts_bonus_calage'];
            $results[$id]['total_calees'] = $points[$id]['calages']['total'];
            $results[$id]['ds_calees'] = $points[$id]['calages']['ds'];
            $results[$id]['ds'] = $points[$id]['ds'];
            $results[$id]['dt'] = $points[$id]['dt'];
            $results[$id]['ps'] = $points[$id]['ps'];
            $results[$id]['pt'] = $points[$id]['pt'];
            $results[$id]['pad_obligatoire'] = $points[$id]['pad_obligatoire'];
            $rank++;
        }
        return $results;
    }
}

function getCiPoints($bdd, $saison, $results) {
    foreach ($results as $id => $result) {
        $query = $bdd->prepare('SELECT SUM(IF(caleur_id = :identite, 1, 0)) total, SUM(IF(direct = 1 && studio = 1 && caleur_id = :identite, 1, 0)) ds FROM challenge_invite WHERE saison_id = :saison');
        $query->execute(array(
            'saison' => $saison,
            'identite' => $result['id']
        ));
        $results[$id]['calages'] = $query->fetch(PDO::FETCH_ASSOC);
        $total = $result['nb_itw'];
        $results[$id]['pts_ds'] = round(($result['ds'] / $total) * 300);
        $results[$id]['pts_dt'] = round(($result['dt'] / $total) * 200); // Les dt valent 2, au ratio du total réalisé.
        $results[$id]['pts_pt'] = round(($result['pt'] / $total) * 100); // Les pt valent 1, au ratio du total réalisé.
        $pad_non_obligatoire = $result['ps'] - $result['pad_obligatoire'];
        $results[$id]['pts_pad_non_obligatoire'] = round(($pad_non_obligatoire / $total) * 200); // Le PAD studio vaut 2.
        $results[$id]['pts_pad_obligatoire'] = round(($result['pad_obligatoire'] / $total) * 300);
        $results[$id]['pts'] = $results[$id]['pts_ds'] + $results[$id]['pts_dt'] + $results[$id]['pts_pt'] + $results[$id]['pts_pad_non_obligatoire'] + $results[$id]['pts_pad_obligatoire'];
        if ($results[$id]['calages']['total'] != 0) {
            $pts_bonus_calage = round(($results[$id]['calages']['ds'] / $results[$id]['calages']['total']) * 100);
            $results[$id]['pts_total'] = $results[$id]['pts'] + $pts_bonus_calage;
            $results[$id]['pts_bonus_calage'] = $pts_bonus_calage;
        }
    }
    return $results;
}

//function getCiResults($bdd, $saison, $id = '') {
//    $resultats = array();
//    $tableau_intervieweur = array();
//
//    if ($id) {
//        $tableau_intervieweur[0] = getUserIdentity($bdd, $id);
//    } else {
//        $query = $bdd->query('SELECT DISTINCT personnel_fbln.id AS itw_id FROM challenge_invite JOIN personnel_fbln ON personnel_fbln.id = challenge_invite.identite');
//        $i = 0;
//        while ($loop_intervieweur = $query->fetch()) {
//            $subquery = $bdd->prepare('SELECT COUNT(*) AS nb_itw FROM challenge_invite WHERE identite = :itw_id');
//            $subquery->execute(array(
//                'itw_id' => $loop_intervieweur['itw_id']
//            ));
//            $nb_itw = $subquery->fetch();
//
//            if ($nb_itw['nb_itw'] >= 5) {
//                $tableau_intervieweur[$i]['id'] = $loop_intervieweur['itw_id'];
//                $i++;
//            }
//        }
//    }
//
//    foreach ($tableau_intervieweur as $intervieweur) {
//        $id = $intervieweur['id'];
//        $identite_intervieweur = getUserIdentity($bdd, $id);
//        $prenom_intervieweur = $identite_intervieweur['prenom'];
//
//        $total = $bdd->prepare('SELECT COUNT(*) AS total FROM challenge_invite WHERE identite = ?');
//        $total->execute(array($id));
//        $total = $total->fetch();
//        $total = $total['total'];
//
//        $ds = $bdd->prepare('SELECT COUNT(*) AS ds FROM challenge_invite WHERE direct = 1 AND studio = 1 AND identite = ?');
//        $ds->execute(array($id));
//        $ds = $ds->fetch();
//        $ds = $ds['ds'];
//
//        $dt = $bdd->prepare('SELECT COUNT(*) AS dt FROM challenge_invite WHERE direct = 1 AND studio = 0 AND identite = ?');
//        $dt->execute(array($id));
//        $dt = $dt->fetch();
//        $dt = $dt['dt'];
//
//        $ps = $bdd->prepare('SELECT COUNT(*) AS ps FROM challenge_invite WHERE direct = 0 AND studio = 1 AND identite = ? AND pad_obligatoire = 0');
//        $ps->execute(array($id));
//        $ps = $ps->fetch();
//        $ps_2pts = $ps['ps'];
//
//        $ps = $bdd->prepare('SELECT COUNT(*) AS ps FROM challenge_invite WHERE direct = 0 AND studio = 1 AND identite = ? AND pad_obligatoire = 1');
//        $ps->execute(array($id));
//        $ps = $ps->fetch();
//        $ps_3pts = $ps['ps'];
//
//        $ps = $ps_2pts + $ps_3pts;
//
//        $pt = $bdd->prepare('SELECT COUNT(*) AS pt FROM challenge_invite WHERE direct = 0 AND studio = 0 AND identite = ?');
//        $pt->execute(array($id));
//        $pt = $pt->fetch();
//        $pt = $pt['pt'];
//
//        $total_calees = $bdd->prepare('SELECT COUNT(*) AS total_calees FROM challenge_invite WHERE caleur_id = ?');
//        $total_calees->execute(array($id));
//        $total_calees = $total_calees->fetch();
//        $total_calees = $total_calees['total_calees'];
//
//        $ds_calees = $bdd->prepare('SELECT COUNT(*) AS ds_calees FROM challenge_invite WHERE caleur_id = ? AND direct = 1 AND studio = 1');
//        $ds_calees->execute(array($id));
//        $ds_calees = $ds_calees->fetch();
//        $ds_calees = $ds_calees['ds_calees'];
//
//        $pts = $bdd->prepare('SELECT pts FROM challenge_invite_points WHERE id_intervieweur = ?');
//        $pts->execute(array($id));
//        $pts = $pts->fetch();
//        $pts = $pts['pts'];
//
//        $resultats[$id] = array(
//            'prenom_intervieweur' => $prenom_intervieweur,
//            'total' => $total,
//            'direct_studio' => $ds,
//            'direct_telephone' => $dt,
//            'pad_studio' => $ps,
//            'pad_telephone' => $pt,
//            'ps_2pts' => $ps_2pts,
//            'ps_3pts' => $ps_3pts,
//            'total_calees' => $total_calees,
//            'ds_calees' => $ds_calees,
//            'pts' => $pts
//        );
//    }
//    return $resultats;
//}
//
//function updateCiResults($bdd) {
//    $boucle_resultats = getCiResults($bdd);
//
//    foreach ($boucle_resultats as $id => $resultats) {
//
//        $pts = 0;
//        $pts_ds = ($resultats['direct_studio'] / $resultats['total']) * 3; // Les ds valent 3, au ratio du total réalisé.
//        $pts_dt = ($resultats['direct_telephone'] / $resultats['total']) * 2; // Les dt valent 2, au ratio du total réalisé.
//        $pts_pt = ($resultats['pad_telephone'] / $resultats['total']); // Les pt valent 1, au ratio du total réalisé.
//        $pts_ps2 = ($resultats['ps_2pts'] / $resultats['total']) * 2; // Le PAD studio vaut 2.
//        $pts_ps3 = ($resultats['ps_3pts'] / $resultats['total']) * 3; // Et quand le PAD était obligatoire, ça vaut 3.
//
//        $pts = $pts_ps2 + $pts_ds + $pts_dt + $pts_pt + $pts_ps3;
//
//        if ($resultats['total_calees'] > 0) { // On vérifie d'abord que la personne a calé des interviews pour éviter de faire une division par 0.
//            $pts_bonus_calage = ($resultats['ds_calees'] / $resultats['total_calees']);
//            $pts = $pts + $pts_bonus_calage;
//        }
//
//        $pts = $pts * 100;
//
//        $query = $bdd->prepare('UPDATE challenge_invite_points SET pts = :pts WHERE id_intervieweur = :id');
//        $query->execute(array(
//            'pts' => $pts,
//            'id' => $id
//        ));
//    }
//}

function selectCiUser($bdd, $id, $service_id) {
    $setIdentity = getUserIdentity($bdd, $id); //Si un utilisateur a déjà été saisi.
    $query = $bdd->prepare('SELECT prenom, id, nom FROM personnel_fbln WHERE service_id = ? AND actif = 1 ORDER BY prenom');
    $query->execute(array($service_id));
    while ($identite = $query->fetch()) {
        if ($setIdentity['id'] == $identite['id']) {
            echo '<option value="' . $identite['id'] . '" selected>' . $identite['prenom'] . ' ' . substr($identite['nom'], 0, 1) . '.</option>';
        } else {
            echo '<option value="' . $identite['id'] . '">' . $identite['prenom'] . ' ' . substr($identite['nom'], 0, 1) . '.</option>';
        }
    }
}

function setCiResults($bdd, $identite, $studio, $direct, $nom, $caleur_id, $pad_obligatoire, $date_invite, $saison_id) {
    $query = $bdd->prepare('INSERT INTO challenge_invite (identite, studio, direct, nom, caleur_id, pad_obligatoire, date_invite, saison_id) VALUES (:identite, :studio, :direct, :nom, :caleur_id, :pad_obligatoire, :date_invite, :saison_id)');
    $query->execute(array(
        'identite' => $identite,
        'studio' => $studio,
        'direct' => $direct,
        'nom' => $nom,
        'caleur_id' => $caleur_id,
        'pad_obligatoire' => $pad_obligatoire,
        'date_invite' => $date_invite,
        'saison_id' => $saison_id
    ));
}

function getCiLastInvite($bdd) {
    $query = $bdd->query('SELECT i.nom nom_invite, i.date_invite, p.prenom, p.nom nom_intervieweur FROM challenge_invite i JOIN personnel_fbln p ON i.identite = p.id ORDER BY date_invite DESC LIMIT 1');
    return $query->fetch();
}

function getCiInvite($bdd, $season, $identite) {
    $query = $bdd->prepare('SELECT nom, direct, studio, date_invite, pad_obligatoire FROM challenge_invite WHERE identite = :identite AND saison_id = :season ORDER BY date_invite DESC');
    $query->execute(array(
        'identite' => $identite,
        'season' => $season
    ));
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function getCiCalages($bdd, $season, $caleur_id) {
    $query = $bdd->prepare('SELECT nom, direct, studio, date_invite, pad_obligatoire FROM challenge_invite WHERE caleur_id = :caleur_id AND saison_id = :season ORDER BY date_invite DESC');
    $query->execute(array(
        'caleur_id' => $caleur_id,
        'season' => $season
    ));
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function getCiAllGuests($bdd, $season) {
    $query = $bdd->prepare('SELECT i.nom, i.studio, i.direct, i.pad_obligatoire, i.date_invite, p1.prenom prenom_itw, p1.nom nom_itw, p2.prenom prenom_caleur, p2.nom nom_caleur FROM challenge_invite i JOIN personnel_fbln p1 ON i.identite = p1.id JOIN personnel_fbln p2 ON i.caleur_id = p2.id WHERE saison_id = :season ORDER BY date_invite DESC');
    $query->execute(array(
        'season' => $season
    ));
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
