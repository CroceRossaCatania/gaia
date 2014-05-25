<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

?>

<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
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
            <i class="icon-group muted"></i>
            Appartenenze in attesa
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
        <h4><i class="icon-question-sign"></i> Perchè non posso confermare tutti i Volontari in elenco?</h4>
        <p>La possibilità di confermare l'appartenenza di un Volontario ad un determinato Comitato implica che tu
        debba essere il presidente di quella struttura. </p>
        <p>Ti è data possibilità di confermare tutti i volontari che
        fanno parte direttamente della tua struttura e di visualizzare informazioni su quelli in attesa che dipendono
        da presidenti ed uffici soci di livello più basso.</p>
        </div>
    </div>
</div>
    
<hr />
<table class="table table-striped" id="tabellaUtenti">
    <thead>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Codice Fiscale</th>
        <th>Data di Nascita</th>
        <th>Luogo di Nascita</th>
        <th>Comitato</th>
        <th>Azione</th>
    </thead>
<?php
$comitati = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);

foreach($comitati as $comitato) {
    foreach ( $comitato->appartenenzePendenti() as $_t ) {
        $_v = $_t->volontario();   // Una volta per tutte
 ?>
    <tr>
        <td><?php echo $_v->nome; ?></td>
        <td><?php echo $_v->cognome; ?></td>
        <td><?php echo $_v->codiceFiscale; ?></td>
        <td><?php echo date('d/m/Y', $_v->dataNascita); ?></td> 
        <td><?php echo $_v->comuneNascita; ?></td>
        <td><?php echo $comitato->nomeCompleto(); ?></td>
        <td>
            <div class="btn-group">
                <a class="btn btn-small" href="?p=presidente.utente.visualizza&id=<?php echo $_v->id; ?>" target="_new" title="Dettagli">
                    <i class="icon-eye-open"></i> Dettagli
                </a>
                <?php if($_v->modificabileDa($me)) {?>    
                <a class="btn btn-success btn-small" href="?p=presidente.appartenenzepending.ok&id=<?php echo $_t->id; ?>&si">
                    <i class="icon-ok"></i> Conferma
                </a>
                <a class="btn btn-danger btn-small" onClick="return confirm('Vuoi veramente negare appartenenza a questo utente ?');" href="?p=presidente.appartenenzepending.ok&id=<?php echo $_t->id; ?>&no">
                    <i class="icon-ban-circle"></i> Nega
                </a>
                <?php } ?>
                <?php if( $me->admin() ) {?>    
                <a class="btn btn-danger btn-small" href="?p=us.appartenenza.cancella&a=<?php echo $_t->id; ?>">
                    <i class="icon-trash"></i> Cancella
                </a>
                <?php } ?>
            </div>
        </td>
       
    </tr>
    <?php }
    }
   ?>
</table>