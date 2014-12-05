<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

?>

<script type="text/javascript"><?php require './assets/js/presidente.utenti.js'; ?></script>
<?php if ( isset($_GET['app']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-ok"></i> <strong>Appartenenza confermata</strong>.
            L'appartenenza è stata confermata con successo.
        </div>
<?php } ?>
<?php if ( isset($_GET['neg']) ) { ?>
        <div class="alert alert-danger">
            <i class="icon-warning-sign"></i> <strong>Appartenenza negata</strong>.
           L'appartenenza è stata negata.
        </div>
<?php } ?>
<?php if ( isset($_GET['err']) ) { ?>
        <div class="alert alert-danger">
            <i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.
           Qualcosa nella procedura di approvazione non ha funzionato, per favore, riprova.
        </div>
<?php } ?>
<br/>
<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-instagram muted"></i>
            Fototessere in attesa
        </h2>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Volontari..." type="text">
        </div>
    </div>    
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="alert alert-block alert-info">
        <h4><i class="icon-question-sign"></i> Perchè non posso confermare tutte le fototessere in elenco?</h4>
        <p>La possibilità di confermare una fototessera di un Volontario implica che tu
        debba essere il presidente o il delegato Ufficio Soci di quella struttura. </p>
        <p>Ti è data possibilità di confermare tutte le fototessere dei volontari che
        fanno parte direttamente della tua struttura e di visualizzare quelle che dipendono
        da presidenti ed uffici soci di livello più basso.</p>
        </div>
    </div>
</div>
    
<hr />
<table class="table table-striped" id="tabellaUtenti">
    <thead>
        <th>Anteprima</th>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Codice Fiscale</th>
        <th>Comitato</th>
        <th>Azione</th>
    </thead>
<?php
$comitati = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);

foreach($comitati as $comitato) {
    foreach ( $comitato->fototesserePendenti() as $_v ) {
 ?>
    <tr>
        <td><img src="<?= $_v->fototessera()->img(10); ?>" class="img-polaroid" /></td>
        <td><?= $_v->nome; ?></td>
        <td><?= $_v->cognome; ?></td>
        <td><?= $_v->codiceFiscale; ?></td>
        <td><?= $comitato->nomeCompleto(); ?></td>
        <td>
            <div class="btn-group">
                <a class="btn btn-small" href="?p=presidente.utente.visualizza&id=<?php echo $_v->id; ?>" target="_new" title="Dettagli">
                    <i class="icon-eye-open"></i> Dettagli
                </a>
                <?php if($_v->modificabileDa($me)) {?>    
                    <a class="btn btn-success btn-small" href="?p=presidente.utente.fototessera.ok&id=<?php echo $_v->id; ?>&ok">
                        <i class="icon-ok"></i> Conferma
                    </a>
                    <a class="btn btn-danger btn-small" onClick="return confirm('Vuoi veramente negare appartenenza a questo utente ?');" href="?p=ppresidente.utente.fototessera.ok&id=<?php echo $_v->id; ?>&no">
                        <i class="icon-ban-circle"></i> Nega
                    </a>
                <?php } ?>
            </div>
        </td>
       
    </tr>
    <?php }
    }
   ?>
</table>