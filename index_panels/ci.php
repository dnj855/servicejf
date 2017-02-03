<div class="panel-body">
    Direct ou PAD ? Studio ou téléphone ?<br />Le challenge de l'invité est le point fondateur du service j&f:
</div>
<ul class="list-group">
    <?php if ($_SESSION['service'] == '1' && $_SESSION['actif']) { ?>
        <li class="list-group-item">
            <a href="ci.php">Page à remplir pour l'intervieweur</a>
        </li>
    <?php } ?>
    <li class="list-group-item">
        <a href="ci_resultats.php">Consultation des résultats provisoires</a>
    </li>
</ul>