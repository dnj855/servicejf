<?php

function Pourcentage($Nombre, $Total) {
    return round($Nombre * 100 / $Total, 2);
}

function dateFrtoUs($date) {
    $newDate = preg_replace('#^([0-9]{2})/([0-9]{2})/([0-9]{4})$#', '$3-$2-$1 00:00:00', $date);
    return $newDate;
}

function hash_password($password) {
// 256 bits random string
    $salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));

// prepend salt then hash
    $hash = hash("sha256", $password . $salt);

// return salt and hash in the same string
    return $salt . $hash;
}

function check_password($password, $dbhash) {
// get salt from dbhash
    $salt = substr($dbhash, 0, 64);

// get the SHA256 hash
    $valid_hash = substr($dbhash, 64, 64);

// hash the password
    $test_hash = hash("sha256", $password . $salt);

// test
    return $test_hash === $valid_hash;
}

function getUserIdentity($bdd, $id) { // Cette fonction transforme un id utilisateur en ses données perso.
    $query = $bdd->prepare('SELECT * FROM personnel_fbln WHERE id = ?');
    $query->execute(array($id));
    $auteur_message = $query->fetch();
    return $auteur_message;
}

function getTeamIdentity($bdd, $id) { // Cette fonction transforme un id équipe en ses données perso.
    $query = $bdd->prepare('SELECT nom FROM soirees_foot_equipes WHERE id = ?');
    $query->execute(array($id));
    $team = $query->fetch();
    return $team['nom'];
}

function cssGetAlreadySetInfos($bdd, $id) { // Cette fonction transforme une id de journée en ses données, si existantes.
    $query = $bdd->prepare('SELECT * FROM soirees_foot WHERE id_journee = ?');
    $query->execute(array($id));
    $infos = $query->fetch();
    return $infos;
}

function selectUserSansCadre($bdd, $id, $service_id) {
    $setIdentity = getUserIdentity($bdd, $id); //Si un utilisateur a déjà été saisi.
    $query = $bdd->prepare('SELECT prenom, id FROM personnel_fbln WHERE service_id = ? AND actif = 1 AND cadre = 0 ORDER BY prenom');
    $query->execute(array($service_id));
    while ($identite = $query->fetch()) {
        if ($setIdentity['id'] == $identite['id']) {
            echo '<option value="' . $identite['id'] . '" selected>' . $identite['prenom'] . '</option>';
        } else {
            echo '<option value="' . $identite['id'] . '">' . $identite['prenom'] . '</option>';
        }
    }
}

function selectUserAvecCadre($bdd, $id, $service_id) {
    $setIdentity = getUserIdentity($bdd, $id); //Si un utilisateur a déjà été saisi.
    $query = $bdd->prepare('SELECT prenom, id FROM personnel_fbln WHERE service_id = ? AND actif = 1 ORDER BY prenom');
    $query->execute(array($service_id));
    while ($identite = $query->fetch()) {
        if ($setIdentity['id'] == $identite['id']) {
            echo '<option value="' . $identite['id'] . '" selected>' . $identite['prenom'] . '</option>';
        } else {
            echo '<option value="' . $identite['id'] . '">' . $identite['prenom'] . '</option>';
        }
    }
}

function getTeams($bdd, $id) {
    $query = $bdd->prepare('SELECT equipe_home, equipe_away FROM soirees_foot WHERE id_journee = ? AND id_saison = 1');
    $query->execute(array($id));
    $equipe = $query->fetch();

    $equipe_home = getTeamIdentity($bdd, $equipe['equipe_home']);
    $equipe_away = getTeamIdentity($bdd, $equipe['equipe_away']);

    return array(
        "equipe_home" => $equipe_home,
        "equipe_away" => $equipe_away
    );
}

function setSessionVariables($bdd, $id) {
    $query = $bdd->prepare('SELECT * FROM personnel_fbln WHERE id = ?');
    $query->execute(array($id));
    $pseudo = $query->fetch();
    $_SESSION['id'] = $pseudo['id'];
    $_SESSION['prenom'] = $pseudo['prenom'];
    $_SESSION['nom'] = $pseudo['nom'];
    $_SESSION['admin'] = $pseudo['admin'];
    $_SESSION['service'] = $pseudo['service_id'];
    $_SESSION['css'] = $pseudo['css'];
    $_SESSION['cdrb'] = $pseudo['cdrb'];
}

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

function ratio($valeur, $total) {
    $resultat = $valeur / $total;
    return $resultat;
}

function getCdrb($bdd) {
    $query = $bdd->query('SELECT * FROM cdrb ORDER BY id');
    $pronostics = $query->fetchAll();
    return $pronostics;
}
