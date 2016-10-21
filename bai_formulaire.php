<?php
include('auth.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Laissez nous un message</title>
        <link href="design.css" rel="stylesheet" type="text/css" />
        <link href="auth.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
    <?php include('auth_menu_utilisateur.php') ?>
    <?php include('nav_menu.php') ?>   

    <div class="index">
    <p class="titre">Nous sommes toujours à l'écoute. Qu'as-tu à nous dire ?</p>
    <?php

    if(isset($_POST['message']))
    {
    ?>
    <p class="formulaire_erreur">Promis, on te lit au plus vite !</p>
    <?php    
    }

    ?> 
    <div class="formulaire">
    <form method="post" action="bai.php">
    <table class="formulaire">
    <tr>
    <?php
    if(isset($_POST['message']))
    { ?>
        <td colspan=2><p class="message"><?php echo nl2br(htmlspecialchars($message)) ?></p>
    <?php
    }
    else { ?>
    <td>
    Inscris ton message ici :
    </td>
    <td>
    <textarea name="message" rows=7 cols=35 class="formulaire"></textarea>
    </td>
    <?php } ?>
    </tr>
    <tr>
    <td>
    </td>
    <td>
    <?php
        if(!isset($_POST['message']))
        {
            echo '<input type="submit" value="Envoyer mon message" class="envoi_formulaire">';
        }
    ?>
    </td>
    </tr>
    </table>
    </form>
    </div>
    </div>
    </body>
</html>