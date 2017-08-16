<?php

function getTeamIdentity($bdd, $id) { // Cette fonction transforme un id équipe en ses données perso.
    $query = $bdd->prepare('SELECT nom FROM soirees_foot_equipes WHERE id = ?');
    $query->execute(array($id));
    $team = $query->fetch();
    return $team['nom'];
}

function cssGetAlreadySetInfos($bdd, $id_journee, $id_season) { // Cette fonction transforme une id de journée en ses données, si existantes.
    $query = $bdd->prepare('SELECT * FROM soirees_foot WHERE id_journee = :id_journee AND id_saison = :id_season');
    $query->execute(array(
        'id_journee' => $id_journee,
        'id_season' => $id_season
    ));
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

function getCssSeasons($bdd) {
    $query = $bdd->query('SELECT id, saison_debut, saison_fin FROM soirees_foot_saisons ORDER BY id desc');
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function getCssSeason($bdd, $id) {
    $query = $bdd->prepare('SELECT saison_debut, saison_fin FROM soirees_foot_saisons WHERE id = ?');
    $query->execute(array($id));
    $saison = $query->fetch();
    return $saison['saison_debut'] . '-' . $saison['saison_fin'];
}

function createCssNewSeason($bdd, $saison_debut) {
    $query = $bdd->prepare('INSERT INTO soirees_foot_saisons (saison_debut, saison_fin) VALUES (:saison_debut, :saison_fin)');
    $query->execute(array(
        'saison_debut' => $saison_debut,
        'saison_fin' => $saison_debut + 1
    ));
    $saisons = getCssSeasons($bdd);
    return $saisons[0]['id'];
}

function getCssAlreadySetDay($bdd, $season) {
    $query = $bdd->prepare('SELECT id_journee FROM soirees_foot WHERE id_saison = :id_saison ORDER BY id_journee ASC');
    $query->execute(array(
        'id_saison' => $season
    ));
    return $query->fetchAll(PDO::FETCH_COLUMN, 0); // avec cet attribut, on ne récupère que la colonne id_journée
}

function getCssRemainingDays($bdd, $season) {
    $query = $bdd->prepare('SELECT id_journee FROM soirees_foot WHERE id_saison = :id_saison');
    $query->execute(array(
        'id_saison' => $season
    ));
    $alreadyFilledDays = $query->fetchAll(PDO::FETCH_COLUMN, 0);
    $normalDays = range(1, 38);
    return array_diff($normalDays, $alreadyFilledDays);
}

function getCssTeamsNames($bdd, $day, $season) {
    if ($day) {
        $dayInfos = cssGetAlreadySetInfos($bdd, $day, $season);
        if ($dayInfos['equipe_home'] != 11) {
            $team = $dayInfos['equipe_home'];
        } else {
            $team = $dayInfos['equipe_away'];
        }
    }
    $query = $bdd->query('SELECT * FROM soirees_foot_equipes WHERE id != 11 ORDER BY actif DESC, nom');
    while ($names = $query->fetch()) {
        if ($names['id'] == $team) {
            echo '<option value="' . $names['id'] . '" selected>' . $names['nom'] . '</option>';
        } else {
            echo '<option value="' . $names['id'] . '">' . $names['nom'] . '</option>';
        }
    }
}

function getCssTeamsNamesWithPost($bdd, $post) {
    $query = $bdd->query('SELECT * FROM soirees_foot_equipes WHERE id != 11 ORDER BY actif DESC, nom');
    while ($names = $query->fetch()) {
        if ($names['id'] == $post) {
            echo '<option value="' . $names['id'] . '" selected>' . $names['nom'] . '</option>';
        } else {
            echo '<option value="' . $names['id'] . '">' . $names['nom'] . '</option>';
        }
    }
}

function setCssJournee($bdd, $id_technicien, $id_journee, $team, $homeOrAway, $buts_fcmetz, $buts_adversaire, $id_saison) {
    $query = $bdd->prepare('SELECT id FROM soirees_foot WHERE id_saison = :id_saison AND id_journee = :id_journee');
    $query->execute(array(
        'id_saison' => $id_saison,
        'id_journee' => $id_journee
    ));
    $journee = $query->fetch();
    if ($journee == FALSE) { // Si la journée n'existait pas encore, on la crée. Sinon, on saute le 'if' et on passe directement à la modif.
        $query2 = $bdd->prepare('INSERT INTO soirees_foot (id_saison, id_journee) VALUES (:id_saison, :id_journee)');
        $query2->execute(array(
            'id_saison' => $id_saison,
            'id_journee' => $id_journee
        ));
    }
    if ($homeOrAway == 'home') {
        $equipe_home = 11;
        $equipe_away = $team;
    } else {
        $equipe_home = $team;
        $equipe_away = 11;
    }
    if ($buts_adversaire == $buts_fcmetz) {
        $pts_fcmetz = 1;
    } elseif ($buts_adversaire > $buts_fcmetz) {
        $pts_fcmetz = 0;
    } else {
        $pts_fcmetz = 3;
    }
    $query = $bdd->prepare('UPDATE soirees_foot SET id_technicien = :id_technicien, equipe_home = :equipe_home, equipe_away = :equipe_away, pts_fcmetz = :pts_fcmetz, buts_fcmetz = :buts_fcmetz, buts_adversaire = :buts_adversaire WHERE id_saison = :id_saison AND id_journee = :id_journee');
    $query->execute(array(
        'id_saison' => $id_saison,
        'id_journee' => $id_journee,
        'id_technicien' => $id_technicien,
        'equipe_home' => $equipe_home,
        'equipe_away' => $equipe_away,
        'pts_fcmetz' => $pts_fcmetz,
        'buts_fcmetz' => $buts_fcmetz,
        'buts_adversaire' => $buts_adversaire
    ));
}

function selectCssTechnicien($bdd, $id, $service_id) {
    $query = $bdd->prepare('SELECT prenom, id, LEFT(nom, 1) nom FROM personnel_fbln WHERE service_id = ? AND cadre = 0 ORDER BY prenom');
    $query->execute(array($service_id));
    if ($id) {
        $setIdentity = getUserIdentity($bdd, $id);
    }//Si un utilisateur a déjà été saisi.
    while ($identite = $query->fetch()) {
        if ($setIdentity['id'] == $identite['id']) {
            echo '<option value="' . $identite['id'] . '" selected>' . $identite['prenom'] . ' ' . $identite['nom'] . '.</option>';
        } else {
            echo '<option value="' . $identite['id'] . '">' . $identite['prenom'] . ' ' . $identite['nom'] . '.</option>';
        }
    }
}

function selectCssAllPlayers($bdd, $id_saison) {
    $query = $bdd->prepare('SELECT DISTINCT p.id, prenom, nom FROM soirees_foot ss JOIN personnel_fbln p ON ss.id_technicien = p.id WHERE id_saison = :id_saison');
    $query->execute(array(
        'id_saison' => $id_saison
    ));
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function getCssDirectedGames($bdd, $id_technicien, $id_saison) {
    $query = $bdd->prepare('SELECT COUNT(*) FROM soirees_foot WHERE id_technicien = :id_technicien AND id_saison = :id_saison');
    $query->execute(array(
        'id_saison' => $id_saison,
        'id_technicien' => $id_technicien
    ));
    return $query->fetch(PDO::FETCH_COLUMN, 0);
}

function getCssClassementGeneral($bdd, $id_saison) {
    $allPlayers = selectCssAllPlayers($bdd, $id_saison); // D'abord on récupère la liste des réalisateurs concernés par la saison.
    foreach ($allPlayers as $player) { // Ici on récupère, traite et stocke les différentes données.
        $directedGames[$player['id']] = getCssDirectedGames($bdd, $player['id'], $id_saison);
        $query = $bdd->prepare('SELECT COUNT(*) FROM soirees_foot WHERE id_technicien = :id_technicien AND id_saison = :id_saison AND pts_fcmetz = 3');
        $query->execute(array(
            'id_technicien' => $player['id'],
            'id_saison' => $id_saison
        ));
        $nb_victoires[$player['id']] = $query->fetch(PDO::FETCH_COLUMN, 0);
        $prenom[$player['id']] = $player['prenom'];
        $nom[$player['id']] = $player['nom'];
        $players[$player['id']] = round(($nb_victoires[$player['id']] / $directedGames[$player['id']]) * 100, 0);
    }
    arsort($players); // Puis on classe les réalisateurs en fonction des points marqués.
    foreach ($players as $id => $player) { // Enfin on réattribue les données "annexes" à chaque réalisateur.
        $realisateurs[$id]['points'] = $player;
        $realisateurs[$id]['directed_games'] = $directedGames[$id];
        $realisateurs[$id]['nb_victoires'] = $nb_victoires[$id];
        $realisateurs[$id]['prenom'] = $prenom[$id];
        $realisateurs[$id]['nom'] = $nom[$id];
    }
    return $realisateurs;
}

function getCssClassementParPoints($bdd, $id_saison) {
    $allPlayers = selectCssAllPlayers($bdd, $id_saison); // D'abord on récupère la liste des réalisateurs concernés par la saison.
    foreach ($allPlayers as $player) { // Ici on récupère, traite et stocke les différentes données.
        $directedGames[$player['id']] = getCssDirectedGames($bdd, $player['id'], $id_saison);
        $query = $bdd->prepare('SELECT SUM(pts_fcmetz) FROM soirees_foot WHERE id_technicien = :id_technicien AND id_saison = :id_saison');
        $query->execute(array(
            'id_technicien' => $player['id'],
            'id_saison' => $id_saison
        ));
        $sumPoints[$player['id']] = $query->fetch(PDO::FETCH_COLUMN, 0);
        $prenom[$player['id']] = $player['prenom'];
        $nom[$player['id']] = $player['nom'];
        $players[$player['id']] = round($sumPoints[$player['id']] / $directedGames[$player['id']], 2);
    }
    arsort($players); // Puis on classe les réalisateurs en fonction des points marqués.
    foreach ($players as $id => $player) { // Enfin on réattribue les données "annexes" à chaque réalisateur.
        $realisateurs[$id]['points'] = $player;
        $realisateurs[$id]['prenom'] = $prenom[$id];
        $realisateurs[$id]['nom'] = $nom[$id];
    }
    return $realisateurs;
}

function getCssClassementDifferenceDeButs($bdd, $id_saison) {
    $allPlayers = selectCssAllPlayers($bdd, $id_saison); // D'abord on récupère la liste des réalisateurs concernés par la saison.
    foreach ($allPlayers as $player) { // Ici on récupère, traite et stocke les différentes données.
        $query = $bdd->prepare('SELECT SUM(buts_fcmetz) metz, SUM(buts_adversaire) adv FROM soirees_foot WHERE id_technicien = :id_technicien AND id_saison = :id_saison');
        $query->execute(array(
            'id_technicien' => $player['id'],
            'id_saison' => $id_saison
        ));
        $buts = $query->fetch();
        $prenom[$player['id']] = $player['prenom'];
        $nom[$player['id']] = $player['nom'];
        $players[$player['id']] = $buts['metz'] - $buts['adv'];
    }
    arsort($players); // Puis on classe les réalisateurs en fonction des points marqués.
    foreach ($players as $id => $player) { // Enfin on réattribue les données "annexes" à chaque réalisateur.
        $realisateurs[$id]['points'] = $player;
        $realisateurs[$id]['prenom'] = $prenom[$id];
        $realisateurs[$id]['nom'] = $nom[$id];
    }
    return $realisateurs;
}

function getCssGamesByDirector($bdd, $id_realisateur, $id_saison) {
    $query = $bdd->prepare
            ('SELECT id_journee, equipe_home, h.nom team_home, a.nom team_away, buts_fcmetz, buts_adversaire, pts_fcmetz FROM soirees_foot LEFT JOIN soirees_foot_equipes h ON h.id = equipe_home RIGHT JOIN soirees_foot_equipes a ON a.id = equipe_away WHERE id_technicien = :id_technicien AND id_saison = :id_saison');
    $query->execute(array(
        'id_saison' => $id_saison,
        'id_technicien' => $id_realisateur
    ));
    $results = $query->fetchAll();
    foreach ($results as $id => $result) {
        if ($result['equipe_home'] == 11) {
            $results[$id]['buts_home'] = $result['buts_fcmetz'];
            $results[$id]['buts_away'] = $result['buts_adversaire'];
        } else {
            $results[$id]['buts_home'] = $result['buts_adversaire'];
            $results[$id]['buts_away'] = $result['buts_fcmetz'];
        }
    }
    return $results;
}

function getCssDirectorInfos($bdd, $id_realisateur, $id_saison) {
    $infos['identity'] = getUserIdentity($bdd, $id_realisateur);
    $general = getCssClassementGeneral($bdd, $id_saison);
    $infos['general'] = array_search($id_realisateur, array_keys($general)) + 1;
    $points = getCssClassementParPoints($bdd, $id_saison);
    $infos['points'] = array_search($id_realisateur, array_keys($points)) + 1;
    $average = getCssClassementDifferenceDeButs($bdd, $id_saison);
    $infos['average'] = array_search($id_realisateur, array_keys($average)) + 1;
    $infos['general_points'] = $general[$id_realisateur]['points'];
    $infos['points_points'] = $points[$id_realisateur]['points'];
    $infos['average_points'] = $average[$id_realisateur]['points'];
    $infos['matchs'] = getCssGamesByDirector($bdd, $id_realisateur, $id_saison);
    return $infos;
}
