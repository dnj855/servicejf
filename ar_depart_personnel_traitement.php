<?php
include('auth.php');
if($_SESSION['admin'] == 0) {
    header('location:index.php');
}

if (isset($_POST['id']) AND isset($_POST['depart']))
{

        $depart_personnel = $bdd->prepare('UPDATE personnel_fbln SET actif = 0 WHERE id = ?');
        $depart_personnel->execute(array($_POST['id']));


header('Location:ar_affichage_personnel.php?error=0');

        }
?>