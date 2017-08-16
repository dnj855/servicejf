<?php

$query = $bdd->prepare('INSERT INTO fg_bv (punchline_id, voter_id, vote_date) VALUES (:punchline_id, :voter_id, NOW())');
$result = $query->execute(array(
    'punchline_id' => $_POST['id_punchline'],
    'voter_id' => $_SESSION['id']
        ));
if ($result) {
    $_SESSION['message']['type'] = 'success';
    $_SESSION['message']['text'] = 'Ton vote a bien été enregistré.';
} else {
    $_SESSION['message']['type'] = "warning";
    $_SESSION['message']['type'] = "Une erreur s'est produite, merci de voter à nouveau.";
}
