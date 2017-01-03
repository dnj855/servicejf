<div class="panel panel-primary">
    <div class="panel-heading">
        <h4 class="panel-title">Poster une punchline</h4>
    </div>
    <div class="panel-body">
        <form method="post" action="fg_traitement.php">
            <div class="form-group">
                <label for="message">Le texte (et le contexte) de la punchline</label>
                <textarea class="form-control" name="message" id="message" rows="3"></textarea>
                <span class="help-block">N'hésite pas à être précis, pour que la punchline puisse être comprise même hors contexte.</span>
            </div>
            <div class="form-group">
                <label for="date_message">La date à laquelle la punchline a été prononcée</label>
                <input type="date" name="date_message" id="date_message" class="form-control">
                <span class="help-block">Au format jj/mm/aaaa. Laisser libre pour enregistrer à la date du jour.</span>
            </div>
            <input type="hidden" name="sender_id" value="<?php echo $_SESSION['id']; ?>">
            <button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-check"></span> Envoyer</button>
        </form>
    </div>
</div>