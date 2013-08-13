<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Quota registrata</strong>.
            La quota è stata registrata.
        </div>
<?php }elseif ( isset($_GET['no']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-remove"></i> <strong>Quote annuali chiuse</strong>.
            Anno chiuso.
        </div>
<?php } ?>
    <br/>
<div class="row-fluid">
    <div class="span5 allinea-sinistra">
        <h2>
            <i class="icon-group muted"></i>
            Quote Pagate
        </h2>
    </div>
            
            <div class="span3">
                <div class="btn-group btn-group-vertical span12">
                        <a href="?p=us.quoteSi" class="btn btn-block btn-success">
                            <i class="icon-ok"></i>
                            Quote Pagate
                        </a>
                        <a href="?p=us.quoteNo" class="btn btn-block btn-danger">
                            <i class="icon-remove"></i>
                            Quote non pagate
                        </a>
                        <a href="?p=us.dash" class="btn btn-block">
                            <i class="icon-reply"></i>
                            Torna alla dash
                        </a>
                </div>
            </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Volontario..." type="text">
        </div>
    </div>    
</div>
    
<hr />
    
<div class="row-fluid">
   <div class="span12">
       <div class="btn-group btn-group-vertical span12">
       <?php if ( count($me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ])) > 1 ) { ?>
       <a href="?p=admin.utenti.excel&quotesi" class="btn btn-block btn-inverse" data-attendere="Generazione e compressione in corso...">
           <i class="icon-download"></i>
            <strong>Ufficio Soci</strong> &mdash; Scarica tutti i fogli dei volontari che hanno versato la quota in un archivio zip.
       </a>
       <?php } ?>
       <a href="?p=utente.mail.nuova&comquotesi" class="btn btn-block btn-success">
           <i class="icon-envelope"></i>
            <strong>Ufficio Soci</strong> &mdash; Invia mail di massa a tutti i Volontari.
       </a>ì<hr />
       </div>
       
       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Cognome</th>
                <th>Nome</th>
                <th>Località</th>
                <th>Cellulare</th>
                <th>Azioni</th>
            </thead>
        <?php
        $elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
        foreach($elenco as $comitato) {
            $t = $comitato->quoteSi();
                ?>
            
            <tr class="success">
                <td colspan="5" class="grassetto">
                    <?php echo $comitato->nomeCompleto(); ?>
                    <span class="label label-warning">
                        <?php echo count($t); ?>
                    </span>
                    <a class="btn btn-success btn-small pull-right" href="?p=utente.mail.nuova&id=<?php echo $comitato->id; ?>&unitquotesi">
                           <i class="icon-envelope"></i> Invia mail
                    </a>
                    <a class="btn btn-small pull-right" 
                       href="?p=presidente.utenti.excel&comitato=<?php echo $comitato->id; ?>&quotesi"
                       data-attendere="Generazione...">
                            <i class="icon-download"></i> scarica come foglio excel
                    </a>
                </td>
            </tr>
            
            <?php
            foreach ( $t as $_v ) {
            ?>
                <tr>
                    <td><?php echo $_v->cognome; ?></td>
                    <td><?php echo $_v->nome; ?></td>
                    <td>
                        <span class="muted">
                            <?php echo $_v->CAPResidenza; ?>
                        </span>
                        <?php echo $_v->comuneResidenza; ?>,
                        <?php echo $_v->provinciaResidenza; ?>
                    </td>
                    
                    <td>
                        <span class="muted">+39</span>
                            <?php echo $_v->cellulare; ?>
                    </td>

                    <td>
                        <div class="btn-group">
                            <a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id=<?php echo $_v->id; ?>" title="Invia Mail">
                                <i class="icon-envelope"></i>
                            </a>
                            <a class="btn btn-small btn-info" href="?p=us.quote.visualizza&id=<?php echo $_v->id; ?>" title="Invia Mail">
                                <i class="icon-paperclip"></i> Ricevute
                            </a>
                        </div>
                   </td>
                </tr>
                
               
       
        <?php }
        }
        ?>

        </table>
       
    </div>
    
</div>
