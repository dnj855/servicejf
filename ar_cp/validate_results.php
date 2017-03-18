<?php

$results = getCpOrderedResults($bdd);
$betters = getCpBetters($bdd);

foreach ($betters as $better) {
    setCpBetPoints($bdd, $better['better_id'], $results);
}