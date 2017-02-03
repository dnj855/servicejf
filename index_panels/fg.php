<div class="panel-body">
    Recensez toutes les punchlines entendues sur la plateforme. A la fin de la saison, nous élirons la meilleure.
</div>
<ul class="list-group">
    <?php if ($_SESSION['actif']) { ?>
        <li class="list-group-item">
            <a href="fg.php?action=write">Poster une punchline</a>
        </li>
    <?php } ?>
    <li class="list-group-item">
        <a href="fg.php?action=read&month=<?php echo $now->format('m'); ?>&year=<?php echo $now->format('Y'); ?>">Lire les punchlines</a>
    </li>
</ul>