<?php
include('auth.php');
if (!$_GET) {
    header('location:index.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Service j&f: - le challenge du fichier gnou</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <?php
        include('nav_menu.php')
        ?>
        <div class="container">
            <header class="page-header">
                <h1>le challenge du fichier gnou</h1>
            </header>

            <?php if ($_SESSION['message']) { ?>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                            ?>
                        </div>
                    </div>
                </div>
            <?php }
            ?>
            <div class="row">
                <nav class="col-md-4">
                    <div class="row">
                        <?php if ($_SESSION['actif']) { ?>
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li <?php
                                            if ($_GET['action'] == 'write') {
                                                echo 'class="active"';
                                            }
                                            ?>><a href="fg.php?action=write"><span class="glyphicon glyphicon-pencil"></span> Poster une punchline</a></li>
                                            <li <?php
                                            if ($_GET['action'] == 'read' || $_GET['action'] == 'vote') {
                                                echo 'class="active"';
                                            }
                                            ?>><a href="fg.php?action=read&month=<?php echo $now->format('m'); ?>&year=<?php echo $now->format('Y'); ?>"><span class="glyphicon glyphicon-list-alt"></span> Lire les punchlines</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Les meilleures punchlines des mois précédents</h4>
                                </div>
                                <div class="panel-body">
                                    <ul class="list-group">
                                        <?php
                                        $best_punchlines = getFgBestPunchlines($bdd);
                                        foreach ($best_punchlines as $month => $punchline) {
                                            foreach ($punchline as $id_punchline) {
                                                $punchline_message = getFg($bdd, $id_punchline);
                                                $best_punchline_vote = getFgVotes($bdd, $id_punchline);
                                                $month_votes = getFgMonthVotes($bdd, $month);
                                                $pourcentage = round(($best_punchline_vote[0] / $month_votes['votes']) * 100, 2);
                                                ?>
                                                <li class="list-group-item">
                                                    <h4 class="list-group-item-heading">
                                                        <a href="fg.php?action=read&month=<?php echo substr($month, 0, 2); ?>&year=<?php echo substr($month, 3, 7); ?>">
                                                            <?php echo ucfirst($mois[substr($month, 0, 2)]) . ' ' . substr($month, 3, 7); ?>
                                                        </a>
                                                    </h4>
                                                    <p><?php echo nl2br(htmlspecialchars($punchline_message['message'])); ?></p>
                                                    <p><em><?php echo $best_punchline_vote[0]; ?> votes (<?php echo $pourcentage; ?> %)</em></p>
                                                </li>


                                                <?php
                                            }
                                        }
                                        ?></ul></div>
                            </div>
                        </div>
                    </div>
                </nav>
                <section class = "col-md-8">
                    <?php
                    if ($_GET['action'] == 'write') {
                        include ('fg_write.php');
                    } elseif ($_GET['action'] == 'read') {
                        if (!validateMonth($_GET['month']) && !validateYear($_GET['year'])) { // On s'assure juste que les données passées en Get correspondent à des valeurs correctes.
                            include('fg_404.php');
                        }
                        if ($_GET['year'] > $now->format('Y')) {
                            include('fg_404.php');
                        } elseif ($_GET['year'] == $now->format('Y') && $_GET['month'] > $now->format('m')) {
                            include ('fg_404.php');
                        } else {
                            include ('fg_read.php');
                        }
                    } elseif ($_GET['action'] == 'vote') {
                        include ('fg_vote.php');
                    } else {
                        echo 'Erreur 404';
                    }
                    ?>
                </section>
            </div>


            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>


