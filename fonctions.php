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
