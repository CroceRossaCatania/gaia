<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

?>
<script type="text/javascript"><?php require './assets/js/presidente.utenti.js'; ?></script>
<?php if ( isset($_GET['err']) ) { ?>
<div class="alert alert-danger">
    <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
    <p>Qualcosa nella procedura di approvazione non ha funzionato, per favore, riprova.</p>
</div>
<?php } ?>
<?php if (isset($_GET['ok'])) { ?>
<div class="alert alert-success">
    <strong><i class="icon-ok"></i> Azione eseguita</strong> correttamente [<?php echo date('H:i:s'); ?>]
</div>
<?php } ?>
<br/>
<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-star muted"></i>
            Titoli in attesa
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
            <h4><i class="icon-question-sign"></i> Perchè non posso confermare tutti i Titoli in elenco?</h4>
            <p>La possibilità di confermare i titoli di un Volontario implica che tu sia il Presidente del Comitato
                in cui il Volontario è iscritto come socio. </p>
                <p>Ti è data possibilità di confermare tutti i volontari che
                    fanno parte direttamente della tua struttura e di visualizzare informazioni su quelli in attesa che dipendono
                    da presidenti ed uffici soci di livello più basso.</p>
                </div>
            </div>
        </div>
        
        <hr />


        <table class="table table-striped table-bordered" id="tabellaUtenti">
            <thead>
                <th>Volontario</th>
                <th>Titolo</th>
                <th>Dettagli</th>
                <th>Azione</th>
            </thead>
            <?php 
            $comitati=$me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
            foreach($comitati as $comitato){
               foreach ( $comitato->titoliPendenti() as $_t ) {
                   $_v = $_t->volontario();
                   ?>
                   <tr>
                    <td>
                        <a href="?p=presidente.utente.visualizza&id=<?php echo $_v->id; ?>" target="_new">
                            <i class="icon-file-alt"></i> 
                            <?php echo $_v->nomeCompleto(); ?>
                        </a>
                    </td>
                    <td><strong><?php echo $_t->titolo()->nome; ?></strong></td>
                    <td><small>
                        <i class="icon-calendar muted"></i>
                        <?php echo date('d-m-Y', $_t->inizio); ?>
                        
                        <?php if ( $_t->fine ) { ?>
                        <br />
                        <i class="icon-time muted"></i>
                        <?php echo date('d-m-Y', $_t->fine); ?>
                        <?php } ?>
                        <?php if ( $_t->luogo ) { ?>
                        <br />
                        <i class="icon-road muted"></i>
                        <?php echo $_t->luogo; ?>
                        <?php } ?>
                        <?php if ( $_t->codice ) { ?>
                        <br />
                        <i class="icon-barcode muted"></i>
                        <?php echo $_t->codice; ?>
                        <?php } ?>
                        
                    </small></td>
                    <td>  
                        <?php if($_v->modificabileDa($me)) { ?>  
                        <a class="btn btn-success btn-block" href="?p=presidente.titolo.ok&id=<?php echo $_t->id; ?>&si">
                            <i class="icon-ok"></i>
                            &nbsp;Conferma&nbsp;
                        </a>
                        <a class="btn btn-danger btn-block btn-small" href="?p=presidente.titolo.ok&id=<?php echo $_t->id; ?>&no">
                            <i class="icon-ban-circle"></i>
                            Nega
                        </a>
                        <?php } ?>
                    </td>
                    
                </tr>
                <?php }}//} ?>
            </table>