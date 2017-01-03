<?php

if (!$cph_include) {
    header('location:../index.php');
}

if (!checkCphRegistration($bdd, $_SESSION['id']) && checkCphBegin($bdd)) {
    include('view_ranking.php');
} elseif (!checkCphRegistration($bdd, $_SESSION['id'])) { // On vérifie si l'utilisateur s'est déjà inscrit au challenge ou non.
    if ($_POST) { // On vérifie si on vient sur la page par le formulaire (POST) ou pas (GET).
        if ($_POST['checked_final_bet']) { // Si on vient de la page de validation du choix, on traite.
            $query = $bdd->prepare('INSERT INTO cph_final_bet (better_id, final_bet) VALUES (:better_id, :final_bet)');
            $query->execute(array(
                'better_id' => $_SESSION['id'],
                'final_bet' => $_POST['checked_final_bet']
            ));
            $query = $bdd->prepare('INSERT INTO cph_score (better_id) VALUES (:better_id)');
            $query->execute(array(
                'better_id' => $_SESSION['id']
            ));
            include('view_ranking.php');
        } elseif (!$_POST['final_bet']) { // On vérifie ensuite si on a fait un choix dans la liste ou pas.
            $error = 'no_choice'; // Si non, on active les messages d'erreur et on inclut le formulaire.
            include('set_final_bet.php');
        } else { // Si oui, on renvoie vers la page de vérification du choix.
            $final_bet = getCphTeams($bdd, $_POST['final_bet']);
            include('check_final_bet.php');
        }
    } else {
        include('set_final_bet.php');
    }
} else {
    include('view_ranking.php');
}