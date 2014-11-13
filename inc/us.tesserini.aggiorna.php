<?php

/*
* ©2014 Croce Rossa Italiana
*/

paginaPrivata();
paginaModale();

if (!isset($_GET['id'])) {
    redirect('us.tesserini');
}

$t = TesserinoRichiesta::id($_GET['id']);
$u = $t->utente();

if(!$me->admin() && $me->delegazioneAttuale()->comitato() != $t->struttura()) {
    redirect('errore.permessi&cattivo');
}

$ordinario = null;
$annulla = "?p=us.tesserini";

if(isset($_GET['ordinario'])){
    $ordinario = "&ordinario";
    $annulla = "?p=us.tesserini.ordinari";
}

if($t->stato == RICHIESTO) { ?>
<form action="?p=us.tesserini.stampa.ok" method="POST">

    <input type="hidden" name="id" value="<?php echo $t->id; ?>" />

    <div class="modal fade automodal">
        <div class="modal-header">
            <h3><i class="icon-credit-card"></i> Stampa del tesserino</h3>
        </div>
        <div class="modal-body">
            <?php if(isset($_GET['mot'])) { ?>
                <div class="alert alert-danger">
                <strong><i class="icon-warning-sign"></i> La motivazione è obbligatoria</strong>. <br />
                Devi indicare perchè non hai stampato il tesserino.
                </div>
            <?php } ?>
            <p><strong>Procedura per l'emissione del tesserino di <?= $u->nomeCompleto() ?></strong></p>
                <label class="radio">
                    <input type="radio" name="stampa" value="1" id="emesso" checked>
                    Emesso
                </label>
                <label class="radio">
                    <input type="radio" name="stampa" value="0" id="non">
                    Non Emesso
                </label>
                <div class="control-group nascosto" id="motivo">
                    <label class="control-label" for="inputMotivo">Motivo</label>
                    <div class="controls">
                        <input type="text" id="inputMotivo" name="inputMotivo" placeholder="es: fototessera non conforme">
                    </div>
                </div>
            <hr />
            <p><strong>Perchè devi fare ciò?</strong></p>
            <p>
            Con questo primo passo stai dichiarando che il tesserino di <?= $u->nomeCompleto() ?> è stato
            correttamente stampato.<br />
            Da questo momento il tesserino inizia ad essere valido a tutti gli effetti.
            </p>
            <p class="text-info"><i class="icon-info-sign"></i> 
            <strong>Nota bene: </strong> questa operazione verrà notificata a <?= $u->nome ?> via 
            email e non è in nessun modo reversibile
            </p>
        </div>
        <div class="modal-footer">
            <a href="<?= $annulla; ?>" class="btn">Annulla</a>
            <button type="submit" class="btn btn-success">
                <i class="icon-asterisk"></i> Aggiorna lavorazione
            </button>
        </div>
    </div>
</form>

<?php } elseif ($t->stato == STAMPATO) {
    if ( $u->ordinario()){
        $c = $u->unComitato(MEMBRO_ORDINARIO)->locale();
    }else{
        $c = $u->unComitato()->locale();
    }
?>
<form action="?p=us.tesserini.invia.ok" method="POST">
    <input type="hidden" name="id" value="<?php echo $t->id; ?>" />

    <div class="modal fade automodal">
        <div class="modal-header">
            <h3><i class="icon-credit-card"></i> Stampa del tesserino</h3>
        </div>
        <div class="modal-body">
            <p><strong>Procedura per la spedizione del tesserino di <?= $u->nomeCompleto(); ?></strong></p>
                <label class="radio">
                    <input type="radio" name="spedizione" value="1" id="comitato" checked>
                    Spedito presso il <strong><?= $c->nomeCompleto(); ?></strong> sito in <?= $c->formattato; ?>
                </label>
                <label class="radio">
                    <input type="radio" name="spedizione" value="0" id="casa">
                    Spedito all'indirizzo di residenza del Volontario (vedi scheda di dettaglio utente)
                </label>
            <hr />
            <p><strong>Perchè devi fare ciò?</strong></p>
            <p>
            Con questo secondo passo stai dichiarando che il tesserino di <?= $u->nomeCompleto() ?> è stato
            correttamente spedito.<br />
            </p>
            <p class="text-info"><i class="icon-info-sign"></i> 
            <strong>Nota bene: </strong> questa operazione verrà notificata a <?= $u->nome ?> via 
            email e non è in nessun modo reversibile
            </p>
        </div>
        <div class="modal-footer">
            <a href="<?= $annulla; ?>" class="btn">Annulla</a>
            <button type="submit" class="btn btn-success">
                <i class="icon-asterisk"></i> Aggiorna lavorazione
            </button>
        </div>
    </div>
</form>
<?php } else {
    redirect('errore.permessi&cattivo');
}
