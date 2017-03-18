<div class="alert alert-info">
    <p>
        <strong>Nous sommes le <?php echo $now->format('d') . ' ' . $mois[$now->format('m')]; ?>.</strong> Si tu valides ton pronostic aujourd'hui, tes points seront multipliés par <?php echo getCpDatePoints($now); ?>.
    </p>
</div>