<?php

/*
 * ©2013 Croce Rossa Italiana
 */
paginaApp([APP_SOCI , APP_PRESIDENTE, APP_OBIETTIVO]);
?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Volontario eliminato</strong>.
            Il Volontario è stato eliminato con successo.
        </div>
<?php } elseif ( isset($_GET['e']) )  { ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-exclamation-sign"></i> Impossibile eliminare l'utente</h4>
            <p>Contatta l'amministratore</p>
        </div>
<?php }elseif ( isset($_GET['dim']) )  { ?>
        <div class="alert alert-block alert-success">
            <h4><i class="icon-exclamation-sign"></i> Volontario dimesso</h4>
            <p>Il Volontario è stato dimesso con successo.</p>
        </div>
<?php } ?>
    <br/>
<div class="row-fluid">
    <div class="span5 allinea-sinistra">
        <h2>
            <i class="icon-group muted"></i>
            Elenco volontari giovani
        </h2>
    </div>
            
            <div class="span3">
                <div class="btn-group btn-group-vertical span12">
                    <?php if (!$me->delegazioni(APP_OBIETTIVO)){ ?>
                        <a href="?p=presidente.utenti" class="btn btn-success btn-block">
                            <i class="icon-list"></i>
                            Volontari attivi
                        </a>
                        <a href="?p=presidente.utenti.dimessi" class="btn btn-danger btn-block">
                            <i class="icon-list"></i>
                            Volontari non attivi
                        </a>
                        <a href="?p=presidente.utenti.giovani" class="btn btn-block btn-info">
                            <i class="icon-list"></i>
                            Volontari giovani
                        </a>
                        <a href="?p=presidente.utenti.riserve" class="btn btn-block btn-warning">
                            <i class="icon-list"></i>
                            Volontari in riserva
                        </a>
                        <a href="?p=us.elettorato" class="btn btn-block btn-primary">
                            <i class="icon-list"></i>
                            Elenchi elettorato
                        </a>
                    <?php }else{ ?>
                        <a href="?p=obiettivo.dash" class="btn btn-block">
                            <i class="icon-reply"></i>
                            Torna Indietro
                        </a>
                    <?php } ?>
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
       <?php if ( count($me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE, APP_OBIETTIVO ])) > 1 ) { ?>
       <a href="?p=admin.utenti.excel&giovani" class="btn btn-block btn-inverse" data-attendere="Generazione e compressione in corso...">
           <i class="icon-download"></i>
            <strong>Ufficio Soci</strong> &mdash; Scarica tutti i fogli dei volontari giovani in un archivio zip.
       </a>
       <?php } ?>
       <a href="?p=utente.mail.nuova&comgio" class="btn btn-block btn-success">
           <i class="icon-envelope"></i>
            <strong>Ufficio Soci</strong> &mdash; Invia mail di massa a tutti i Giovani.
       </a><hr />
       </div>
            
       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Località</th>
                <th>Cellulare</th>
                <th>Azioni</th>
            </thead>
        <?php
        $elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE, APP_OBIETTIVO ]);
        foreach($elenco as $comitato) {
            $k =0;
            $t = $comitato->membriAttuali();
            $j = $t;
            foreach ( $j as $_j ) {
                if ($_j->giovane()){ $k++; }}
                ?>
            
            <tr class="success">
                <td colspan="7" class="grassetto">
                    <?php echo $comitato->nomeCompleto(); ?>
                    <span class="label label-warning">
                        <?php echo $k; ?>
                    </span>
                    <a class="btn btn-success btn-small pull-right" href="?p=utente.mail.nuova&id=<?php echo $comitato->id; ?>&unitgio">
                           <i class="icon-envelope"></i> Invia mail
                    </a>
                    <a class="btn btn-small pull-right" 
                       href="?p=presidente.utenti.excel&comitato=<?php echo $comitato->id; ?>&giovani"
                       data-attendere="Generazione...">
                            <i class="icon-download"></i> scarica come foglio excel
                    </a>
                </td>
            </tr>
            
            <?php
            foreach ( $t as $_v ) {
                if ($_v->giovane()){
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
                            <a class="btn btn-small" href="?p=presidente.utente.visualizza&id=<?php echo $_v->id; ?>" title="Dettagli">
                                <i class="icon-eye-open"></i> Dettagli
                            </a>
                            <?php if ( $me->presidenziante() || $me->admin() ){ ?>
                                <a class="btn btn-small btn-danger" href="?p=presidente.utente.dimetti&id=<?php echo $_v->id; ?>" title="Dimetti Volontario">
                                        <i class="icon-ban-circle"></i> Dimetti
                                </a>
                            <?php } ?>
                            <a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id=<?php echo $_v->id; ?>" title="Invia Mail">
                                <i class="icon-envelope"></i>
                            </a>
                            <?php if ($me->admin) { ?>
                                <a  onClick="return confirm('Vuoi veramente cancellare questo utente ?');" href="?p=presidente.utente.cancella&id=<?php echo $_v->id; ?>" title="Cancella Utente" class="btn btn-small btn-warning">
                                <i class="icon-trash"></i> Cancella
                                </a>
                                <a class="btn btn-small btn-primary" href="?p=admin.beuser&id=<?php echo $_v->id; ?>" title="Log in">
                                    <i class="icon-key"></i>
                                </a> 
                                <a class="btn btn-small btn-primary" href="?p=admin.presidente.nuovo&id=<?php echo $_v->id; ?>" title="Nomina Presidente">
                                    <i class="icon-star"></i>
                                </a> 
                                <a class="btn btn-small btn-danger <?php if ($_v->admin) { ?>disabled<?php } ?>" href="?p=admin.admin.nuovo&id=<?php echo $_v->id; ?>" title="Nomina Admin">
                                    <i class="icon-magic"></i>
                                </a>
                            <?php } ?>
                        </div>
                   </td>
                </tr>
                
               
       
        <?php }
        }
        }
        ?>

        </table>
       
    </div>
    
</div>
