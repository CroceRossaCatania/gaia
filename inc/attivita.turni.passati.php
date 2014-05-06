<?php

/*
* ©2013 Croce Rossa Italiana
*/

paginaPrivata();
caricaSelettore();

controllaParametri(array('id'));

$a = Attivita::id($_GET['id']);

$geoComitato = GeoPolitica::daOid($a->comitato);

if ( isset($_GET['riapri']) ) { ?>
<script type='text/javascript'>
$(document).ready( function() {
    $('#turno_<?php echo $_GET['riapri']; ?>').parents('tr').show();
    $('#turno_<?php echo $_GET['riapri']; ?>').modal('show');
});
</script>
<?php } ?>
<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>

    <div class="span9">
        <div class="row-fluid">
            <div class="row-fluid allinea-centro">
                <div class="span12">
                    <h2 class="text-success"><?php echo $a->nome; ?></h2>
                </div>
            </div>
            <hr />
            <div class="row-fluid">
                <div class="span8">
                    <h2><i class="icon-time"></i> Elenco turni dell'Attività</h2>
                </div>
                <div class="span4">
                    <?php if ( $a->modificabileDa($me) ) { ?>
                    <a href="?p=attivita.report&id=<?php echo $a->id; ?>" class="btn btn-large btn-block btn-primary" data-attendere="Generazione in corso...">
                        <i class="icon-download-alt"></i> Scarica report excel
                    </a>
                    <?php } ?>
                </div>

            </div>
            <div class="row-fluid">
                <div class="alert alert-info">
                    <i class="icon-info-sign"></i> In caso di turni <strong>pieni</strong> puoi
                    comunque dare la tua disponibilità aggiuntiva. Potra essere presa in considerazione
                    nel caso ci siano ulteriori posti a disposizione.
                </div>
            </div>
            <div class="row-fluid">
                <table class="table table-bordered table-striped" id="turniAttivita">
                    <thead>
                        <th style="width: 25%;">Nome</th>
                        <th style="width: 25%;">Data ed ora</th>
                        <th style="width: 35%;">Volontari</th>
                        <th style="width: 15%;">Partecipa</th>
                    </thead>
                    <?php foreach ( $a->turni() as $turno ) { ?>
                    <tr<?php if ( $turno->scoperto() ) { ?> class="warning"<?php } ?> data-timestamp="<?php echo $turno->fine()->toJSON(); ?>">

                    <td>
                        <a id="<?php echo $turno->id; ?>">
                            <big><strong><?php echo $turno->nome; ?></strong></big>
                            <br />
                            <?php echo $turno->durata()->format('%H ore %i min'); ?>
                        </td>
                        <td>
                            <big><?php echo $turno->inizio()->inTesto(); ?></big><br />
                            <span class="muted">Fine: <strong><?php echo $turno->fine()->inTesto(); ?></strong></span>
                            <span>Prenotarsi entro: <strong><?php echo $turno->prenotazione()->inTesto(); ?></strong></span>
                        </td>
                        <td>
                            <?php if ( $turno->scoperto() ) { ?>
                            <span class="label label-warning">
                                Scoperto!
                            </span><br />
                            <?php } ?>
                            <?php if ( $turno->pieno() ) { ?>
                            <span class="label label-important">
                                Pieno!
                            </span><br />
                            <?php } 
                            $accettate = $turno->volontari();
                            ?>
                            <strong>Volontari: <?php echo count($accettate); ?></strong><br />
                            Min. <?php echo $turno->minimo; ?> &mdash; Max. <?php echo $turno->massimo; ?><br />
                            <a data-toggle="modal" data-target="#turno_<?php echo $turno->id; ?>"><i class="icon-list"></i> Vedi tutti i volontari</a>
                            <?php if ( $a->modificabileDa($me) ) { ?>
                            (<a data-toggle="modal" data-target="#turno_<?php echo $turno->id; ?>"><i class="icon-plus"></i> Aggiungi</a>)
                            <?php } ?>

                            <br />
                            <?php foreach ( $accettate as $ppp ) { ?>
                            <a href="?p=profilo.controllo&id=<?php echo $ppp->id; ?>" target="_new" title="<?php echo $ppp->nomeCompleto(); ?>">
                                <img width="30" height="30" src="<?php echo $ppp->avatar()->img(10); ?>" />
                            </a>
                            <?php } ?>
                            <div id="turno_<?php echo $turno->id; ?>" class="modal hide fade">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h3><?php echo $turno->nome; ?> <span class="muted"><?php echo $turno->inizio()->inTesto(); ?></span></h3>
                                </div>
                                <div class="modal-body">
                                    <div class="row-fluid">
                                        <div class="span7">
                                            <p class="text-success"><i class="icon-group"></i> Volontari partecipanti
                                                <span class="badge badge-success"><?php echo count($accettate); ?></span>
                                            </p>
                                            <ul>
                                                <?php foreach ( $accettate as $v ) { ?>
                                                <li>
                                                    <a href="?p=public.utente&id=<?php echo $v->id; ?>" target="_new">
                                                        <?php   $potere = true;
                                                        $colore = "#222"; 
                                                        if ($turno->partecipazione($v)->poteri()) { 
                                                            $colore = "#0000FF"; 
                                                            $potere = false;
                                                        }
                                                        echo "<span style='color: {$colore};'>"; 
                                                        echo $v->nomeCompleto(); 
                                                        echo "</span>";
                                                        ?>
                                                    </a>
                                                    <?php if( $me->delegazioni(APP_CO) && $a->modificabileDa($me) && $potere){ ?>
                                                    <a class="btn btn-small" href="?p=attivita.poteri&v=<?= $v->id; ?>&turno=<?= $turno; ?>">
                                                        <i class="icon-rocket" ></i> Conferisci poteri
                                                    </a>
                                                    <?php } ?>
                                                    <?php if( $a->modificabileDa($me) && $turno->fine >= time() && $turno->inizio >= time() ){ ?>
                                                    <a class="btn btn-small btn-danger" href="?p=attivita.modifica.volontario.rimuovi&v=<?= $v->id; ?>&turno=<?= $turno; ?>">
                                                        <i class="icon-trash" ></i> Rimuovi volontario
                                                    </a>
                                                    <?php } ?>
                                                </li>
                                                <?php } ?>
                                            </ul>

                                            <?php if ( $a->modificabileDa($me) ) { ?>

                                            <hr />
                                            <?php
                                            $x = $turno->volontari(AUT_PENDING);
                                            ?>
                                            <p class="text-warning"><i class="icon-group"></i> Volontari in attesa
                                                <span class="badge badge-warning"><?php echo count($x); ?></span>
                                            </p>
                                            <ul>
                                                <?php foreach ( $x as $v ) { ?>
                                                <li>
                                                    <a href="?p=public.utente&id=<?php echo $v->id; ?>" target="_new">
                                                        <?php echo $v->nomeCompleto(); ?>
                                                    </a>
                                                </li>
                                                <?php } ?>
                                            </ul>

                                            <hr />

                                            <?php
                                            $x = $turno->volontari(AUT_NO);
                                            ?>
                                            <p class="text-error"><i class="icon-group"></i> Volontari non autorizzati
                                                <span class="badge badge-important"><?php echo count($x); ?></span>
                                            </p>
                                            <ul>
                                                <?php foreach ( $x as $v ) { ?>
                                                <li>
                                                    <a href="?p=public.utente&id=<?php echo $v->id; ?>" target="_new">
                                                        <?php echo $v->nomeCompleto(); ?>
                                                    </a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                            <?php } ?>
                                        </div>
                                        <div class="span5">
                                            <?php if ( $a->modificabileDa($me) ) { ?>
                                            <form action="?p=attivita.modifica.volontari.aggiungi&id=<?php echo $a->id; ?>" method="POST">
                                                <input type="hidden" name="turno" value="<?php echo $turno->id; ?>" />
                                                <a data-selettore="true" 
                                                   data-input="volontari" 
                                                   data-autosubmit="true" 
                                                   data-multi="true" 
                                                   data-comitati="<?php echo $a->comitato; ?>"
                                                   class="btn btn-block btn-primary btn-large btn-success">
                                                    <i class="icon-plus"></i>
                                                    Aggiungi volontari
                                                </a>
                                            </form>
                                            <a href="?p=attivita.report&id=<?php echo $a->id; ?>" class="btn btn-block btn-info" data-attendere="Generazione in corso...">
                                                <i class="icon-file-alt"></i>
                                                Scarica tutti i dati
                                            </a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="#" class="btn" data-dismiss="modal">Chiudi</a>
                                </div>
                            </div>

                        </td>
                        <td>
                            <?php if ( $pk = $turno->partecipazione($me) ) { ?>
                            <a class="btn btn-block btn-info btn-large disabled" href="">
                                <?php echo $conf['partecipazione'][$pk->stato]; ?>
                            </a>
                            <?php if($pk->stato == PART_PENDING && $turno->inizio >= time()) {?>
                            <a class="btn btn-block btn-danger " href="?p=attivita.ritirati&id=<?php echo $pk->id; ?>">
                                <i class="icon-remove"></i>
                                Ritirati
                            </a>
                            <?php } 
                        } elseif ( $turno->puoRichiederePartecipazione($me) && !$me->inriserva()) { 
                            if($turno->pieno()) { ?> 
                            <a data-attendere="Attendere..." name="<?= $turno->id; ?>" href="?p=attivita.partecipa&turno=<?php echo $turno->id; ?>" class="btn btn-warning btn-block">
                                <i class="icon-warning-sign"></i> Dai disponibilità
                            </a>
                            <?php } else  { ?>
                            <a data-attendere="Attendere..." name="<?= $turno->id; ?>" href="?p=attivita.partecipa&turno=<?php echo $turno->id; ?>" class="btn btn-success btn-large btn-block">
                                <i class="icon-ok"></i> Partecipa
                            </a>
                            <?php } 
                        } else { ?>
                        <a class="btn btn-block disabled">
                            <i class="icon-info-sign"></i>
                            Non puoi partecipare
                        </a>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>