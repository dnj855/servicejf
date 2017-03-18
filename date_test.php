<?php

$date_butoir = new DateTime('2017-03-29');
$now = new DateTime();
var_dump($date_butoir);
echo ' <- date butoir<br><br>aujourd\'hui -> ';
var_dump($now);

if ($date_butoir > $now) {
    echo '1';
} else {
    echo '0';
}