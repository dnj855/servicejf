<?php

$cp_date_butoir = new DateTime('2017-04-19');
$cp_date_debut = new DateTime('2017-03-22');

function getCpCandidates($bdd) {
    $query = $bdd->query('SELECT * FROM cp_candidates ORDER BY nom');
    return $query->fetchAll();
}

function getCpFinalBet($bdd, $better_id) {
    $query = $bdd->prepare('SELECT c.nom, c.prenom, c.id FROM cp_final_bet b JOIN cp_candidates c ON b.bet = c.id WHERE b.better_id = :id');
    $query->execute(array(
        'id' => $better_id
    ));
    return $query->fetch();
}

function checkCpIfDefinitive($bdd, $better_id) {
    $query = $bdd->prepare('SELECT * FROM cp_definitive_bet WHERE better_id = :id');
    $query->execute(array(
        'id' => $better_id
    ));
    return $query->fetch();
}

function setCpFinalBet($bdd, $better_id, $bet) {
    $query = $bdd->prepare('INSERT INTO cp_final_bet (better_id, bet) VALUES (:better_id, :bet)');
    $query->execute(array(
        'bet' => $bet,
        'better_id' => $better_id
    ));
}

function deleteCpFinalBet($bdd, $better_id) {
    $query = $bdd->prepare('DELETE FROM cp_final_bet WHERE better_id = :better_id');
    $query->execute(array(
        'better_id' => $better_id
    ));
}

function getCpOrderedBets($bdd, $better_id) {
    $query = $bdd->prepare('SELECT c.nom, c.prenom, b.bet_rank, c.id FROM cp_bets b JOIN cp_candidates c ON b.bet_value = c.id WHERE b.better_id = :better_id ORDER BY b.bet_rank');
    $query->execute(array(
        'better_id' => $better_id
    ));
    return $query->fetchAll();
}

function getCpCandidatesAmount($bdd) {
    $query = $bdd->query('SELECT COUNT(*) as candidates_amount FROM cp_candidates');
    $candidates_amount = $query->fetch();
    return $candidates_amount['candidates_amount'];
}

function checkCpIfRemainsBets($bdd, $better_id) {
    $candidates_amount = getCpCandidatesAmount($bdd);
    $query = $bdd->prepare('SELECT COUNT(*) as bets_amount FROM cp_bets WHERE better_id = :better_id');
    $query->execute(array(
        'better_id' => $better_id
    ));
    $bets_amount = $query->fetch();
    $bets_amount = $bets_amount['bets_amount'];
    return $candidates_amount - $bets_amount;
}

function getCpCandidatesWithoutAlreadyBet($bdd, $better_id) {
    $bets = getCpOrderedBets($bdd, $better_id);
    $i = 0;
    foreach ($bets as $bet) {
        $params[$i] = $bet['id'];
        $i++;
    }
    $place_holders = implode(',', array_fill(0, count($params), '?')); // Ici j'utilise la méthode présentée dans l'exemple 5 de cette page : http://php.net/manual/fr/pdostatement.execute.php
    $already_bet = implode(",", $already_bet);
    $query = $bdd->prepare('SELECT * FROM cp_candidates WHERE id NOT IN (' . $place_holders . ') ORDER BY nom');
    $query->execute($params);
    return $query->fetchAll();
}

function setCpBet($bdd, $better_id, $bet_value, $bet_rank) {
    $query = $bdd->prepare('INSERT INTO cp_bets (better_id, bet_value, bet_rank) VALUES (:better_id, :bet_value, :bet_rank)');
    $query->execute(array(
        'better_id' => $better_id,
        'bet_rank' => $bet_rank,
        'bet_value' => $bet_value
    ));
}

function checkCpViewBetsAutorization($bdd, $better_id, $date_butoir) {
    $now = new DateTime();
    if (checkCpIfDefinitive($bdd, $better_id)) {
        return 1;
    } elseif ($now > $date_butoir) {
        return 1;
    } else {
        return 0;
    }
}

function validateBet($bdd, $better_id) {
    $query = $bdd->prepare('INSERT INTO cp_definitive_bet (better_id, date) VALUES (:better_id, NOW())');
    $query->execute(array(
        'better_id' => $better_id
    ));
    return 1;
}

