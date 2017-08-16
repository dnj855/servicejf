<?php
include ('auth.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['vote_validation']) {
    include('fg/bv/vote_treatment.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Service j&f: - le challenge du fichier gnou - vote final</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <link href="assets/css/design_v4.css" rel="stylesheet" type="text/css" />
        <link href="assets/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
    </head>

    <body>
        <?php
        include('nav_menu_v4.php');
        $end_vote = new DateTime('2017-10-01');
        ?>

        <div class="container">
            <h1 class="display-4">
                le challenge du fichier gnou <small class="text-muted">le vote final</small>
            </h1>
            <hr>

            <?php if ($_SESSION['message']) { ?>
                <div class="row justify-content-center">
                    <div class="col-xs-12 col-md-6">
                        <div class="alert alert-<?php echo $_SESSION['message']['type']; ?> alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?php
                            echo $_SESSION['message']['text'];
                            unset($_SESSION['message']);
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            }

            if ($now < $end_vote) {
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['vote_first']) {
                    include('fg/bv/vote_validation.php');
                } elseif (checkFgBvIfAlreadyVoted($bdd, $_SESSION['id'])) {
                    include('fg/bv/my_vote.php');
                } else {
                    include ('fg/bv/vote.php');
                }
            } else {
                include('fg/bv/ranking.php');
            }
            ?>

        </div>


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    </body>
</html>


