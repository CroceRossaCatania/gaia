<?php

/*
 * ©2013 Croce Rossa Italiana
 */
paginaApp([APP_SOCI , APP_PRESIDENTE]);

menuElenchiVolontari(
    "Volontari in riserva",                // Nome elenco
    "?p=admin.utenti.excel&riserva",    // Link scarica elenco
    false                               // Link email elenco
);
?>

    
<div class="row-fluid">
   <div class="span12">
       <div class="btn-group btn-group-vertical span12">
      <?php if ( count($me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ])) > 1 ) { ?>
            <a href="?p=admin.utenti.excel&riserva" class="btn btn-block btn-inverse" data-attendere="Generazione e compressione in corso...">
                <i class="icon-download"></i>
                 <strong>Ufficio Soci</strong> &mdash; Scarica tutti i fogli dei volontari in riserva in un archivio zip.
            </a>
       <?php } ?>
       </div>
       <hr />
            
       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Inizio</th>
                <th>Fine</th>
                <th>Azioni</th>
            </thead>
        <?php
        $elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
        foreach( $elenco as $comitato ) {
            $r = $comitato->membriRiserva();
                ?>
            <tr class="success">
                <td colspan="7" class="grassetto">
                    <?php echo $comitato->nomeCompleto(); ?>
                    <span class="label label-warning">
                        <?php echo count($t); ?>
                    </span>
                    <a class="btn btn-success btn-small pull-right" href="?p=utente.mail.nuova&id=<?php echo $comitato->id; ?>&unitgio">
                           <i class="icon-envelope"></i> Invia mail
                    </a>
                    <a class="btn btn-small pull-right" 
                       href="?p=presidente.utenti.excel&comitato=<?php echo $comitato->id; ?>&riserva"
                       data-attendere="Generazione...">
                            <i class="icon-download"></i> scarica come foglio excel
                    </a>
                </td>
            </tr>
            
            <?php
            foreach ( $r as $_r ) {
                $_r = new Riserva($_r);
                $v = $_r->volontario();
            ?>
                <tr>
                    <td><?php echo $v->cognome; ?></td>
                    <td><?php echo $v->nome; ?></td>
                    <td><?php echo date('d/m/Y', $_r->inizio); ?></td>
                    <td><?php echo date('d/m/Y', $_r->fine); ?></td>

                    <td>
                        <div class="btn-group">
                            <a class="btn btn-small" href="?p=presidente.utente.visualizza&id=<?php echo $v->id; ?>" title="Dettagli">
                                <i class="icon-eye-open"></i> Dettagli
                            </a>
                            <a class="btn btn-small btn-danger" href="?p=presidente.utente.dimetti&id=<?php echo $v->id; ?>" title="Dimetti Volontario">
                                    <i class="icon-ban-circle"></i> Dimetti
                            </a>
                            <a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id=<?php echo $v->id; ?>" title="Invia Mail">
                                <i class="icon-envelope"></i>
                            </a>
                            <?php if ($me->admin) { ?>
                                <a  onClick="return confirm('Vuoi veramente cancellare questo utente ?');" href="?p=presidente.utente.cancella&id=<?php echo $v->id; ?>" title="Cancella Utente" class="btn btn-small btn-warning">
                                <i class="icon-trash"></i> Cancella
                                </a>
                                <a class="btn btn-small btn-primary" href="?p=admin.beuser&id=<?php echo $v->id; ?>" title="Log in">
                                    <i class="icon-key"></i>
                                </a> 
                                <a class="btn btn-small btn-primary" href="?p=admin.presidente.nuovo&id=<?php echo $v->id; ?>" title="Nomina Presidente">
                                    <i class="icon-star"></i>
                                </a> 
                                <a class="btn btn-small btn-danger <?php if ($_v->admin) { ?>disabled<?php } ?>" href="?p=admin.admin.nuovo&id=<?php echo $v->id; ?>" title="Nomina Admin">
                                    <i class="icon-magic"></i>
                                </a>
                            <?php } ?>
                        </div>
                   </td>
                </tr>
                
               
       
        <?php }
        }
        ?>

        </table>
       
    </div>
    
</div>
