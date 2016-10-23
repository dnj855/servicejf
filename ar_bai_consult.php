<?php
include('auth.php');
if ($_SESSION['admin'] == 0) {
    header('location:index.php');
}
include('auth_bai.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Service j&f: - espace administrateurs</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <?php include('nav_menu.php') ?>
        <div class="container">
            <header class="page-header">
                <h1>la boite à idées</h1>
            </header>

            <section class="row">
                <div class="col-md-8 col-md-offset-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <?php
                            if (!$nb_messages) {
                                echo 'Il n\'y a pas de message pour le moment.';
                            } else {
                                echo 'Consultation des messages';
                            }
                            ?>
                        </div>
                        <?php
                        //On va rappatrier les messages de la bai en formattant la date et en les classant.
                        $bai = $bdd->query('SELECT auteur_id, message, DATE_FORMAT(date_message, \'le %d/%m/%Y\') AS date_mess FROM messages_bai ORDER BY date_message DESC LIMIT 0,30');
                        while ($messages = $bai->fetch()) {
                            //On va rappatrier le prénom et le nom de l'auteur du message.
                            $auteur_message = $bdd->prepare('SELECT prenom FROM personnel_fbln WHERE id = ?');
                            $auteur_message->execute(array($messages['auteur_id']));
                            $auteur_message = $auteur_message->fetch();
                            ?>
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <h5 class="list-group-item-heading">Envoyé par <?php echo $auteur_message['prenom']; ?> <small><?php echo $messages['date_mess']; ?></small></h5>
                                    <p class="list-group-item-text"><?php echo nl2br(htmlspecialchars($messages['message'])); ?></p>
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </section>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>