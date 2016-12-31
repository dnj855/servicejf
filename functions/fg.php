<?php

function getFg($bdd, $id = '') {
    if ($id) {
        $query = $bdd->prepare('SELECT message, id, date_message FROM fg WHERE id = :id');
        $query->execute(array(
            'id' => $id
        ));
        $punchlines = $query->fetch();
    } else {
        $query = $bdd->query('SELECT id, message, sender, date_message, DATE_FORMAT(date_message, \'%d/%m/%Y\') AS date FROM fg WHERE valid = 1 ORDER BY date_message DESC');
        $punchlines = $query->fetchAll();
    }
    return $punchlines;
}

function getFgMonth($bdd, $month) {
    $query = $bdd->prepare('SELECT id, message, sender, date_message, DATE_FORMAT(date_message, \'%d/%m/%Y\') AS date FROM fg WHERE valid = 1 AND MONTH(date_message) = :month ORDER BY date_message DESC');
    $query->execute(array(
        'month' => $month
    ));
    $punchlines = $query->fetchAll();
    return $punchlines;
}

function getRemainingVotes($bdd, $voter_id) {
    $query = $bdd->prepare('SELECT COUNT(*) AS votes FROM fg_vote WHERE voter_id = :id AND MONTH(vote_date) = MONTH(NOW())');
    $query->execute(array(
        'id' => $voter_id
    ));
    $votes = $query->fetch();
    return 3 - $votes['votes'];
}

function previousMonth($month) {
    if ($month == 1) {
        $previousMonth = 12;
    } else {
        $previousMonth = $month - 1;
    }
    return $previousMonth;
}

function nextMonth($month) {
    if ($month == 12) {
        $nextMonth = 1;
    } else {
        $nextMonth = $month + 1;
    }
    return $nextMonth;
}

function getFgVotes($bdd, $punchline_id) {
    $query = $bdd->prepare('SELECT COUNT(*) AS votes FROM fg_vote WHERE punchline_id = :punchline_id');
    $query->execute(array(
        'punchline_id' => $punchline_id
    ));
    return $query->fetch();
}
