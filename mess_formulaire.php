<?php
include('auth.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Messagerie interne du service j&f:</title>
        <link href="design.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
    <?php include('auth_menu_utilisateur.php') ?>
    <?php include('nav_menu.php') ?>   

    <div class="index">
    	<p class="titre">messagerie interne du service j&f:</p>
    	<p class="auth_modify_nom">nouveau message</p>
    <div class="formulaire">
    	<table class="formulaire">
        <form class="formulaire" method="post" action="mess_traitement.php">
    		<tr>
    			<td>Destinataire</td>
    			<td>
    				<select name="destinataire" class="formulaire">
                    <option value="">---Choisir---</option>

    				<?php // Les deux boucles pour afficher les destinataires possibles.
                    $req_service = $bdd->query('SELECT * FROM service_fbln ORDER BY nom');
                    while($service = $req_service->fetch()) {
                        echo '<optgroup label="' . $service['nom'] . '">';
    				    $req = $bdd->prepare('SELECT id, prenom FROM personnel_fbln WHERE service_id = ? AND actif = 1 AND id != ? ORDER BY prenom');
                        $req->execute(array($service['id'], $_SESSION['id']));
    				    while($destinataire = $req->fetch()) {
    					   echo '<option value="' . $destinataire['id'] . '">' . $destinataire['prenom'] . '</option>';
    				    }
                        echo '</optgroup>';
                    }    
    				    ?>
    				</select>
    			</td>
            <tr>
                <td>Titre</td>
                <td><input type="text" class="formulaire" name="titre"></td>
            </tr>    
			<tr>
				<td>Message</td>
				<td><textarea class="formulaire" name="message" rows="10" cols="45"></textarea></td>
			</tr>
			<tr>
				<td></td>
				<td>
                    <input type="hidden" name="expediteur" value="<?php echo $_SESSION['id'] ?>">
                    <input type="button" value="Envoyer" onclick="Verifier_formulaire (this.form)" id="send" class="envoi_formulaire">
                    <input type="reset" value="Annuler" class="envoi_formulaire">      
                    <script>
                    function Verifier_formulaire(formulaire){
                    if (formulaire.destinataire.value==""){
                    alert ("Tu as oublié de remplir le nom du destinataire.");
                    }else{
                    formulaire.submit();
                    }
                    }
                    </script>              
                </td>
			</tr>
        </form>    
    	</table>
    </div>
    </div>
    </body>
</html>