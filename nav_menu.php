<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href='index.php' class="navbar-brand"><img height="27px" src="logosmall.png" alt="logosmall"/></a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a data-target="#" class="dropdown-toggle" data-toggle="dropdown">Challenge invité <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php if ($_SESSION['service'] == '1') { ?>
                            <li><a href="ci.php">Saisir un invité</a></li>
                        <?php } ?>
                        <li><a href="ci_resultats.php">Consulter les résultats provisoires</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a data-target="#" class="dropdown-toggle" data-toggle="dropdown">Challenge des soirées sport <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php if ($_SESSION['css'] == '1') { ?>
                            <li><a href="css.php">Saisir une soirée sport</a></li>
                        <?php } ?>
                        <li><a href="css_resultats.php">Consulter les résultats provisoires</a></li>
                    </ul>
                </li>
                <li> <a href="bai.php">Boite à idées</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a data-target="#" class="dropdown-toggle" data-toggle="dropdown">Bonjour <?php echo $_SESSION['prenom']; ?> <span class="badge"><?php echo $mess_nonlus; ?></span> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="auth_modifier_utilisateur.php">Modifier mon compte</a>
                        </li>
                        <li><a href="mess.php">Messagerie interne</a></li>
                        <?php
                        // Affichage du panneau admin
                        if ($_SESSION['admin'] == 1) {
                            ?>
                            <li class="divider"></li>
                            <li class="dropdown-header">Administration du site</li>
                            <li><a href="ar_affichage_personnel.php">Gestion du personnel</a></li>
                            <li><a href="ar_bai_consult.php">Messages de la boite à idées</a></li>
                            <?php
                        }
                        ?>
                        <li class="divider"></li>
                        <li><a href="auth_logout.php">Me déconnecter</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>