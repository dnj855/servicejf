<nav class="navbar navbar-light fixed-top bg-light navbar-expand-md" role="navigation">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a href='index.php' class="navbar-brand"><img height="27px" src="assets/img/logosmall.png" alt="logosmall"/></a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Challenge invité <span class="caret"></span></a>
                <div class="dropdown-menu">
                    <?php if ($_SESSION['service'] == '1' && $_SESSION['actif']) { ?>
                        <a href="ci.php?action=write" class="dropdown-item">Saisir un invité</a>
                    <?php } ?>
                    <a href="ci.php?action=read" class="dropdown-item">Consulter les résultats</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Challenge des soirées sport <span class="caret"></span></a>
                <div class="dropdown-menu">
                    <?php if ($_SESSION['css'] == '1' && $_SESSION['actif']) { ?>
                        <a href="css.php?action=write" class="dropdown-item">Saisir une soirée sport</a>
                    <?php } ?>
                    <a href="css.php?action=read" class="dropdown-item">Consulter les résultats provisoires</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Challenge handball mondial <span class="caret"></span></a>
                <div class="dropdown-menu">
                    <?php
                    if ($_SESSION['actif']) {
                        if (checkcger17Registration($bdd, $_SESSION['id']) || !checkcger17Begin($bdd)) {
                            ?>
                            <a href="cger17.php" class="dropdown-item">Pronostiquer</a>
                            <?php
                        }
                    }
                    if (checkcger17Begin($bdd)) {
                        ?>
                        <a href="cger17.php?action=ranking" class="dropdown-item">Voir les résultats</a>
                        <?php
                    }
                    ?>
                    <a class="dropdown-item" href="cger17.php?action=rules">Lire le règlement</a>

                </div>
            </li>

            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Challenge du fichier gnou <span class="caret"></span></a>
                <div class="dropdown-menu">
                    <?php if ($_SESSION['actif']) { ?>

                        <a href="fg.php?action=write" class="dropdown-item">Poster une punchline</a>

                    <?php } ?>

                    <a class="dropdown-item" href="fg.php?action=read&month=<?php echo $now->format('m'); ?>&year=<?php echo $now->format('Y'); ?>">Lire les punchlines</a>

                </div>
            </li>
            <?php if ($_SESSION['actif']) { ?>
                <li class="nav-item"> <a class="nav-link" href="bai.php">Boite à idées</a></li>
            <?php } ?>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">Bonjour <?php echo $_SESSION['prenom']; ?> <span class="badge badge-info"><?php echo $mess_nonlus; ?></span> <span class="caret"></span></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="auth_modifier_utilisateur.php" class="dropdown-item">Modifier mon compte</a>
                    <div class="dropdown-divider"></div>
                    <h6 class="dropdown-header">Messagerie interne</h6>
                    <a href="mess_formulaire.php" class="dropdown-item">Ecrire un message</a>
                    <a class="dropdown-item<?php if (!$mess_nonlus) { ?> disabled<?php } ?>" href="mess_nonlus.php">Messages non lus <span class="badge"><?php echo $mess_nonlus; ?></span></a>
                    <a class="dropdown-item" href="mess_lus.php">Lire les messages</a>
                    <?php
                    // Affichage du panneau admin
                    if ($_SESSION['admin'] == 1) {
                        ?>
                        <div class="dropdown-divider"></div>
                        <h6 class="dropdown-header">Administration du site</h6>
                        <a href="ar_affichage_personnel.php" class="dropdown-item">Gestion du personnel</a>
                        <a href="ar_cger17.php" class="dropdown-item">Gestion du challenge du mondial 2017</a>
                        <a href="ar_bai_consult.php" class="dropdown-item">Messages de la boite à idées</a>

                        <?php
                    }
                    ?>
                    <div class="dropdown-divider"></div>
                    <a href="auth_logout.php" class="dropdown-item">Me déconnecter</a>
                </div>
            </li>
        </ul>
    </div><!--/.nav-collapse -->
</nav>