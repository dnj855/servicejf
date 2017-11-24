<div class="panel-body">
    Voici venu le grand moment :<br />
    à vous de choisir la punchline de l'année !
</div>
<ul class="list-group">
    <li class="list-group-item">
        <?php
        if ($now > new DateTime('2017-09-01') && $now < new DateTime('2017-10-01')) {
            echo '<a href="fg_bv.php">Accéder au module de vote</a>';
        } elseif ($now > new DateTime('2017-10-01')) {
            echo '<a href="fg_bv.php">Voir les résultats</a>';
        } else {
            echo '<em>Module de vote ouvert uniquement pendant le mois de septembre.</em>';
        }
        ?>
    </li>
</ul>