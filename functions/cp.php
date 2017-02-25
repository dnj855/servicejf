<?php

function getCandidates($bdd) {
    $query = $bdd->query('SELECT * FROM cp_candidates ORDER BY nom');
    return $query->fetchAll();
}
