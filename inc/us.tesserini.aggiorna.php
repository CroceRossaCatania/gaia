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

?>
<form action="?p=us.tesserini.aggiorna.ok" method="POST">

    <input type="hidden" name="id" value="<?php echo $t->id; ?>" />

    <div class="modal fade automodal">
        <div class="modal-header">
            <h3><i class="icon-credit-card"></i> Stampa del tesserino</h3>
        </div>
        <div class="modal-body">
            <p><strong>Organizzatore</strong><br />asd</p>
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
            <a href="?p=us.tesserini" class="btn">Annulla</a>
            <button type="submit" class="btn btn-success">
                <i class="icon-asterisk"></i> Aggiorna lavorazione
            </button>
        </div>
    </div>
</form>

