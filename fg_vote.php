<div class="panel panel-primary">
    <div class="panel-heading">
        <h4 class="panel-title">Voter pour une punchline</h4>
    </div>
    <div class="list-group">
        <?php
        $id_punchline = $_GET['id'];
        $punchline = getFg($bdd, $id_punchline);
        ?>
        <li class="list-group-item">
            <?php if (!$punchline) { ?>
                <p class="list-group-item-heading text-center">
                    Erreur 500 : la punchline sélectionnée n'existe pas.<br />Merci de réessayer en cliquant sur <a href="fg.php?action=read&month=<?php echo $now->format('m'); ?>">Lire les punchlines</a>
                </p>
                <?php
            } else {
                $punchline_date = new DateTime($punchline['date_message']);
                if ($punchline_date->format('m') != $now->format('m')) {
                    ?>
                    <p class = "list-group-item-heading text-center">
                        <strong>Erreur :</strong> tu ne peux voter que pour une punchline balancée ce mois-ci.<br /><a href="fg.php?action=read&month=<?php echo $now->format('m'); ?>">Retour aux punchlines</a>
                    </p>
                    <?php
                } else {
                    ?>
                    <p class="list-group-item-heading text-center">
                        <?php if (getRemainingVotes($bdd, $_SESSION['id']) > 1) { ?>
                            Il te reste <?php echo getRemainingVotes($bdd, $_SESSION['id']) ?> votes pour ce mois de <?php
                            echo $mois[$now->format('m')] . ' ' . $now->format('Y');
                            ?>. Voici la punchline pour laquelle tu souhaites voter :
                        <?php } elseif (getRemainingVotes($bdd, $_SESSION['id']) == 1) {
                            ?>
                            Il te reste <?php echo getRemainingVotes($bdd, $_SESSION['id']) ?> vote pour ce mois de <?php
                            echo $mois[$now->format('m')] . ' ' . $now->format('Y');
                            ?>. Voici la punchline pour laquelle tu souhaites voter :
                        <?php } else { ?>
                            Tu n'as plus de vote disponible ce mois-ci. Rendez-vous le mois prochain pour pouvoir à nouveau participer.
                            <?php
                        }
                        ?>
                    </p>

                    <?php if (getRemainingVotes($bdd, $_SESSION['id']) >= 1) { ?>
                        <blockquote>
                            <p>
                                <?php echo nl2br(htmlspecialchars($punchline['message']));
                                ?>
                            </p>
                        </blockquote>
                        <p class="list-group-item-text">Valides-tu ton choix ?</p>
                        <p class="list-group-item-text text-center">
                            <a class="btn btn-success" href="fg_vote_traitement.php?id=<?php echo $punchline['id']; ?>">Oui</a>
                        </p>
                        <?php
                    }
                }
                ?>
            </li>
        <?php } ?>
    </div>
</div>