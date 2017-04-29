<?php

$results = getCpOrderedResults($bdd);
$betters = getCpBetters($bdd);

for ($i = 7; $i < 8; $i++) {
    $better = $betters[$i];
    setCpBetPoints($bdd, $better['better_id'], $results);
}