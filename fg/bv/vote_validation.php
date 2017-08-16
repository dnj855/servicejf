<div class="row justify-content-center">
    <div class="col-xs-12 col-md-6 col-md-offset-3">
        <div class="card border-info mb-3">
            <div class="card-header text-info border-info">
                <h4 class="card-title">Valides-tu ton vote ?</h4>
                <h6 class="card-subtitle mb-0">Tu n'en as qu'un seul</h6>
            </div>
            <div class="card-body">
                <p class="card-text"><?php
                    $punchline = getFg($bdd, $_POST['id_punchline']);
                    echo nl2br($punchline['message']);
                    ?></p>
            </div>
            <div class="card-footer border-info">
                <form method="post" action="fg_bv.php">
                    <input type="hidden" name="id_punchline" value="<?php echo $punchline['id']; ?>">
                    <input type='hidden' name='vote_validation' value="1">
                    <div class="d-flex justify-content-auto">
                        <div class="mr-auto">
                            <button class="btn btn-outline-success" type='submit'><span class="oi oi-check" title="check" aria-hidden="true"></span> Je valide</button>
                        </div>
                        <button class="btn btn-outline-warning" href='fg_bv.php'><span class="oi oi-action-undo" title="action-undo" aria-hidden="true"></span> Annuler</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>