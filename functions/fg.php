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

function getFgMonth($bdd, $month, $year) {
    $query = $bdd->prepare('SELECT id, message, sender, date_message, DATE_FORMAT(date_message, \'%d/%m/%Y\') AS date FROM fg WHERE valid = 1 AND MONTH(date_message) = :month AND YEAR(date_message) = :year ORDER BY date_message DESC');
    $query->execute(array(
        'month' => $month,
        'year' => $year
    ));
    $punchlines = $query->fetchAll();
    return $punchlines;
}

function getRemainingVotes($bdd, $voter_id) {
    $query = $bdd->prepare('SELECT COUNT(*) AS votes FROM fg_vote WHERE voter_id = :id AND MONTH(vote_date) = MONTH(NOW()) AND YEAR(vote_date) = YEAR(NOW())');
    $query->execute(array(
        'id' => $voter_id
    ));
    $votes = $query->fetch();
    return 3 - $votes['votes'];
}

function previousMonth($month) {
    if ($month < 11 && $month != '01') {
        $previousMonth = $month - 1;
        $previousMonth = '0' . $previousMonth;
    } elseif ($month == '01') {
        $previousMonth = 12;
    } else {
        $previousMonth = $month - 1;
    }
    return $previousMonth;
}

function nextMonth($month) {
    if ($month < 9) {
        $nextMonth = $month + 1;
        $nextMonth = '0' . $nextMonth;
    } else if ($month == 12) {
        $nextMonth = '01';
    } else {
        $nextMonth = $month + 1;
    }
    return $nextMonth;
}

function getFgNextYear($month, $year) {
    if ($month == 12) {
        $year = $year + 1;
    }
    return $year;
}

function getFgPreviousYear($month, $year) {
    if ($month == '01') {
        $year = $year - 1;
    }
    return $year;
}

function getFgVotes($bdd, $punchline_id) {
    $query = $bdd->prepare('SELECT COUNT(*) AS votes FROM fg_vote WHERE punchline_id = :punchline_id');
    $query->execute(array(
        'punchline_id' => $punchline_id
    ));
    return $query->fetch();
}

function getFgBestPunchline($bdd, $month, $year) {
    $query = $bdd->prepare('SELECT id FROM fg WHERE MONTH(date_message) = :month AND YEAR(date_message) = :year');
    $query->execute(array(
        'month' => $month,
        'year' => $year
    ));
    $punchlines = $query->fetchAll();
    $test_punchlines = array_filter($punchlines);
    if (!$test_punchlines) {
        return 0;
    } else {
        $bestPunchline = array();
        foreach ($punchlines as $punchline) {
            $votes = getFgVotes($bdd, $punchline['id']);
            $bestPunchline[$votes['votes']] = $punchline['id'];
        }
        krsort($bestPunchline);
        $best_punchline = array_slice($bestPunchline, 0, 1, 1);
        if (!key($best_punchline)) {
            return 0;
        } else {
            return $best_punchline;
        }
    }
}

function getFgBestPunchlines($bdd) {
    $now = new DateTime();
    $year = $now->format('Y');
    $month = $now->format('m');
    $year = getFgPreviousYear($month, $year);
    $month = previousMonth($month);
    $punchlines = array();
    $i = 0;
    while (getFgBestPunchline($bdd, $month, $year)) {
        $punchlines[$month . '-' . $year] = getFgBestPunchline($bdd, $month, $year);
        $year = getFgPreviousYear($month, $year);
        $month = previousMonth($month);
    }
    return $punchlines;
}

function getFgMonthVotes($bdd, $month_year) {
    $month = substr($month_year, 0, 2);
    $year = substr($month_year, 3, 7);
    $year_month = $year . '-' . $month;
    $first_day = $year_month . "-01";
    $query = $bdd->prepare('SELECT COUNT(*) votes FROM fg_vote WHERE vote_date BETWEEN :first_day AND LAST_DAY(:first_day)');
    $query->execute(array(
        'first_day' => $first_day
    ));
    return $query->fetch();
}
