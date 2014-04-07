<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

controllaParametri(array('id'), 'us.dash&err');

$v = $_GET['id'];
$v = Volontario::id($v);

proteggiDatiSensibili($v, [APP_SOCI, APP_PRESIDENTE]);

?>

<br/>
<div class="row-fluid">
    <div class="span5 allinea-sinistra">
        <h2>
            <i class="icon-barcode muted"></i>
            Tesserini Rilasciati
        </h2>
        <p>Volontario: <strong><?= $v->nomeCompleto(); ?></strong></p>
    </div>            
    <div class="span3">
        <div class="btn-group btn-group-vertical span12">
            <a href="?p=presidente.utente.visualizza&id=<?= $v ?>" class="btn btn-block">
                <i class="icon-reply"></i>
                Torna indietro
            </a>
        </div>
    </div>
</div>
    
<hr />
    
<div class="row-fluid">
    <div class="span12">
        <?php if(isset($_GET['annullata'])) { ?>
            <div class="alert alert-error">
              <h4><i class="icon-warning-sign"></i> Qualcosa non ha funzionato</h4>
              <p>Sembra che tu sia cercando di modificare una quota precedentemente annullata.</p>
            </div>
        <?php } ?>
       
        <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>N.</th>
                <th>Validità</th>
                <th>Rilasciato da</th>
                <th>Stato</th>
                <th>Data richiesta</th>
                <th>Data ultima lavorazione</th>
                <th>Azioni</th>
            </thead>
            <?php

            $t = TesserinoRichiesta::filtra([['volontario', $v]]);
            foreach ( $t as $_t ){   
            ?>
            <tr>
                <!-- qui ci va il numero di tesserino che è attributo del volontario -->
                <td><?= $_t->codice ?></td>
                <td>
                    <?php if ($_t->valido()) { ?>
                        <span class="badge badge-success"><i class="icon-ok"></i> Valido</span>
                    <?php } else { ?>
                        <span class="badge badge-important"><i class="icon-remove"></i> Non Valido</span>
                    <?php }?>
                </td>
                <td><?php echo($_t->struttura()->nomeCompleto()); ?></td>
                <td><?php echo($conf['tesseriniStato'][$_t->stato]); ?></td>
                <td><?php echo($_t->data()->format('d/m/Y')); ?></td>
                <td><?php echo($_t->dataUltimaLavorazione()->format('d/m/Y')); ?></td>
                <td>
                    <div class="btn-group">
                    <!-- qui ci va la richiesta di duplicato 
                        <a class="btn btn-small btn-info" href="?p=us.quote.ricevuta&id=<?= $_q->id; ?>" title="Visualizza ricevuta">
                            <i class="icon-paperclip"></i> Ricevuta
                        </a> -->
                        <?php if( $me->admin()){ ?>
                        <a  onClick="return confirm('Vuoi veramente cancellare questa quota ?');" href="?p=admin.tesserino.cancella&id=<?php echo $_t->id; ?>" title="Cancella Quota" class="btn btn-small btn-danger">
                            <i class="icon-trash"></i>
                        </a>
                        <?php } ?>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>
