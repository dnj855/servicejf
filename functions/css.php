<?php

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
