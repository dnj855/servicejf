<div class="row justify-content-center">
    <div class="col-sm-12 col-md-6">
        <div class="card border-info">
            <div class="card-header border-info bg-info">
                <h4 class="card-title text-light mb-0">Voici la punchline pour laquelle tu as voté</h4>
            </div>
            <div class="card-body">
                <blockquote class="quote mb-0">
                    <?php
                    $punchline = getFgBvVote($bdd, $_SESSION['id']);
                    $sender = getUserIdentity($bdd, $punchline['sender']);
                    $date_vote = new DateTime($punchline['vote_date']);
                    echo nl2br($punchline['message']);
                    ?>
                    <footer class="blockquote-footer mt-3">Signé <?php echo $sender['prenom'] . ' ' . substr($sender['nom'], 0, 1) . '.'; ?></footer>
                </blockquote>
            </div>
            <div class="card-footer bg-info text-light text-right">
                <em>Ton vote a été enregistré le <?php echo $date_vote->format('d.m.Y') ?>.<br />Rendez-vous le 1er octobre pour connaître le résultat des votes.</em>
            </div>
        </div>
    </div>
</div>