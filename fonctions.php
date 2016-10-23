<?php

function Pourcentage($Nombre, $Total) {
    return round($Nombre * 100 / $Total, 2);
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

function cssGetAlreadySetInfos($bdd, $id) { // Cette fonction transforme une id de journée en ses données, si existantes.
    $query = $bdd->prepare('SELECT * FROM soirees_foot WHERE id_journee = ?');
    $query->execute(array($id));
    $infos = $query->fetch();
    return $infos;
}
