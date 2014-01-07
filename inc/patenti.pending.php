<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE , APP_PATENTI ]);

?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
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
            <i class="icon-truck muted"></i>
            Patenti in attesa
        </h2>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Volontario..." type="text">
        </div>
    </div>    
</div>

<hr />


<table class="table table-striped table-bordered" id="tabellaUtenti">
    <thead>
        <th>Volontario</th>
        <th>Patente</th>
        <th>Dettagli</th>
        <th>Azione</th>
    </thead>
<?php 
$comitati=$me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE , APP_PATENTI ]);
foreach($comitati as $comitato){
   foreach ( $comitato->patentiPendenti() as $p ) {
       $v = $p->volontario();
       ?>
        <tr>
            <td>
                <a href="?p=presidente.utente.visualizza&id=<?php echo $v->id; ?>" target="_new">
                    <i class="icon-file-alt"></i> 
                    <?php echo $v->nomeCompleto(); ?>
                </a>
            </td>
            <td><strong><?php echo $conf['patenti'][$p->patente()]; ?></strong></td>
            <td>
                <small>
                    <i class="icon-calendar muted"></i>
                    <?php echo date('d-m-Y', $p->inizio); ?>
                    <?php if ( $p->fine ) { ?>
                        <br />
                        <i class="icon-time muted"></i>
                        <?php echo date('d-m-Y', $p->fine); ?>
                    <?php } ?>
                    <?php if ( $p->codice ) { ?>
                        <br />
                        <i class="icon-barcode muted"></i>
                        <?php echo $p->codice; ?>
                    <?php } ?>
                </small>
            </td>
        <td>  
            <?php if($v->modificabileDa($me)) { ?>  
            <a class="btn btn-success btn-block" href="?p=patenti.pending.ok&id=<?php echo $p->id; ?>&si">
                <i class="icon-ok"></i>
                &nbsp;Conferma&nbsp;
            </a>
            <a class="btn btn-danger btn-block btn-small" href="?p=patenti.pending.ok&id=<?php echo $p->id; ?>&no">
                <i class="icon-ban-circle"></i>
                Nega
            </a>
            <?php } ?>
        </td>
        
    </tr>
    <?php }} ?>
</table>