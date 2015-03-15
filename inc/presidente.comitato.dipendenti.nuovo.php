<?php

/**
 * (c)2015 Croce Rossa Italiana
 */

$app = (int) $_GET['applicazione'];
$oid = $_GET['comitato'];
$c = GeoPolitica::daOid($oid);

paginaApp(APP_PRESIDENTE, [$c]);

$cf = htmlentities($_GET['cf']);

?>

<form action="?p=presidente.comitato.dipendenti.nuovo.ok" method="POST">

	<input type="hidden" name="inputApplicazione" value="<?= $app; ?>" />
	<input type="hidden" name="inputComitato" value="<?= $oid; ?>" />

    <div class="modal fade automodal">

        <div class="modal-header">
            <h3><i class="icon-plus"></i> Inserisci un nuovo Dipendente</h3>
        </div>

        <div class="modal-body">
            <div class="row-fluid">
                <?php if ( isset($_GET['e']) ) { ?>
                <div class="alert alert-danger">
                    <i class="icon-ban-circle"></i> <strong>Codice Fiscale errato</strong>.
                    Il formato del codice fiscale inserito non risulta valido.
                </div>
                <?php }elseif ( isset($_GET['mail']) ) { ?>
                <div class="alert alert-danger">
                    <i class="icon-ban-circle"></i> <strong>Mail già presente</strong>.
                    L'e-mail che stai provando ad aggiungere è già presente su Gaia per un altro individuo.
                </div>
                <?php }?>
                <div class="alert alert-info">
                    <i class="icon-pencil"></i> <strong>Tutti i campi sono obbligatori</strong>.
                    <p>Il Dipendente ricever&agrave; una e-mail con le istruzioni per impostare una password ed accedere a Gaia.</p>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label" for="inputNome">Nome </label>
                </div>
                <div class="span8">
                    <input type="text" name="inputNome" id="inputNome" required/>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label" for="inputCognome">Cognome</label>
                </div> 
                <div class="span8">
                    <input type="text" name="inputCognome" id="inputCognome"  required/>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label" for="inputSesso">Sesso</label>
                </div>
                <div class="span8">
                    <select class="input-small" id="inputSesso" name="inputSesso" required>
                        <?php
                        foreach ( $conf['sesso'] as $numero => $tipo ) { ?>
                        <option value="<?php echo $numero; ?>"><?php echo $tipo; ?></option>
                        <?php } ?>
                    </select>  
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label" for="inputCodiceFiscale">Codice Fiscale</label>
                </div>
                <div class="span8">
                    <input type="text" name="inputCodiceFiscale" id="inputCodiceFiscale" readonly="readonly" value="<?= $cf; ?>" />
                </div>
            </div>
            <div class="row-fluid">            
                <div class="span4 centrato">
                    <label class="control-label" for="inputDataNascita">Data di nascita</label>
                </div>
                <div class="span8">
                    <input type="text" name="inputDataNascita" id="inputDataNascita" required />
                </div>
            </div>
            <div class="row-fluid">            
                <div class="span4 centrato">
                    <label class="control-label" for="inputComuneNascita">Comune di nascita</label>
                </div>
                <div class="span8">
                    <input type="text" name="inputComuneNascita" id="inputComuneNascita" required />
                </div>
            </div>
            <div class="row-fluid">            
                <div class="span4 centrato">
                    <label class="control-label" for="inputProvinciaNascita">Provincia di nascita</label>
                </div>
                <div class="span8">
                    <input type="text" name="inputProvinciaNascita" id="inputProvinciaNascita" required />
                </div>
            </div>
            <div class="row-fluid">            
                <div class="span4 centrato">
                    <label class="control-label" for="inputEmail">Email</label>
                </div>
                <div class="span8 input-prepend">
                    <span class="add-on"><i class="icon-envelope"></i></span>
                    <input type="email" id="inputEmail" required name="inputEmail" />
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label" for="inputCellulare">Cellulare</label>
                </div>
                <div class="span8 input-prepend">
                    <span class="add-on">+39</span>
                    <input type="text" id="inputCellulare" name="inputCellulare" required pattern="[0-9]{9,11}" />
                </div>
            </div>       
        </div>
        <div class="modal-footer">
            <a href="?p=us.dash" class="btn">Annulla</a>
            <button type="submit" class="btn btn-success">
                <i class="icon-plus"></i> Aggiungi Dipendente
            </button>
        </div>
    </div>
</form>
