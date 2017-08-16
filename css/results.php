
<div class="col-xs-12 col-md-3">
    <div class="panel panel-primary">
        <div class="panel-body">
            <ul class="nav nav-pills nav-stacked">
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button">Classements <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="css.php?action=read">Officiel</a></li>
                        <li><a href="css.php?action=read&classement=points">Par points</a></li>
                        <li><a href="css.php?action=read&classement=average">A la différence de buts</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button">Par réalisateur <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php
                        $techniciens = selectCssAllPlayers($bdd, $_SESSION['css_season']);
                        foreach ($techniciens as $technicien) {
                            echo '<li><a href="css.php?action=read&realisateur=' . $technicien['id'] . '">' . $technicien['prenom'] . ' ' . substr($technicien['nom'], 0, 1) . '.</a></li>';
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="col-xs-12 col-md-9">

    <?php
    if ($_GET['classement']) {
        if ($_GET['classement'] == 'points') {
            include('results_points.php');
        } elseif ($_GET['classement'] == 'average') {
            include ('results_average.php');
        } else {
            include ('404.php');
        }
    } elseif ($_GET['realisateur']) {
        $allowedDirectors = selectCssAllPlayers($bdd, $_SESSION['css_season']); // On vérifie que l'id entré en GET correspond bien à un réalisateur de la saison concernée.
        $error = 1;
        foreach ($allowedDirectors as $director) {
            if ($director['id'] == $_GET['realisateur']) {
                $error = 0;
            }
        }
        if (!$error) {
            include ('results_realisateur.php');
        } else {
            include('404.php');
        }
    } else {
        include('results_general.php');
    }
    ?>

</div>