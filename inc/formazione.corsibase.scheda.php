<?php

/*
* ©2013 Croce Rossa Italiana
*/

paginaAnonimo();
caricaSelettore();

controllaParametri(array('id'));

$corso = CorsoBase::id($_GET['id']);

$anonimo = false;
if ($me instanceof Anonimo) {
   $anonimo = true; 
}
$puoPartecipare = false;
if ($me->stato == ASPIRANTE) {
    $puoPartecipare = true;
}


$_titolo = $corso->nome . ' - Corso Base CRI su Gaia';
$_descrizione = $corso->luogo
." || Organizzato da " . $corso->organizzatore()->nomeCompleto();

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

            <div class="span8 btn-group">
                <?php if ( $corso->modificabileDa($me) ) { ?>
                <a href="?p=formazione.corsibase.modifica&id=<?php echo $corso->id; ?>" class="btn btn-large btn-info">
                    <i class="icon-edit"></i>
                    Modifica
                </a>
                <?php } ?>
                <a href="?p=formazione.corsibase.lezioni&id=<?= $corso ?>" class="btn btn-primary btn-large">
                    <i class="icon-calendar"></i> Lezioni
                </a>
                <a class="btn btn-large btn-primary" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode("https://gaia.cri.it/index.php?p=formazione.corsibase.scheda&id={$corso->id}"); ?>" target="_blank">
                    <i class="icon-facebook-sign"></i> Condividi
                </a>
            </div>
            <div class="span4 allinea-destra">
                <span class="muted">
                    <strong>Ultimo aggiornamento</strong>:<br />
                    <i class="icon-time"></i> <?php echo date("d/m/Y H:i:s", $corso->aggiornamento); ?>
                </span>
            </div>
        </div>
        <hr />
        <?php if (isset($_GET['err'])) { ?>
            <div class="alert alert-block alert-error">
                <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
                <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
            </div> 
        <?php } ?>
        <?php if (isset($_GET['gia'])) { ?>
            <div class="alert alert-block alert-error">
                <h4><i class="icon-warning-sign"></i> <strong>Sei già iscritto</strong>.</h4>
                <p>Stai cercando di iscriverti ad un corso a cui sei già iscritto.</p>
            </div> 
        <?php } ?>
        <?php if (isset($_GET['iscritto'])) { ?>
            <div class="alert alert-block alert-success">
                <h4><i class="icon-ok"></i> <strong>Operazione andata a buon fine</strong>.</h4>
                <p>La preiscrizione al corso è stata effettuata con successo.</p>
            </div> 
        <?php } ?>
        <?php if (isset($_GET['cancellato'])) { ?>
            <div class="alert alert-block alert-success">
                <h4><i class="icon-ok"></i> <strong>Operazione andata a buon fine</strong>.</h4>
                <p>La preiscrizione al corso è stata cancellata con successo.</p>
            </div> 
        <?php } ?>
        <?php if (!$corso->accettaIscrizioni()) { ?>
            <div class="alert alert-block alert-error">
                <h4><i class="icon-warning-sign"></i> <strong>Le iscrizioni sono chiuse</strong>.</h4>
                <p>Non puoi più effettuare tramite il portale la preiscrizione al corso, contatta il referente
                per avere maggiorni informazioni.</p>
            </div> 
        <?php } ?>
        <div class="row-fluid allinea-centro">
            <div class="span12">
                <h2 class="text-success"><?php echo $corso->nome(); ?></h2>
                <h4 class="text-info">
                    <i class="icon-map-marker"></i>
                    <a target="_new" href="<?php echo $corso->linkMappa(); ?>">
                        <?php echo $corso->luogo; ?>
                    </a>
                </h4>
            </div>
        </div>
        <hr />

        <div class="row-fluid allinea-centro">
            <div class="span3">
                <span>
                    <i class="icon-user"></i>
                    Direttore
                </span><br />
                <?php if ($puoPartecipare) { ?>
                    <a href="?p=utente.mail.nuova&id=<?php echo $corso->direttore()->id;?>">
                        <i class="icon-envelope"></i> <?php echo $corso->direttore()->nomeCompleto(); ?>
                    </a>
                <?php } else { ?>
                    <span class="text-info">
                        <strong><?php echo $corso->direttore()->nomeCompleto(); ?></strong>
                    </span>
                <?php } ?> 
            </div>
            <div class="span2">
                <span>
                    <i class="icon-flag"></i>
                    Stato
                </span><br />
                <span class="text-info">
                    <strong><?php echo $conf['corso_stato'][$corso->stato]; ?></strong>
                </span>
            </div>
            <div class="span2">
                <span>
                    <i class="icon-calendar"></i>
                    Data inizio
                </span><br />
                <span class="text-info">
                    <strong><?php echo $corso->inizio()->inTesto(false); ?></strong>
                </span>
            </div>
            <div class="span2">
                <span>
                    <i class="icon-group"></i>
                    Numero iscritti
                </span><br />
                <span class="text-info">
                    <strong><?php echo $corso->numIscritti(); ?></strong>
                </span>
            </div>
            <div class="span3">
                <span>
                    <i class="icon-home"></i>
                    Organizzato da
                </span><br />
                <span class="text-info">
                    <strong><?php echo $corso->organizzatore()->nomeCompleto(); ?></strong>
                </span>
            </div>
        </div>
        <hr />

        <div class="row-fluid">
            <div class="span12" style="max-height: 500px; padding-right: 10px; overflow-y: auto;">
                <h3>
                    <i class="icon-info-sign"></i>
                    Ulteriori informazioni
                </h3>
                <?php echo nl2br($corso->descrizione); ?>
            </div>
        </div>
        <hr />
        <?php if($puoPartecipare) { ?>
        <div class="row-fluid">
            <?php if ($corso->accettaIscrizioni() && !$corso->iscritto($me)) { ?>
            <div clas="span12">
                <a href="?p=formazione.corsibase.iscrizione.ok&id=<?php echo $corso->id ; ?>" class="btn btn-large btn-block btn-success">Preiscriviti al corso</a>
            </div>
            <?php } else { ?>
            <div class="span6">
                <button class="btn btn-large btn-block btn-primary disabled">Preiscrizione effettuata</button>
            </div>
            <div class="span6">
                <a href="?p=formazione.corsibase.iscrizione.cancella.ok&id=<?php echo $corso->id ; ?>" class="btn btn-large btn-block btn-danger">Cancella Preiscrizione</a>
            </div>
            <?php } ?>
        <div>
        <?php } ?>
        <div class="row-fluid">
            <div class="span12">
                <h3><i class="icon-time"></i> Elenco delle lezioni</h3>
            </div>
        </div>
            <?php if($puoPartecipare && $corso->accettaIscrizioni()) { ?>
            <div class="row-fluid">
                <div class="alert alert-info">
                    <i class="icon-info-sign"></i> <strong>Programma di massima</strong> 
                    <p>Il programma riportato di seguito potrebbe non essere quello definitivo.
                    In caso di dubbi contatta il <strong>direttore del corso</strong>.</p>
                </div>
            </div>
            <?php } ?>
            <div class="row-fluid">
                <table class="table table-bordered table-striped" id="turniAttivita">
                    <thead>
                        <th style="width: 25%;">Titolo</th>
                        <th style="width: 25%;">Data ed ora</th>
                        <th style="width: 35%;">Dettagli</th>
                        <th style="width: 15%;">Informazioni</th>
                    </thead>
                    <?php foreach ( $corso->lezioni() as $lezione ) { ?>
                    <tr>
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
                        if ( $corso->modificabileDa($me) ) { ?>
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
                                                <?php if( $me->delegazioni(APP_CO) && $corso->modificabileDa($me) && $potere){ ?>
                                                <a class="btn btn-small" href="?p=attivita.poteri&v=<?= $v->id; ?>&turno=<?= $turno; ?>">
                                                    <i class="icon-rocket" ></i> Conferisci poteri
                                                </a>
                                                <?php } ?>
                                                <?php if( $corso->modificabileDa($me) && $turno->fine >= time() && $turno->inizio >= time() ){ ?>
                                                <a class="btn btn-small btn-danger" href="?p=attivita.modifica.volontario.rimuovi&v=<?= $v->id; ?>&turno=<?= $turno; ?>">
                                                    <i class="icon-trash" ></i> Rimuovi volontario
                                                </a>
                                                <?php } ?>
                                            </li>
                                            <?php } ?>
                                        </ul>

                                        <?php if ( $corso->modificabileDa($me) ) { ?>

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
                                                <?php if( $turno->futuro() && $corso->modificabileDa($me) ){ ?>
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
                                        <?php if ( $corso->modificabileDa($me) ) { ?>
                                        <form action="?p=attivita.modifica.volontari.aggiungi&id=<?php echo $corso->id; ?>" method="POST">
                                            <input type="hidden" name="turno" value="<?php echo $turno->id; ?>" />
                                            <a data-selettore="true" data-input="volontari" data-autosubmit="true" data-multi="true" class="btn btn-block btn-primary btn-large btn-success">
                                                <i class="icon-plus"></i>
                                                Aggiungi volontari
                                            </a>
                                        </form>
                                        <a href="?p=attivita.report&id=<?php echo $corso->id; ?>" class="btn btn-block btn-info" data-attendere="Generazione in corso...">
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
                if($puoPartecipare && !$anonimo && $corso->lezioni()){ ?>
                <tr>
                    <td colspan="4">
                        <a data-attendere="Attendere..." href="?p=attivita.turni.passati&id=<?= $corso; ?>" class="btn btn-block">
                            <i class="icon-info-sign"></i>
                            Ci sono <span id="numTurniNascosti"></span> turni passati nascosti.
                            <strong>Clicca per mostrare tutti i turni.</strong>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <?php if ( $corso->modificabileDa($me) ) { ?>
        <div class="row-fluid">
            <div class="span12">
                <h3><i class="icon-group"></i> Elenco degli iscritti</h3>
            </div>
        </div>
        <div class="row-fluid">
            <table class="table table-striped table-bordered" id="tabellaUtenti">
                <thead>
                    <th>Foto</th>
                    <th>Nominativo</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Azione</th>
                </thead>
                <?php 
                $part = $corso->partecipazioni();

                foreach ( $part as $p ) { 
                    $iscritto = $p->utente(); ?>
                    <tr>
                        <td><img src="<?php echo $iscritto->avatar()->img(10); ?>" class="img-polaroid" /></td>
                        <td><?php echo $iscritto->nomeCompleto(); ?></td>
                        <td>
                            <span data-nascondi="" data-icona="icon-phone"><?php echo $iscritto->cellulare(); ?></span>
                        </td>
                        <td>
                            <span data-nascondi="" data-icona="icon-envelope"><?php echo $iscritto->email(); ?></span>
                        </td>
                        <td width="15%">
                            <div class="btn-group btn-group-vertical">
                                <a data-iscrizione="<?php echo $p->id; ?>" data-accetta="1" class="btn btn-success">
                                    <i class="icon-ok"></i> Accetta
                                </a>
                                <a data-iscrizione="<?php echo $p->id; ?>" data-accetta="0" class="btn btn-danger">
                                    <i class="icon-remove"></i> Rifiuta
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <?php } ?>
    </div>
</div>