function getCpFinalValidationDate($bdd, $better_id) {
    $query = $bdd->prepare('SELECT date FROM cp_definitive_bet WHERE better_id = :better_id');
    $query->execute(array(
        'better_id' => $better_id
    ));
    $result = $query->fetch();
    if ($result['date']) {
        $date = new DateTime($result['date']);
    } else {
        $date = 0;
    }
    return $date;
}

function checkCpSituation($bdd, $better_id, $now, $cp_date_debut, $cp_date_butoir) {
    $definitive = checkCpIfDefinitive($bdd, $better_id);
    $secondLeg = checkCpIfSecondLeg($bdd);
    if ($_SESSION['actif']) {
        if ($now < $cp_date_debut) {
            return 'before_beginning';
        } elseif ($secondLeg == 1) {
            return 'betweentwolegs';
        } elseif ($secondLeg == 2) {
            return 'aftersecondleg';
        } elseif ($now >= $cp_date_debut && !$definitive) {
            return 'play_without_definitive';
        } elseif ($now >= $cp_date_debut && $definitive) {
            return 'play_with_definitive';
        }
    } elseif (!$_SESSION['actif'] && $now < $cp_date_debut) {
        return 'before_beginning';
    } elseif (!$_SESSION['actif'] && $secondLeg == 1) {
        return 'betweentwolegs';
    } elseif (!$_SESSION['actif'] && $secondLeg == 2) {
        return 'aftersecondleg';
    } else {
        return 'inactive';
    }
}

function getCpDatePoints($now) {
    $periode1 = new DateTime('2017-03-27');
    $periode2 = new DateTime('2017-04-03');
    $periode3 = new DateTime('2017-04-10');
    $periode4 = new DateTime('2017-04-17');
    $periode5 = new DateTime('2017-04-19');
    if ($now < $periode1) {
        return 16;
    } elseif ($now < $periode2) {
        return 15;
    } elseif ($now < $periode3) {
        return 13;
    } elseif ($now < $periode4) {
        return 11;
    } elseif ($now <= $periode5) {
        return 10;
    }
}

function deleteCpBet($bdd, $better_id, $rank) {
    $query = $bdd->prepare('DELETE FROM cp_bets WHERE better_id = :better_id AND bet_rank >= :rank');
    $query->execute(array(
        'better_id' => $better_id,
        'rank' => $rank
    ));
    return 1;
}

function getCpBetters($bdd) {
    $query = $bdd->query('SELECT DISTINCT b.better_id, u.prenom, u.nom FROM cp_bets b JOIN personnel_fbln u ON b.better_id = u.id ORDER BY u.nom');
    return $query->fetchAll();
}

function checkCpIfRemainsResults($bdd) {
    $candidates_amount = getCpCandidatesAmount($bdd);
    $query = $bdd->query('SELECT COUNT(*) as results_amount FROM cp_results');
    $results_amount = $query->fetch();
    $results_amount = $results_amount['results_amount'];
    return $candidates_amount - $results_amount;
}

function getCpOrderedResults($bdd) {
    $query = $bdd->query('SELECT c.nom, c.prenom, r.rank, c.id FROM cp_results r JOIN cp_candidates c ON r.candidate = c.id ORDER BY r.rank');
    return $query->fetchAll();
}

function getCpResultsWithoutAlreadySet($bdd) {
    $results = getCpOrderedResults($bdd);
    $i = 0;
    foreach ($results as $result) {
        $params[$i] = $result['id'];
        $i++;
    }
    $place_holders = implode(',', array_fill(0, count($params), '?')); // Ici j'utilise la méthode présentée dans l'exemple 5 de cette page : http://php.net/manual/fr/pdostatement.execute.php
    $already_result = implode(",", $already_result);
    $query = $bdd->prepare('SELECT * FROM cp_candidates WHERE id NOT IN (' . $place_holders . ') ORDER BY nom');
    $query->execute($params);
    return $query->fetchAll();
}

