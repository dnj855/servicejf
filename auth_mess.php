<?php

session_start();
include('functions/main.php');
include('functions/css.php');
include('functions/fg.php');
include('functions/ci.php');
include('functions/cph.php');
setlocale(LC_TIME, "fr_FR");
$mois = array(
    '01' => 'janvier',
    '02' => 'février',
    '03' => 'mars',
    '04' => 'avril',
    '05' => 'mai',
    '06' => 'juin',
    '07' => 'juillet',
    '08' => 'août',
    '09' => 'septembre',
    '10' => 'octobre',
    '11' => 'novembre',
    '12' => 'décembre');
$now = new DateTime();


//Dans cette page, on va d'abord se connecter à la BDD pour mettre à jour, si besoin, le nombre de messages non-lus.
//Et on en profite pour cherche les infos dont on a besoin.
include('auth_inc_connectdb.php');

$query = $bdd->prepare('SELECT id_sender, id_receiver, titre, message, DATE_FORMAT(date_message, \'%d/%m/%Y\') AS date_message FROM mess WHERE id = ?');
$query->execute(array($_GET['id']));
$query = $query->fetch();

//On récupère les infos du message en question et on les stocke dans des variables.

$auteur_id = $query['id_sender'];
$expediteur_id = $query['id_receiver'];
$mess_titre = $query['titre'];
$mess_texte = nl2br(htmlspecialchars($query['message']));
$mess_date = $query['date_message'];

//On récupère l'identité grâce à la fonction idoine.

$auteur = getUserIdentity($bdd, $auteur_id);

$auteur_prenom = $auteur['prenom'];
$auteur_nom = $auteur['nom'];


//Si quelqu'un tombe sur la page par hasard, sans avoir de message à lire, ou s'il n'a pas le droit de le lire, on le redirige.

if (!isset($_GET['id']) OR $expediteur_id != $_SESSION['id']) {
    header('location:mess_lus.php');
} else { //Et s'il s'agissait d'un message non lu, on note qu'il a été lu.
    $query = $bdd->prepare('UPDATE mess SET lu = 1 WHERE id = ?');
    $query->execute(array($_GET['id']));
}

// On va récupérer le nombre de messages non lus et lus.
$query = $bdd->prepare('SELECT COUNT(lu) AS mess_nonlus FROM mess WHERE id_receiver = ? AND lu = 0 GROUP BY id_receiver');
$query->execute(array($_SESSION['id']));
$mess_nonlus = $query->fetch();
$mess_nonlus = $mess_nonlus['mess_nonlus'];

$query = $bdd->prepare('SELECT COUNT(lu) AS mess_lus FROM mess WHERE id_receiver = ? AND lu = 1');
$query->execute(array($_SESSION['id']));
$mess_lus = $query->fetch();
$mess_lus = $mess_lus['mess_lus'];

if ($_GET['log'] == 'yes') { // On regarde si l'utilisateur vient juste de se logger, auquel cas, on renvoie vers l'index.
    header('location:index.php');
} elseif (isset($_SESSION['id'])) { // Dans tous les autres cas de figure, on regarde d'abord si l'utilisateur est déjà loggé. Auquel cas, on continue le chargement de la page.
} elseif (isset($_GET['log'])) {
    include('auth_formulaire.php');
} else {
    header('location:auth.php?log=new');
}


/*
 * Copyright (C) 2016 cedriclangroth
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

