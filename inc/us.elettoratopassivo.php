<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);
$time = DT::createFromFormat('d/m/Y', $_GET['inputData']);
$tstamp = $time->getTimestamp();
?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<br/>
<div class="row-fluid">
    <div class="span5 allinea-sinistra">
        <h2>
            <i class="icon-group muted"></i>
            Elettorato passivo
        </h2>
        <p><strong>Del <?php echo $time->format("d/m/Y");?></strong></p>
    </div>
            
            <div class="span3">
                <div class="btn-group btn-group-vertical span12">
                    <a href="?p=us.elettoratoattivo&inputData=<?php echo $_GET['inputData']; ?>" class="btn btn-success btn-block">
                        <i class="icon-list"></i>
                        Elettorato attivo
                    </a>
                    <a href="?p=us.elettoratopassivo&inputData=<?php echo $_GET['inputData']; ?>" class="btn btn-danger btn-block">
                        <i class="icon-list"></i>
                        Elettorato passivo
                    </a>
                    <a href="?p=us.dash" class="btn btn-inf btn-block">
                        <i class="icon-reply"></i>
                        Torna alla dash
                    </a>
                </div>
            </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Volontari..." type="text">
        </div>
    </div>    
</div>
    
<hr />
    
<div class="row-fluid">
   <div class="span12">
       <div class="btn-group btn-group-vertical span12">
       <?php if ( count($me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ])) > 1 ) { ?>
       <a href="?p=admin.utenti.excel&elepass&time=<?php echo $tstamp; ?>" class="btn btn-block btn-inverse" data-attendere="Generazione e compressione in corso...">
           <i class="icon-download"></i>
            <strong>Ufficio Soci</strong> &mdash; Scarica tutti i fogli dei volontari in un archivio zip.
       </a>
       <?php } ?>
       <a href="?p=utente.mail.nuova&comelepass&time=<?php echo $tstamp; ?>" class="btn btn-block btn-success">
           <i class="icon-envelope"></i>
            <strong>Ufficio Soci</strong> &mdash; Invia mail di massa a tutti i Volontari.
       </a>
           <hr />
       </div>
       
       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Data di nascita</th>
                <th>Luogo di nascita</th>
                <th>Codice fiscale</th>
                <th>Ingresso in CRI</th>
                <th>Azioni</th>
            </thead>
        <?php
        $elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
        foreach($elenco as $comitato) {
            $t = $comitato->elettoriPassivi($time);
                ?>
            
            <tr class="success">
                <td colspan="7" class="grassetto">
                    <?php echo $comitato->nomeCompleto(); ?>
                    <span class="label label-warning">
                        <?php echo count($t); ?>
                    </span>
                    <a class="btn btn-success btn-small pull-right" href="?p=utente.mail.nuova&id=<?php echo $comitato->id; ?>&unitelepass">
                           <i class="icon-envelope"></i> Invia mail
                    </a>
                    <a class="btn btn-small pull-right" 
                       href="?p=presidente.utenti.excel&comitato=<?php echo $comitato->id; ?>&elepass&time=<?php echo $tstamp; ?>"
                       data-attendere="Generazione...">
                            <i class="icon-download"></i> scarica come foglio excel
                    </a>
                </td>
            </tr>
            
            <?php
            foreach ( $t as $_v ) {
            ?>
                <tr>
                    <td><?php echo $_v->nome; ?></td>
                    <td><?php echo $_v->cognome; ?></td>
                    <td><?php echo date('d/m/Y', $_v->dataNascita); ?></td>
                    <td>
                        <?php echo $_v->comuneNascita ?>,
                        <span class="muted">
                            <?php echo $_v->provinciaNascita; ?>
                        </span>
                    </td>
                    <td><?php echo $_v->codiceFiscale; ?></td>
                    <td><?php echo $_v->ingresso()->format("d/m/Y"); ?></td>
                    <td class="btn-group">
                        <a class="btn btn-small" href="?p=presidente.utente.visualizza&id=<?php echo $_v->id; ?>" title="Dettagli">
                            <i class="icon-eye-open"></i> Dettagli
                        </a>
                        <a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id=<?php echo $_v->id; ?>" title="Invia Mail">
                            <i class="icon-envelope"></i>
                        </a>
                   </td>
                </tr>
                
               
       
        <?php }
        }
        ?>

        </table>
       
    </div>
    
</div>
