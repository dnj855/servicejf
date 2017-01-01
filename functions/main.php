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

function ratio($valeur, $total) {
    $resultat = $valeur / $total;
    return $resultat;
}

function getCdrb($bdd) {
    $query = $bdd->query('SELECT * FROM cdrb ORDER BY id');
    $pronostics = $query->fetchAll();
    return $pronostics;
}

function getEcart($value1, $value2) {
    return abs($value1 - $value2);
}