function setCpResult($bdd, $value, $rank) {
    $query = $bdd->prepare('INSERT INTO cp_results (candidate, rank) VALUES (:value, :rank)');
    $query->execute(array(
        'rank' => $rank,
        'value' => $value
    ));
}

function deleteCpResult($bdd, $rank) {
    $query = $bdd->prepare('DELETE FROM cp_results WHERE rank >= :rank');
    $query->execute(array(
        'rank' => $rank
    ));
    return 1;
}

function getCpBetPoints($bdd, $better_id, $results) {
    $bets = getCpOrderedBets($bdd, $better_id);
    $points['duo_points'] = 0;
    if ($results[0]['id'] == $bets[0]['id'] && $results[1]['id'] == $bets[1]['id']) { // On vérifie d'abord les points pour le duo de tête. Dans l'ordre et le désordre.
        $points['duo_points'] = 5;
    } elseif ($results[0]['id'] == $bets[1]['id'] && $results[1]['id'] == $bets[0]['id']) {
        $points['duo_points'] = 2;
    }
    $points['bet_points'] = 0;
    if ($points['duo_points'] != 0) {
        for ($i = 2;; $i++) { // On vérifie ensuite les points à partir du 3è candidat.
            if ($results[$i]['id'] == $bets[$i]['id']) {
                $points['bet_points'] = $points['bet_points'] + 2; // Tant que c'est bon, on descend d'un cran.
            } else {
                break; // En revanche, dès qu'il y a une erreur, on ne va pas plus loin.
            }
        }
    }
    $points['coeff_points'] = getCpDatePoints(getCpFinalValidationDate($bdd, $better_id)); // Ensuite on va chercher le coeff des points.

    return $points;
}

function setCpBetPoints($bdd, $better_id, $results) {
    $points = getCpBetPoints($bdd, $better_id, $results);
    $score = ($points['duo_points'] + $points['bet_points']) * $points['coeff_points'];
    $query = $bdd->prepare('INSERT INTO cp_points (better_id, duo_points, bet_points, coeff_points, score) VALUES (:better_id, :duo_points, :bet_points, :coeff_points, :score)');
    $query->execute(array(
        'better_id' => $better_id,
        'duo_points' => $points['duo_points'],
        'bet_points' => $points['bet_points'],
        'coeff_points' => $points['coeff_points'],
        'score' => $score
    ));
    return 1;
}

function checkCpIfSecondLeg($bdd) {
    $query = $bdd->query('SELECT * FROM cp_points WHERE final_points IS NULL');
    $subquery = $bdd->query('SELECT * FROM cp_points WHERE final_points = 0');
    if ($query->fetch()) {
        return 1;
    } elseif ($subquery->fetch()) {
        return 2;
    } else {
        return 0;
    }
}

function getCpRanking($bdd) {
    $query = $bdd->query('SELECT * FROM cp_points b JOIN personnel_fbln p ON b.better_id = p.id ORDER BY b.score DESC');
    return $query->fetchAll();
}

function getCpPoints($bdd, $better_id) {
    $query = $bdd->prepare('SELECT * FROM cp_points WHERE better_id = :better_id');
    $query->execute(array(
        'better_id' => $better_id
    ));
    return $query->fetch();
}

function setCpFinalPoints($bdd, $better_id, $final_points) {
    $points = getCpPoints($bdd, $better_id);
    $score = ($points['duo_points'] + $points['bet_points'] + $final_points) * $points['coeff_points'];
    $query = $bdd->prepare('UPDATE cp_points SET final_points = :final_points, score = :score WHERE better_id=:better_id');
    $query->execute(array(
        'score' => $score,
        'better_id' => $better_id,
        'final_points' => $final_points
    ));
    return 1;
}

function setCpFinalWinner($bdd, $final_winner) {
    $query = $bdd->prepare('UPDATE cp_results SET final_winner = 1 WHERE candidate = :candidate');
    $query->execute(array(
        'candidate' => $final_winner
    ));
    return 1;
}

function getCpFinalWinner($bdd) {
    $query = $bdd->query('SELECT c.prenom, c.nom, r.candidate id FROM cp_results r JOIN cp_candidates c ON r.candidate = c.id WHERE final_winner = 1');
    return $query->fetch();
}
