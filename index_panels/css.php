<div class="panel-body">
    Sur proposition du président d'honneur, voyons quel technicien porte le plus chance au FC Metz.
</div>
<ul class="list-group">
    <?php if ($_SESSION['css'] == '1' && $_SESSION['actif']) { ?>
        <li class="list-group-item">
            <a href="css.php?action=write">La page à remplir après chaque journée de championnat</a>
        </li>
    <?php } ?>
    <li class="list-group-item">
        <a href="css.php?action=read">Consultation des résultats provisoires</a>
    </li>
</ul>