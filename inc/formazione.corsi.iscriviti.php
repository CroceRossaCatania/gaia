<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaModale();

$c = null;
try {
    $id = intval($_GET['id']);
    $c = Corso::id($id);
    
    if (empty($c) || empty($me)) {
        throw new Exception('Manomissione');
    }
    
} catch (Exception $e) {
    redirect('formazione.corsi.iscriviti&err');
    die;
}
?>
<form action="?p=formazione.corsi.iscriviti.ok" method="POST">
    <div class="modal fade automodal">
        <div class="modal-header">
            <h3><i class="icon-group muted"></i>Iscrizione al corso</h3>
            <p><?php echo $c->tipo()->nome ?> - <?php echo $c->inizio()->inTesto() ?></p>
        </div>
        <div class="modal-body">
            <?php
            if (isset($_GET['err'])) {
                ?>
                <div class="alert alert-block alert-error allinea-centro">
                    <p>Errore in fase di iscrizione. Prova ad uscire e accedere nuovamente al programma.</p>
                    <p>In caso di errore persistente, contatta un amministratore</p>
                </div>
                <?php
            }


            if (isset($_GET['ok'])) {
                ?>
                <div class="alert alert-block alert-success allinea-centro">
                    <p>La richiesta di iscrizione è stata inviata correttamente.</p>
                </div>
                <?php
            }
            ?>
            <input type="hidden" name="id" value="<?php echo intval($_GET['id']) ?>" />
            <input type="hidden" name="p" value="formazione.corsi.iscriviti.ok" />
            <div class="control-group">
                <label class="control-label" for="inputNome">Nome</label>
                <div class="controls">
                    <input type="text" name="inputNome" id="inputNome" required="" <?php if ($me) echo 'readonly=""' ?> value="<?php echo $me->nome ?>">
                    <!--<acronym title="Per modificare, contatta supporto@gaia.cri.it">&nbsp; <i class="icon-lock icon-large"></i></acronym>-->
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputCognome">Cognome</label>
                <div class="controls">
                    <input type="text" name="inputCognome" id="inputCognome" required="" <?php if ($me) echo 'readonly=""' ?> value="<?php echo $me->cognome ?>">
                    <!--<acronym title="Per modificare, contatta supporto@gaia.cri.it">&nbsp; <i class="icon-lock icon-large"></i></acronym>-->
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputTelefono">Recapito telefonico</label>
                <div class="controls">
                    <input type="text" id="inputTelefono" name="inputTelefono" pattern="[0-9]{5,}" <?php if ($me) echo 'readonly=""' ?> value="<?php echo $me->cellulare ?>"><br/>
                    <span class="muted">Inserire solo cifre, senza spazi o altri caratteri</span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputEmail">Email</label>
                <div class="controls">
                    <input type="email" id="inputEmail" name="inputEmail" required="" <?php if ($me) echo 'readonly=""' ?> value="<?php echo $me->email ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputRichiesta">Note</label>
                <div class="controls">
                    <textarea  id="inputRichiesta" name="inputRichiesta" required="true" rows="10"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript:history.go(-1);" class="btn">Annulla</a>
            <button type="submit" class="btn btn-primary">Avanti</button>
        </div>
    </div>
</form>
