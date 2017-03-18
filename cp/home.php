<?php

if ($cp_situation == 'before_beginning') {
    include('wait_panel.php');
} elseif ($cp_situation == 'betweentwolegs') {
    include('p_ranking.php');
} elseif ($cp_situation == 'aftersecondleg') {
    include('f_ranking.php');
} elseif ($cp_situation == 'play_without_definitive') {
    include('set_bets.php');
} elseif ($cp_situation == 'play_with_definitive') {
    include('view_bets.php');
} elseif ($cp_situation == 'inactive') {
    include('view_bets.php');
}