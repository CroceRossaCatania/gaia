<?php

/*
* ©2013 Croce Rossa Italiana
*/

paginaAnonimo();
caricaSelettore();

controllaParametri(array('id'));

$a = Attivita::id($_GET['id']);
$puoPartecipare = false;
if ($a->puoPartecipare($me)) {
    $puoPartecipare = true;
}
$anonimo = false;
if ($me instanceof Anonimo) {
   $anonimo = true; 
}

$geoComitato = GeoPolitica::daOid($a->comitato);
$_titolo = $a->nome . ' - Attività CRI su Gaia';
$_descrizione = $a->luogo . " || Aperto a: " . $conf['att_vis'][$a->visibilita]
." || Organizzato da " . $geoComitato->nomeCompleto();

$g = Gruppo::by('attivita', $a);
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
            <?php if (isset($_GET['pot'])) { ?>
            <div class='alert alert-block alert-success'>
                <h4>Poteri conferiti con successo &mdash; <?php echo date('d-m-Y H:i:s'); ?></h4>
            </div>
            <?php } ?>
            <?php if (isset($_GET['not'])) { ?>
            <div class='alert alert-block alert-danger'>
                <h4>Poteri già conferiti</h4>
            </div>
            <?php } ?>
            <?php if (isset($_GET['gok'])) { ?>
                <div class='alert alert-block alert-success'>
                    <h4>Gruppo di lavoro creato con successo &mdash; <?php echo date('d-m-Y H:i:s'); ?></h4>
                </div>
            <?php } ?>

            <div class="span8 btn-group">
                <?php if ( $a->modificabileDa($me) ) { ?>
                <a href="?p=attivita.modifica&id=<?php echo $a->id; ?>" class="btn btn-large btn-info">
                    <i class="icon-edit"></i>
                    Modifica
                </a>
                <a href="?p=attivita.turni&id=<?= $a ?>" class="btn btn-primary btn-large">
                    <i class="icon-calendar"></i> Turni
                </a>
                <a href="?p=attivita.cancella&id=<?= $a->id; ?>" class="btn btn-large btn-danger" title="Cancella attività e tutti i turni">
                    <i class="icon-trash"></i>
                </a>
                <?php if (!$g && $a->comitato()->_estensione() < EST_PROVINCIALE){ ?>
                    <a class="btn btn-large btn-success" href="?p=attivita.gruppo.nuovo&id=<?php echo $a->id; ?>" itle="Crea nuovo gruppo di lavoro">
                        <i class="icon-group"></i> Crea gruppo
                    </a>
                <?php }} ?>
                <a class="btn btn-large btn-primary" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode("https://gaia.cri.it/index.php?p=attivita.scheda&id={$a->id}"); ?>" target="_blank">
                    <i class="icon-facebook-sign"></i> Condividi
                </a>
            </div>
            <div class="span4 allinea-destra">
                <span class="muted">
                    <strong>Ultimo aggiornamento</strong>:<br />
                    <i class="icon-time"></i> <?php echo date("d/m/Y H:i:s", $a->timestamp); ?>
                </span>
            </div>
        </div>
        <hr />
        <div class="row-fluid allinea-centro">
            <div class="span12">
                <h2 class="text-success"><?php echo $a->nome; ?></h2>
                <h4 class="text-info">
                    <i class="icon-map-marker"></i>
                    <a target="_new" href="<?php echo $a->linkMappa(); ?>">
                        <?php echo $a->luogo; ?>
                    </a>
                </h4>
            </div>
        </div>
        <hr />
        <?php
        $ts = $a->turniScoperti();
        $tsn = count($ts);
        if ($puoPartecipare && $ts ) { ?>
        <div class="span12">
            <div class="alert alert-block alert-error allinea-centro">
                <h4 class="text-error ">
                    <i class="icon-warning-sign"></i>
                    Ci sono <?php echo $tsn; ?> turni scoperti
                </h4>
                <p>Aiutaci a colmare i posti mancanti!</p>
            </div>
        </div>
        <hr/>
        <?php } ?>

        <div class="row-fluid allinea-centro">
            <div class="span3">
                <span>
                    <i class="icon-user"></i>
                    Referente
                </span><br />
                <a href="?p=utente.mail.nuova&id=<?php echo $a->referente()->id;?>">
                    <?php echo $a->referente()->nome . ' ' . $a->referente()->cognome; ?>
                </a>
                <br />
                <?php if ($puoPartecipare && !$anonimo) { ?>
                <span class="muted">+39</span> <?php echo $a->referente()->cellulare(); ?>
                <?php } ?>
            </div>
            <div class="span3">
                <span>
                    <i class="icon-globe"></i>
                    Area d'intervento
                </span><br />
                <span class="text-info">
                    <?php echo $a->area()->nomeCompleto(); ?>
                </span>
            </div>
            <div class="span3">
                <span>
                    <i class="icon-home"></i>
                    Organizzato da
                </span><br />
                <span class="text-info">
                <?php echo $geoComitato->nomeCompleto(); ?>
                </span>
            </div>
            <div class="span3">
                <span>
                    <i class="icon-lock"></i>
                    Partecipazione
                </span><br />
                <span class="text-info">
                    <strong><?php echo $conf['att_vis'][$a->visibilita]; ?></strong>
                </span>
            </div>
        </div>
        <hr />
        <?php if($puoPartecipare && !$anonimo) { ?>
        <div class="row-fluid">
            <div class="span5" style="max-height: 500px; padding-right: 10px; overflow-y: auto;">
                <h4>
                    <i class="icon-info-sign"></i>
                    Ulteriori informazioni
                </h4>
                <?php echo nl2br($a->descrizione); ?>
            </div>
            <div class="span7">
                <button id="pulsanteScrivi" class="btn btn-info pull-right">
                    <i class="icon-pencil"></i>
                    Scrivi
                </button>
                <h4>
                    <i class="icon-comments-alt"></i>
                    Discussione e avvisi
                </h4>
                <?php $commenti = $a->commenti(); ?>
                <?php if ( $me instanceof Anonimo ) { ?>
                <div class="row-fluid">
                    <div class="span9">
                        <textarea rows="2" class="span12" disabled="disabled" class="disabled">Accedi per commentare</textarea>
                    </div>
                    <div class="span3">
                        <a href="?p=attivita.pagina.commento.ok&id=<?php echo $a->id; ?>" class="btn btn-large btn-warning">
                            <i class="icon-signin"></i> Accedi
                        </a>
                    </div>
                </div>
                <?php } else { ?>
                <form id="boxScrivi" action="?p=attivita.pagina.commento.ok&id=<?php echo $a->id; ?>" method="POST" class="row-fluid <?php if ( $commenti ) { ?>nascosto<?php } ?>">
                    <div class="span9">
                        <textarea name="inputCommento" autofocus placeholder="Scrivi il tuo messaggio..." rows="3" class="span12"></textarea>
                        <?php if ( $a->modificabileDa($me) ) { ?>
                        <label>
                            <input type="checkbox" checked name="annuncia" />
                            <strong>
                                <i class="icon-bullhorn"></i>
                                Annuncia tramite email
                            </strong> ai futuri partecipanti
                        </label>
                        <?php } ?>
                    </div>
                    <div class="span3">
                        <button type="submit" class="btn btn-large btn-success btn-block" data-attendere="Invio...">
                            Invia <i class="icon-ok"></i>
                        </button>
                    </div>
                </form>
                <?php } ?>
                <div class="row-fluid" style="max-height: 450px; padding-right: 10px; overflow: auto;">
                    <?php foreach ( $commenti as $c ) {
                        $autore = $c->autore();
                        ?>
                        <div class="row-fluid" id="commento">
                            <div class="span2 allinea-destra">
                                <a href="?p=profilo.controllo&id=<?php echo $autore->id; ?>" target="_new">
                                    <img src="<?php echo $autore->avatar()->img(10); ?>" width="50" height="50" class="img-circle" />
                                </a>
                            </div>
                            <div class="span10">
                                <small class="text-info">
                                    <strong>
                                        <a href="?p=profilo.controllo&id=<?php echo $autore->id; ?>" target="_new"><?php echo $autore->nomeCompleto(); ?></a></strong>,
                                        <?php echo $c->quando()->inTesto(); ?>
                                    </small>
                                    <?php if ( $me->id == $autore->id || $a->modificabileDa($me) ) { ?>
                                    <a class="pull-right text-warning" href="?p=attivita.pagina.commento.cancella&id=<?php echo $c->id; ?>">
                                        <small>
                                            <i class="icon-trash"></i>
                                            cancella
                                        </small>
                                    </a>
                                    <?php } ?>
                                    <p class="text"><?php echo $c->commento; ?></p>
                                    <?php $r = $c->risposte(); ?>
                                    <small><a href="?p=attivita.pagina&id=<?= $a->id; ?>#<?= $c->id; ?>"><i class="icon-comment"></i> <?php if (count($r)==0){ ?> Nessun comento<?php }elseif(Count($r)==1){ echo count($r); ?> Commento<?php }else{ echo count($r); ?> Commenti<?php } ?></a></small>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if ( !$commenti ) { ?>
                            <div class="alert alert-info">
                                Nessun commento. Sii il primo a scrivere!
                            </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>
                <hr />
                <?php } ?>
                
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
                <?php if($puoPartecipare) { ?>
                <div class="row-fluid">
                    <div class="alert alert-info">
                        <i class="icon-info-sign"></i> In caso di turni <strong>pieni</strong> puoi
                        comunque dare la tua disponibilità aggiuntiva. Potra essere presa in considerazione
                        nel caso ci siano ulteriori posti a disposizione.
                    </div>
                </div>
                <?php } ?>
                <div class="row-fluid">
                    <table class="table table-bordered table-striped" id="turniAttivita">
                        <thead>
                            <th style="width: 25%;">Nome</th>
                            <th style="width: 25%;">Data ed ora</th>
                            <th style="width: 35%;">Volontari</th>
                            <th style="width: 15%;">Partecipa</th>
                        </thead>
                        <?php foreach ( $a->turniFut() as $turno ) { ?>
                        <tr<?php if ( $turno->scoperto() ) { ?> class="warning"<?php } ?> data-timestamp="<?php echo $turno->fine()->toJSON(); ?>">

                        <td>
                            <div id="<?php echo $turno->id; ?>">
                            <big><strong><?php echo $turno->nome; ?></strong></big>
                            </div>
                            <?php echo $turno->durata()->format('%H ore %i min'); ?>
                        </td>
                        <td>
                            <big><?php echo $turno->inizio()->inTesto(); ?></big><br />
                            <span class="muted">Fine: <strong><?php echo $turno->fine()->inTesto(); ?></strong></span>
                            <?php if(!$anonimo) {?>
                            <span>Prenotarsi entro: <strong><?php echo $turno->prenotazione()->inTesto(); ?></strong></span>
                            <?php } ?>
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
                            <?php } ?>
                            <?php
                            
                            $accettate = $turno->volontari();
                            
                            ?>
                            <strong>Volontari: <?php echo count($accettate); ?></strong><br />
                            Min. <?php echo $turno->minimo; ?> &mdash; Max. <?php echo $turno->massimo; ?><br />
                            <?php if(!$anonimo) {?>
                            <a data-toggle="modal" data-target="#turno_<?php echo $turno->id; ?>"><i class="icon-list"></i> Vedi tutti i volontari</a>
                            <?php }
                            if ( $a->modificabileDa($me) ) { ?>
                            (<a data-toggle="modal" data-target="#turno_<?php echo $turno->id; ?>"><i class="icon-plus"></i> Aggiungi</a>)
                            <?php } ?>

                            
                            <?php if ($puoPartecipare && !$anonimo) { ?>
                                <br />
                                <?php
                                foreach ( $accettate as $ppp ) { ?>
                                <a href="?p=profilo.controllo&id=<?php echo $ppp->id; ?>" target="_new" title="<?php echo $ppp->nomeCompleto(); ?>">
                                    <img width="30" height="30" src="<?php echo $ppp->avatar()->img(10); ?>" />
                                </a>
                            <?php }
                            } ?>
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
                                                    <a href="?p=profilo.controllo&id=<?php echo $v->id; ?>" target="_new">
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
                                                    <a href="?p=profilo.controllo&id=<?php echo $v->id; ?>" target="_new">
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
                                                    <a href="?p=profilo.controllo&id=<?php echo $v->id; ?>" target="_new">
                                                        <?php echo $v->nomeCompleto(); ?>
                                                    </a>
                                                    <?php if( $turno->futuro() && $a->modificabileDa($me) ){ ?>
                                                        <a class="btn btn-small btn-success" href="?p=attivita.modifica.volontario.autorizza&v=<?= $v->id; ?>&turno=<?= $turno; ?>">
                                                            <i class="icon-trash" ></i> Autorizza volontario
                                                        </a>
                                                    <?php } ?>
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
                    <?php } 
                    if($puoPartecipare && !$anonimo && $a->turni() != $a->turniFut()){ ?>
                    <tr>
                        <td colspan="4">
                            <a data-attendere="Attendere..." href="?p=attivita.turni.passati&id=<?= $a; ?>" class="btn btn-block">
                                <i class="icon-info-sign"></i>
                                Ci sono <span id="numTurniNascosti"></span> turni passati nascosti.
                                <strong>Clicca per mostrare tutti i turni.</strong>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
    
