<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href='index.php' class="navbar-brand"><img height="27px" src="assets/img/logosmall.png" alt="logosmall"/></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Challenge invité <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php if ($_SESSION['service'] == '1' && $_SESSION['actif']) { ?>
                            <li><a href="ci.php">Saisir un invité</a></li>
                        <?php } ?>
                        <li><a href="ci_resultats.php">Consulter les résultats provisoires</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Challenge des soirées sport <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php if ($_SESSION['css'] == '1' && $_SESSION['actif']) { ?>
                            <li><a href="css.php">Saisir une soirée sport</a></li>
                        <?php } ?>
                        <li><a href="css_resultats.php">Consulter les résultats provisoires</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Challenge du fichier gnou <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php if ($_SESSION['actif']) { ?>
                            <li>
                                <a href="fg.php?action=write">Poster une punchline</a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="fg.php?action=read&month=<?php echo $now->format('m'); ?>&year=<?php echo $now->format('Y'); ?>">Lire les punchlines</a>
                        </li>
                    </ul>
                </li>
                <?php if ($_SESSION['actif']) { ?>
                    <li> <a href="bai.php">Boite à idées</a></li>
                <?php } ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Bonjour <?php echo $_SESSION['prenom']; ?> <span class="badge"><?php echo $mess_nonlus; ?></span> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="auth_modifier_utilisateur.php">Modifier mon compte</a>
                        </li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Messagerie interne</li>
                        <li><a href="mess_formulaire.php">Ecrire un message</a></li>
                        <li <?php if (!$mess_nonlus) { ?>class="disabled"<?php } ?>><a href="mess_nonlus.php">Messages non lus <span class="badge"><?php echo $mess_nonlus; ?></span></a></li>
                        <li><a href="mess_lus.php">Lire les messages</a></li>
                        <?php
                        // Affichage du panneau admin
                        if ($_SESSION['admin'] == 1) {
                            ?>
                            <li class="divider"></li>
                            <li class="dropdown-header">Administration du site</li>
                            <li><a href="ar_affichage_personnel.php">Gestion du personnel</a></li>
                            <li><a href="ar_cp.php">Gestion du challenge de la présidentielle</a></li>
                            <li><a href="ar_bai_consult.php">Messages de la boite à idées</a></li>
                            <?php
                        }
                        ?>
                        <li class="divider"></li>
                        <li><a href="auth_logout.php">Me déconnecter</a></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>