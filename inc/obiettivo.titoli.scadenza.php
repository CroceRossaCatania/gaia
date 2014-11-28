<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_FORMAZIONE, APP_OBIETTIVO , APP_PRESIDENTE]);

$d = $me->delegazioneAttuale();

$tutto = false;
if($me->admin() || $me->presidenziante()) {
    $tutto = true;
} else {
    $area = $d->dominio;
}

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
            Titoli in scadenza
        </h2>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Volontario..." type="text">
        </div>
    </div>    
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="alert alert-block alert-info">
            <h4><i class="icon-question-sign"></i> Cosa sono i titoli in scadenza</h4>
            <p>Qui di seguito troverai una lista di volontari con titoli, inerenti la tua area, in scadenza nei prossimi 30 giorni ( <?php echo date('d/m/Y', time()+(GIORNO*30)); ?> ) . </p>
                </div>
            </div>
        </div>
        
        <hr />


        <table class="table table-striped table-bordered" id="tabellaUtenti">
            <thead>
                <th>Volontario</th>
                <th>Titolo</th>
                <th>Inizio</th>
                <th>Fine</th>
            </thead>
            <?php 
            $comitati=$me->comitatiApp ([ APP_FORMAZIONE, APP_OBIETTIVO, APP_PRESIDENTE ]);
            echo $area;
            $area = "";
            foreach($comitati as $comitato){
               foreach ( $comitato->titoliScadenza($area) as $_t ) {
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