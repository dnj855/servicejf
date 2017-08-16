<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SESSION['css_season'] == 0) { // si on arrive sur la page via la navigation et qu'on n'a pas déjà choisi de saison, alors on débute le formulaire de choix de saison.
    include('form_saison.php');
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['season'] == 'reset_season') { // si on vient réinitialiser la saison choisie
    $_SESSION['css_season'] = 0;
    if ($_GET['action'] == 'write') {
        header('location:css.php?action=write'); // et on renvoie vers le formulaire de choix de saison, version saisie
    } else {
        header('location:css.php?action=read'); // ou version consultation
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'write' && $_POST['form_season']) { // si on y arrive depuis le formulaire de saison en mode saisie, plusieurs possibilités :
    if ($_POST['new_season']) { // 1. on vient de créer une nouvelle saison, on l'enregistre en bdd et on met en session l'id de saison correspondant.
        $_SESSION['css_season'] = createCssNewSeason($bdd, $_POST['new_season']);
        $_POST = 0;
        header('location:css.php?action=write'); // et on renvoie vers le formulaire de saisie
    } else { // 2. on ne crée pas de nouvelle saison, on met en session l'id de saison correspondant.
        $_SESSION['css_season'] = $_POST['season'];
        header('location:css.php?action=write'); // et on renvoie vers le formulaire de saisie
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'read') { // si on y arrive depuis un formulaire en mode consultation
    $_SESSION['css_season'] = $_POST['season']; // on enregistre l'id de saison correspondant
    header('location:css.php?action=read'); // et on renvoie vers la page de consultation
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['form_journee']) { // Si on vient du formulaire de création ou modification de journée...
    if (empty($_POST['technicien_id']) || empty($_POST['day']) || empty($_POST['team']) || empty($_POST['homeOrAway']) || $_POST['buts_fcmetz'] == "" || $_POST['buts_adversaire'] == "") { // On réalise les scripts de contrôle et on affecte les variables correspondantes aux erreurs.
        if (empty($_POST['technicien_id'])) {
            $alerte['technicien_id'] = 1;
        }
        if (empty($_POST['day'])) {
            $alerte['day'] = 1;
        }
        if (empty($_POST['team'])) {
            $alerte['team'] = 1;
        }
        if (empty($_POST['homeOrAway'])) {
            $alerte['homeOrAway'] = 1;
        }
        if ($_POST['buts_fcmetz'] == "") {
            $alerte['buts_fcmetz'] = 1;
        }
        if ($_POST['buts_adversaire'] == "") {
            $alerte['buts_adversaire'] = 1;
        }
    } else { // Si tout est bon, on enregistre en bdd et on envoie la variable 'no-alert', qui lance l'affichage de la confirmation dans 'form_journee'.
        setCssJournee($bdd, $_POST['technicien_id'], $_POST['day'], $_POST['team'], $_POST['homeOrAway'], $_POST['buts_fcmetz'], $_POST['buts_adversaire'], $_SESSION['css_season']);
        $alerte['no-alert'] = 1;
    }
    include('form_journee.php');
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') { // enfin, dernier cas de figure, on arrive par la navigation mais on a déjà sélectionné une saison
    include('form_journee.php');
}