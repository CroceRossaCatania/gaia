<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

controllaParametri(array('id'), 'us.dash&err');

$v = $_GET['id'];
$v = Volontario::id($v);
$appartenenza = $v->storico();
?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<br/>
<div class="row-fluid">
    <div class="span5 allinea-sinistra">
        <h2>
            <i class="icon-paperclip muted"></i>
            Quote associative
        </h2>
        <p>Volontario: <strong><?= $v->nomeCompleto(); ?></strong></p>
    </div>
            
            <div class="span3">
                <div class="btn-group btn-group-vertical span12">
                    <a href="?p=us.quoteSi" class="btn btn-block">
                        <i class="icon-reply"></i>
                        Torna indietro
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
        <?php if(isset($_GET['annullata'])) { ?>
            <div class="alert alert-error">
              <h4><i class="icon-warning-sign"></i> Qualcosa non ha funzionato</h4>
              <p>Sembra che tu sia cercando di modificare una quota precedentemente annullata.</p>
            </div>
        <?php } ?>
       
       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>N.</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Comitato</th>
                <th>Data versamento</th>
                <th>Quota</th>
                <th>Stato</th>
                <th>Azioni</th>
            </thead>
        <?php
foreach ( $appartenenza as $app ) { 
$q = Quota::filtra([['appartenenza', $app]], 'timestamp DESC');
    foreach ( $q as $_q ){   
                ?>
                <tr>
                    <td><?= $_q->progressivo(); ?></td>
                    <td><?= $_q->volontario()->nome; ?></td>
                    <td><?= $_q->volontario()->cognome; ?></td>
                    <td><?= $_q->comitato()->nomeCompleto(); ?></td>
                    <td><?= date('d/m/Y', $_q->timestamp); ?></td>
                    <td>€ <?php echo soldi($_q->quota);  ?></td>
                    <td>
                        <?php if($ann = $_q->annullata()) { ?>
                            Annullata da <?= $_q->annullatore()->nomeCompleto(); ?>
                            il <?= $_q->dataAnnullo()->format('d/m/Y'); ?>
                        <?php } else { ?>
                            Regolare
                        <?php } ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <?php if(!$ann) { ?>
                            <a class="btn btn-small btn-info" href="?p=us.quote.ricevuta&id=<?= $_q->id; ?>" title="Visualizza ricevuta">
                                <i class="icon-paperclip"></i> Ricevuta
                            </a>
                            <?php } 
                                if( $me->admin()){ ?>
                                <?php if(!$ann) { ?>
                                <a class="btn btn-small btn-info" href="?p=us.quote.modifica&id=<?= $_q->id; ?>" title="Modifica quota">
                                    <i class="icon-edit"></i>
                                </a>
                                <?php } ?>
                                <a  onClick="return confirm('Vuoi veramente cancellare questa quota ?');" href="?p=admin.quota.cancella&id=<?php echo $_q->id; ?>" title="Cancella Quota" class="btn btn-small btn-danger">
                                    <i class="icon-trash"></i>
                                </a>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
                <?php 
}
    }
?>
        </table>
    </div>
    
</div>

