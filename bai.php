<?php header('Content-type: text/html; charset=utf-8');

include('auth.php');

    if(isset($_POST['message']))
    {
        $message = htmlspecialchars($_POST['message']);

        $query=$bdd->prepare('INSERT INTO messages_bai (auteur_id, message, date_message) VALUES (:id, :message, NOW())');
        $query->execute(array(
            'id' => $_SESSION['id'],
            'message' => $message
            ));

        $query->closeCursor();


        include('bai_formulaire.php');
    }
    else
    {
        include('bai_formulaire.php');
    }

?>