<?php

if ($_SESSION['admin'] == 0) {
    header('location:index.php');
}

$betters = getCphAllBetters($bdd); // On récupère d'abord tous les parieurs.
$games = getCphPlayedGames($bdd); // Ainsi que tous les matches joués.

foreach ($games as $game) { // On lance une boucle pour chaque match.
    $game_ecart = getEcart($game['score_home'], $game['score_away']); // On calcule l'écart entre les scores du match.
    if (checkIfDrawPhase($bdd, $game['id'])) { // Ici, on distingue si on est en phase de poules ou en phase finale, car les barèmes ne sont pas les mêmes.
        foreach ($betters as $better) { // On lance une boucle par parieur et on initialise les points à 0.
            $points_resultat = 0;
            $points_resultat_final = 0;
            $points_ecart = 0;
            $points_bon_score = 0;
            if (!checkCphPointsByGame($bdd, $game['id'], $better['better_id'])) { // On regarde si des points ont déjà été attribués à ce parieur par le passé. Si non, on crée la ligne.
                setCphPointsByGame($bdd, $game['id'], $better['better_id']);
            }
            $bet = getCphGamesBet($bdd, $game['id'], $better['better_id']); // On irrigue la variable $bet avec le pari de ce parieur sur ce match. On peut maintenant lancer les comparaisons.
            if ($bet['result'] == $game['result']) {
                $points_resultat = 3;
            } // Si on veut conditionner le reste des points au bon résultat, il suffit de bouger cette accolade plus bas.

            $bet_ecart = getEcart($bet['score_home'], $bet['score_away']); // On calcule l'écart entre les scores pronostiqués.
            $game_bet_ecart = getEcart($bet_ecart, $game_ecart); // Enfin, on calcule l'écart entre le pronostic et la réalité.
            if ($bet['score_home']) { // On vérifie d'abord que quelque chose a bien été pronostiqué.
                if ($game_bet_ecart <= 1) { // Si l'écart pronostiqué est le bon ou presque (à 1 près).
                    $points_ecart = 3;
                } elseif ($game_bet_ecart > 1 && $game_bet_ecart <= 3) { // S'il est de 2 ou 3.
                    $points_ecart = 2;
                } elseif ($game_bet_ecart > 3 && $game_bet_ecart <= 5) { // S'il est de 4 ou 5.
                    $points_ecart = 1;
                }
            }

            if ($bet['score_home'] == $game['score_home'] && $bet['score_away'] == $game['score_away']) { // Enfin, on regarde si le parieur a le bon score.
                $points_bon_score = 3;
            }
            updatePointsByGame($bdd, $game['id'], $better['better_id'], $points_resultat, $points_resultat_final, $points_ecart, $points_bon_score); // Et on termine en inscrivant les points dans la BDD.
        }
    } elseif (checkIfFinalGame($bdd, $game['id'])) {
        foreach ($betters as $better) { // On lance une boucle par parieur et on initialise les points à 0.
            $points_resultat = 0;
            $points_resultat_final = 0;
            $points_ecart = 0;
            $points_bon_score = 0;
            if (!checkCphPointsByGame($bdd, $game['id'], $better['better_id'])) { // On regarde si des points ont déjà été attribués à ce parieur par le passé. Si non, on crée la ligne.
                setCphPointsByGame($bdd, $game['id'], $better['better_id']);
            }
            $bet = getCphGamesBet($bdd, $game['id'], $better['better_id']); // On irrigue la variable $bet avec le pari de ce parieur sur ce match. On peut maintenant lancer les comparaisons.
            if ($bet['result'] == $game['result']) {
                $points_resultat = 3;
            } // Si on veut conditionner le reste des points au bon résultat, il suffit de bouger cette accolade plus bas.

            if ($bet['winner'] == $game['winner']) {
                $points_resultat_final = 2;
            }

            $bet_ecart = getEcart($bet['score_home'], $bet['score_away']); // On calcule l'écart entre les scores pronostiqués.
            $game_bet_ecart = getEcart($bet_ecart, $game_ecart); // Enfin, on calcule l'écart entre le pronostic et la réalité.
            if ($bet['score_home']) { // On vérifie d'abord que quelque chose a bien été pronostiqué.
                if ($game_bet_ecart <= 1) { // Si l'écart pronostiqué est le bon ou presque (à 1 près).
                    $points_ecart = 3;
                } elseif ($game_bet_ecart > 1 && $game_bet_ecart <= 3) { // S'il est de 2 ou 3.
                    $points_ecart = 2;
                } elseif ($game_bet_ecart > 3 && $game_bet_ecart <= 5) { // S'il est de 4 ou 5.
                    $points_ecart = 1;
                }
            }

            if ($bet['score_home'] == $game['score_home'] && $bet['score_away'] == $game['score_away']) { // Enfin, on regarde si le parieur a le bon score.
                $points_bon_score = 3;
            }

            $final_bet = getCphIdFinalBet($bdd, $better['better_id']); // Les 5 points bonus pour le bon vainqueur final.
            $points_bonus_final = 0;
            if ($final_bet == $game['winner']) {
                $points_bonus_final = 5;
            }
            $query = $bdd->prepare('UPDATE cph_points SET points_final = :points_final WHERE better_id = :better_id AND game_id = :game_id');
            $query->execute(array(
                'points_final' => $points_bonus_final,
                'better_id' => $better['better_id'],
                'game_id' => $game['id']
            ));

            updatePointsByGame($bdd, $game['id'], $better['better_id'], $points_resultat, $points_resultat_final, $points_ecart, $points_bon_score); // Et on termine en inscrivant les points dans la BDD.
        }
    } else {
        foreach ($betters as $better) { // On lance une boucle par parieur et on initialise les points à 0.
            $points_resultat = 0;
            $points_resultat_final = 0;
            $points_ecart = 0;
            $points_bon_score = 0;
            if (!checkCphPointsByGame($bdd, $game['id'], $better['better_id'])) { // On regarde si des points ont déjà été attribués à ce parieur par le passé. Si non, on crée la ligne.
                setCphPointsByGame($bdd, $game['id'], $better['better_id']);
            }
            $bet = getCphGamesBet($bdd, $game['id'], $better['better_id']); // On irrigue la variable $bet avec le pari de ce parieur sur ce match. On peut maintenant lancer les comparaisons.
            if ($bet['result'] == $game['result']) {
                $points_resultat = 3;
            } // Si on veut conditionner le reste des points au bon résultat, il suffit de bouger cette accolade plus bas.

            if ($bet['winner'] == $game['winner']) {
                $points_resultat_final = 2;
            }

            $bet_ecart = getEcart($bet['score_home'], $bet['score_away']); // On calcule l'écart entre les scores pronostiqués.
            $game_bet_ecart = getEcart($bet_ecart, $game_ecart); // Enfin, on calcule l'écart entre le pronostic et la réalité.
            if ($bet['score_home']) { // On vérifie d'abord que quelque chose a bien été pronostiqué.
                if ($game_bet_ecart <= 1) { // Si l'écart pronostiqué est le bon ou presque (à 1 près).
                    $points_ecart = 3;
                } elseif ($game_bet_ecart > 1 && $game_bet_ecart <= 3) { // S'il est de 2 ou 3.
                    $points_ecart = 2;
                } elseif ($game_bet_ecart > 3 && $game_bet_ecart <= 5) { // S'il est de 4 ou 5.
                    $points_ecart = 1;
                }
            }

            if ($bet['score_home'] == $game['score_home'] && $bet['score_away'] == $game['score_away']) { // Enfin, on regarde si le parieur a le bon score.
                $points_bon_score = 3;
            }
            updatePointsByGame($bdd, $game['id'], $better['better_id'], $points_resultat, $points_resultat_final, $points_ecart, $points_bon_score); // Et on termine en inscrivant les points dans la BDD.
        }
    }
    updateCphRanking($bdd);
}
