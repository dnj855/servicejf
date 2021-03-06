<?php

include('auth.php');
if ($_SESSION['admin'] == 0) {
    header('location:index.php');
} else {

    if (isset($_POST['prenom']) AND isset($_POST['nom']) AND isset($_POST['service']) AND isset($_POST['pseudo']) AND isset($_POST['cadre'])) {
        $prenom = htmlspecialchars($_POST['prenom']); // On rend propre les valeurs saisies.
        $nom = htmlspecialchars($_POST['nom']);
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = htmlspecialchars($_POST['mdp']);
        $_POST['service'] = (int) $_POST['service'];

        $ajout_personnel = $bdd->prepare('INSERT INTO personnel_fbln (nom, prenom, service_id, pseudo, cadre, css, mdp, admin, actif, cdrb) VALUES (:nom, :prenom, :service, :pseudo, :cadre, :css, :mdp, :admin, 1, 0)');

        $ajout_personnel->execute(array(
            'nom' => $nom,
            'prenom' => $prenom,
            'pseudo' => $pseudo,
            'cadre' => $_POST['cadre'],
            'service' => $_POST['service'],
            'mdp' => $mdp,
            'css' => $_POST['css'],
            'admin' => $_POST['admin'],
        ));
        $ajout_personnel->closeCursor();

        $query = $bdd->query('SELECT MAX(id) AS id FROM personnel_fbln'); // C'est forcément l'utilisateur le plus récent.
        $id = $query->fetch();
        $query->closeCursor();

        if ($_POST['service'] == 1) { //Si l'utilisateur participe au ci, il faut l'inscrire dans la base des points du ci.
            $query = $bdd->prepare('INSERT INTO challenge_invite_points (id_intervieweur) VALUES (?)');
            $query->execute(array($id['id']));
        }
    }

    header('Location:ar_modif_mdp_personnel.php?id=' . $id['id']);
}