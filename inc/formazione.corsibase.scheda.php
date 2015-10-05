<?php

/*
* ©2014 Croce Rossa Italiana
*/

paginaAnonimo();
caricaSelettore();

controllaParametri(['id']);

$corso = CorsoBase::id($_GET['id']);

$anonimo = false;
if ($me instanceof Anonimo) {
   $anonimo = true; 
}
$puoPartecipare = false;
if ($me->stato == ASPIRANTE) {
    $puoPartecipare = true;
}

$p = PartecipazioneBase::filtra([
    ['volontario', $me->id],
    ['corsoBase', $corso->id],
    ['stato', ISCR_CONFERMATA]
    ]);

$iscritto = false;
if($p) {
    $iscritto = true;
}

if(!$me->admin() && !$corso->direttore()) {
    redirect("formazione.corsibase.direttore&id={$corso->id}");
}

$part = $corso->partecipazioni(ISCR_CONFERMATA);



$_titolo = $corso->nome . 'Corso Base CRI su Gaia';
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
    <?php if (!$anonimo ){ ?>
        <div class="span3">
            <?php menuVolontario(); ?>
        </div>

        <div class="span9">
    <?php }else{ ?>
        <div class="span12">
    <?php } ?>
        <div class="row-fluid">
            <div class="span8 btn-group">
                <?php if ( $corso->modificabileDa($me) && !$corso->concluso()) { ?>
                <a href="?p=formazione.corsibase.modifica&id=<?php echo $corso->id; ?>" class="btn btn-large btn-info">
                    <i class="icon-edit"></i>
                    Modifica
                </a>
                <?php if($corso->daCompletare() && $corso->haPosizione()) { ?>
                    <a href="?p=formazione.corsibase.email.aspiranti&id=<?= $corso ?>" class="btn btn-success btn-large">
                        <i class="icon-flag-checkered"></i> Attiva Corso
                    </a>
                <?php } ?>

                <a href="?p=formazione.corsibase.lezioni&id=<?= $corso ?>" class="btn btn-primary btn-large">
                    <i class="icon-calendar"></i> Gestisci Lezioni
                </a>

                <?php } ?>
                <?php if(!$corso->daCompletare()) { ?>
                <a class="btn btn-large btn-primary" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode("https://gaia.cri.it/index.php?p=formazione.corsibase.scheda&id={$corso->id}"); ?>" target="_blank">
                    <i class="icon-facebook-sign"></i> Condividi
                </a>
                <?php } ?>
            </div>
            <div class="span4 allinea-destra">
                <span class="muted">
                    <strong>Ultimo aggiornamento</strong>:<br />
                    <i class="icon-time"></i> <?php echo date("d/m/Y H:i:s", $corso->aggiornamento); ?>
                </span>
            </div>
        </div>
        <hr />
        <?php if ( $corso->modificabileDa($me) && !$corso->haPosizione()) { ?>
            <div class="alert alert-block">
                <h4><i class="icon-warning-sign"></i> <strong>Non hai indicato dove si svolge il corso!</strong></h4>
                <p>Per inserire queste informazioni premi su <strong><i class="icon-edit"></i> Modifica</strong>
                e scegli il luogo da indicare come sede del corso. Fino a che
                non effettuerai questa operazione nessuno si potrà iscrivere al corso e il corso non sarà
                visibile ai potenziali aspiranti.</p>
            </div> 
        <?php } elseif ( $corso->modificabileDa($me) && $corso->daCompletare()) { ?>
            <div class="alert alert-block">
                <h4><i class="icon-warning-sign"></i> <strong>Questo corso non è ancora attivo!</strong></h4>
                <p>Per attivare il corso premi su <strong><i class="icon-flag-checkered"></i> Attiva Corso</strong>
                e invia ai futuri aspiranti un'email in cui li informi dell'attivazione del corso. Fino a che
                non effettuerai questa operazione nessuno si potrà iscrivere al corso e il corso non sarà
                visibile ai potenziali aspiranti.</p>
            </div> 
        <?php } ?>
        <?php if (isset($_GET['err'])) { ?>
            <div class="alert alert-block alert-error">
                <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
                <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
            </div> 
        <?php } ?>
        <?php if (isset($_GET['verberr'])) { ?>
            <div class="alert alert-block alert-error">
                <h4><i class="icon-warning-sign"></i> <strong>Problemi sulla compilazione del verbale</strong>.</h4>
                <p>Ci sono stai dei problemi sulla compilazione del verbale. Per favore riprova.</p>
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
        <?php if (isset($_GET['cancellatoAdmin'])) { ?>
            <div class="alert alert-block alert-success">
                <h4><i class="icon-ok"></i> <strong>Iscrizione cancellata</strong>.</h4>
                <p>Ricorda che la persona rimane comunque un socio ordinario del Comitato.</p>
            </div> 
        <?php } ?>
        <?php if (isset($_GET['ammesso'])) { ?>
            <div class="alert alert-block alert-success">
                <h4><i class="icon-ok"></i> <strong>Operazione andata a buon fine</strong>.</h4>
                <p>Hai ammesso un aspirante Volontario al Corso, ricorda che ora è un Socio
                Ordinario della Croce Rossa Italiana ed è necessario registrare il pagamento
                della quota.</p>
            </div> 
        <?php } ?>
        <?php if (isset($_GET['verbok'])) { ?>
            <div class="alert alert-block alert-success">
                <h4><i class="icon-ok"></i> <strong>Verbale compilato correttamente</strong>.</h4>
                <p>Le informazioni sull'esito dell'esame sono state correttamente inserite.</p>
            </div> 
        <?php } ?>
        <?php if (isset($_GET['cancellato'])) { ?>
            <div class="alert alert-block alert-success">
                <h4><i class="icon-ok"></i> <strong>Operazione andata a buon fine</strong>.</h4>
                <p>La preiscrizione al corso è stata cancellata con successo.</p>
            </div> 
        <?php } ?>
        <?php if (!$corso->accettaIscrizioni() && $puoPartecipare) { ?>
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
                <?php if ($me) {?> Codice corso: <?php echo $corso->progressivo(); } ?>
            </div>
        </div>
        <hr />

        <div class="row-fluid allinea-centro">
            <div class="span2">
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
                    <i class="icon-calendar"></i>
                    Data esame
                </span><br />
                <span class="text-info">
                    <strong><?php echo $corso->fine()->inTesto(false); ?></strong>
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
            <div class="span2">
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
        <?php if($corso->modificabileDa($me) && $corso->finito() && !$corso->concluso()) { ?>

            <?php if ( $part ) { ?>
                <div class="row-fluid">
                    <a href="?p=formazione.corsibase.finalizza&id=<?= $corso->id ?>" class="btn btn-block btn-success btn-large">
                        <i class="icon-flag-checkered"></i> Genera verbale e chiudi corso
                    </a>
                </div>
            <?php } else { ?>
                <div class="row-fluid alert-block alert">
                    <h4><i class="icon-info-sign"></i> Questo corso non &egrave; finalizzabile</h4>
                    <p>Nonostante il corso sia concluso, nessun iscritto &egrave; stato confermato, quindi non &egrave; possibile generarne il verbale.</p>
                </div>

            <?php } ?>
        <hr />
        <?php } ?>

        <?php if($corso->iscritto($me)) { ?>
        <div class="row-fluid">
            <div class="span12">
                <div class="alert alert-info">
                    Per partecipare effettivamente ad un Corso per Volontari della Croce Rossa devi diventare un <strong>Socio Ordinario</strong>.
                    Durante la presentazione del corso ti verranno fornite tutte le informazioni utili al riguardo. Per renderti
                    più facili le cose puoi trovare qui di seguito alcuni documenti molto importati. Ti verrà richiesto
                    di <strong>leggere e sottoscrivere</strong> questi documenti quando compilerai il modulo di iscrizione:
                    <ul>
                        <li><a href="docs/regolamento_volontari.pdf">
                         Regolamento dei Volontari della Croce Rossa</a></li>
                        <li><a href="docs/codice_condotta.pdf">
                         Codice di Condotta del personale della Croce Rossa</a></li>
                    </ul>
                    Qualora qualcosa non ti fosse chiaro non esitare a contattare il direttore del corso per maggiori informazioni.
                </div>
            </div>
        </div>
        <?php } ?>

        <?php if($puoPartecipare && !$iscritto) { ?>
        <div class="row-fluid">
            <?php if ($corso->accettaIscrizioni() && !$corso->iscritto($me)) { ?>
                                 <div clas="span12">
                <a href="?p=formazione.corsibase.iscrizione.ok&id=<?php echo $corso->id ; ?>" class="btn btn-large btn-block btn-success">Preiscriviti al corso</a>
            </div>
            <?php } elseif($corso->iscritto($me)) { ?>
             <p class="alert alert-info">
                      <i class="icon-info-sign"></i>
                      Per garantire la qualità dei corsi il numero massimo di partecipanti è di 30 persone. Il direttore di corso selezionerà gli iscritti fino al riempimento dell'aula.
                      </p>
            <div class="span6">
                <button class="btn btn-large btn-block btn-primary disabled">Preiscrizione effettuata</button>
            </div>
                <?php if($corso->futuro()) { ?>
                <div class="span6">
                    <a href="?p=formazione.corsibase.iscrizione.cancella.ok&id=<?php echo $corso->id ; ?>" class="btn btn-large btn-block btn-danger">Cancella Preiscrizione</a>
                </div>
                <?php } ?>
            <?php } ?>
        <div>
        <?php } elseif($iscritto) { ?>
        <div class="row-fluid">
            <div class="hero-unit" >
                <h1><i class="icon-flag"></i> Complimenti, sei iscritto a questo corso! </h1>
                <p>Ora non ti resta che presentarti presso il luogo indicato per lo svolgimento
                delle lezioni. Se hai bisogno di maggiori informazioni contatta il direttore del corso.</p>
            </div>
        </div>
        <?php } ?>

        <div class="row-fluid">
            <div class="span7" style="max-height: 500px; padding-right: 10px; overflow-y: auto;">
                <h3>
                    <i class="icon-info-sign"></i>
                    Ulteriori informazioni
                </h3>
                <?php echo nl2br($corso->descrizione); ?>
            </div>
            <div class="span5">
                <div class="span6">
                    <h3>
                        <i class="icon-calendar"></i>
                        Lezioni
                    </h3>
                </div>
                <div class="span6 allinea-destra">
                    <?php if ( $corso->modificabileDa($me) ){ ?>
                        <div class="btn-group">
                            <a class="btn btn-small" href="?p=formazione.corsibase.foglifirma&id=<?= $corso->id; ?>" title="Fogli firma">
                                <i class="icon-download"></i> Scarica fogli firma
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <table class="table table-condensed table-striped">
                    <thead>
                        <th>Nome</th>
                        <th>Data</th>
                        <th>Inizio</th>
                        <th>Fine</th>
                    </thead>
                    <tbody>
                    <?php
                    $lezioni = $corso->lezioni();
                    foreach ( $lezioni as $lezione ) { ?>
                        <tr class="<?= $lezione->passata() ? ( $lezione->presente($me) ? 'success' : 'error' ) : 'info'; ?>">
                            <td><?= $lezione->nome; ?></td>
                            <td><?= $lezione->inizio()->inTesto(false); ?></td>
                            <td><?= $lezione->inizio()->format('H:i'); ?></td>
                            <td><?= $lezione->fine()->format('H:i'); ?></td>
                        </tr>
                    <?php }
                    if (!$lezioni) { ?>
                    <tr class="warning">
                        <td colspan="4">
                            <i class="icon-warning-sign"></i>
                            Informazioni sulle lezioni non ancora disponibili.
                            Controlla pi&ugrave; tardi.
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <hr />
        <?php if ( $anonimo ) { ?>

            <div class="row-fluid">
                <div class="span12">
                    <center><h2>Vuoi entrare in Croce Rossa?</h2></center>
                    <div class="well">
                        <a href="?p=riconoscimento&tipo=aspirante" class="btn btn-large btn-primary btn-block">
                            <i class="icon-hand-right"></i>
                            Iscriviti al corso base
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ( !$corso->concluso() && $corso->modificabileDa($me) ) { ?>

        <!-- ISCRITTI -->

        <div class="row-fluid">
            <div class="span6">
                <h3><i class="icon-group"></i> Elenco degli iscritti</h3>
            </div>
            <div class="span6 allinea-destra">
                <div class="btn-group">                    
                    <a class="btn btn-small btn-success" href="?p=formazione.corsibase.email.nuova&iscrizioni&id=<?= $corso->id; ?>" title="Email">
                        <i class="icon-envelope"></i> Invia email a tutti gli iscritti
                    </a>
                    <a class="btn btn-small" href="?p=formazione.corsibase.excel&iscrizioni&id=<?= $corso->id; ?>" title="Excel">
                        <i class="icon-download"></i> Scarica come foglio excel
                    </a>
                </div>
            </div>
        </div>

        <div class="row-fluid">
            <table class="table table-striped table-bordered" id="tabellaUtenti">
                <thead>
                    <th>Foto</th>
                    <th>Nominativo</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Stato</th>
                    <th>Azione</th>
                </thead>
                <?php 

                foreach ( $part as $p ) { 
                    $iscritto = $p->utente(); ?>
                    <tr>
                        <td><img width="50" height="50" src="<?php echo $iscritto->avatar()->img(10); ?>" class="img-polaroid" /></td>
                        <td><?php echo $iscritto->nomeCompleto(); ?></td>
                        <td>
                            <span data-nascondi="" data-icona="icon-phone"><?php echo $iscritto->cellulare(); ?></span>
                        </td>
                        <td>
                            <span data-nascondi="" data-icona="icon-envelope"><?php echo $iscritto->email(); ?></span>
                        </td>
                        <td>
                            <?= $conf['partecipazioneBase'][$p->stato]; ?>
                        </td>
                        <td width="15%">
                            <div class="btn-group btn-group-vertical">
                                <a href="<?= "?p=profilo.controllo&id={$iscritto->id}" ?>" class="btn" target="_new" title="Dettagli">
                                    <i class="icon-eye-open"></i> Dettagli
                                </a>
                                <a href="<?= "?p=formazione.corsibase.utente.assenze&corso={$corso}&id={$iscritto->id}" ?>" class="btn" target="_new" title="Dettagli">
                                    <i class="icon-calendar"></i> Assenze
                                </a>
                            </div>
                            <?php if ($me && $me->admin()) { ?>
                                <form action="?p=formazione.corsibase.disiscrivi.ok" method="POST" >
                                    <input type="hidden" name="iscritto" value="<?= $p ?>" class="btn">
                                    <button type="submit" class="btn btn-danger btn-small" title="delete">
                                        <i class="icon-trash"></i>
                                    </button>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <!-- PREISCRIZIONI -->
        
        <div class="row-fluid">
            <div class="span6">
                <h3><i class="icon-group"></i> Elenco delle preiscrizioni</h3>
            </div>
            <div class="span6 allinea-destra">
                <div class="btn-group">
                    <a class="btn btn-small btn-success" href="?p=formazione.corsibase.email.nuova&preiscrizioni&id=<?= $corso->id; ?>" title="Email">
                        <i class="icon-envelope"></i> Invia email a tutti i preiscritti
                    </a>
                    <a class="btn btn-small" href="?p=formazione.corsibase.excel&preiscrizioni&id=<?= $corso->id; ?>" title="Excel">
                        <i class="icon-download"></i> Scarica come foglio excel
                    </a>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <?php if(!$corso->iniziato()) { ?>
                    <div class="alert alert-info">
                    <strong><i class="icon-warning-sign"></i> Non puoi ancora accettare le preiscrizioni.</strong>
                    Solo dopo la data di inizio del corso ti sarà possibile accettare le preiscrizioni al corso.
                    Questa scelta è dovuta al fatto che <strong>accettare una periscrizione</strong> significa iscrivere l'aspirante
                    Volontario nel ruolo di <strong>Socio Ordinario del Comitato</strong>. Questo lo potrai fare solamente quando
                    la persona si sarà presentata al corso e ti avrà fornito la modulistica che serve. Puoi in
                    ogni caso iniziare a prendere contatti con l'aspirante Volontario.
                    </div>
                <?php } ?>
            </div>
        </div>


        <div class="row-fluid">
            <table class="table table-striped table-bordered" id="tabellaUtenti">
                <thead>
                    <th>Foto</th>
                    <th>Nominativo</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Stato</th>
                    <th>Azione</th>
                </thead>
                <?php 
                $part = $corso->partecipazioni(ISCR_RICHIESTA);

                foreach ( $part as $p ) { 
                    $iscritto = $p->utente(); ?>
                    <tr>
                        <td><img width="50" height="50" src="<?php echo $iscritto->avatar()->img(10); ?>" class="img-polaroid" /></td>
                        <td><?php echo $iscritto->nomeCompleto(); ?></td>
                        <td>
                            <span data-nascondi="" data-icona="icon-phone"><?php echo $iscritto->cellulare(); ?></span>
                        </td>
                        <td>
                            <span data-nascondi="" data-icona="icon-envelope"><?php echo $iscritto->email(); ?></span>
                        </td>
                        <td>
                            <?= $conf['partecipazioneBase'][$p->stato]; ?>
                        </td>
                        <td width="15%">
                            <?php if($corso->iniziato()) { ?>
                            <div class="btn-group btn-group-vertical">
                                <a href="<?= "?p=formazione.corsibase.assegna.comitato&id={$p->id}&asp={$iscritto->id}" ?>" class="btn btn-success">
                                    <i class="icon-ok"></i> Accetta
                                </a>
                                <a data-iscrizione="<?php echo $p->id; ?>" data-accetta="0" class="btn btn-danger">
                                    <i class="icon-remove"></i> Rifiuta
                                </a>
                            </div>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <?php } elseif($corso->concluso() && $corso->modificabileDa($me)) { ?>

        <!-- ELENCHI FINE CORSO -->
        
        <div class="row-fluid">
            <div class="span6">
                <h3><i class="icon-group"></i> Esiti corso</h3>
            </div>
            <div class="span6 allinea-destra">
                <div class="btn-group">
                    <a class="btn btn-small btn-success" href="?p=formazione.corsibase.valutazione&id=<?= $corso->id; ?>" title="Verbale">
                        <i class="icon-paste"></i> Attestati, Verbale e schede esame
                    </a>
                    <a class="btn btn-small" href="?p=formazione.corsibase.excel&concluso&id=<?= $corso->id; ?>" title="Excel">
                        <i class="icon-download"></i> Scarica come foglio excel
                    </a>
                </div>
            </div>
        </div>

        <div class="row-fluid">
            <table class="table table-striped table-bordered" id="tabellaUtenti">
                <thead>
                    <th>Foto</th>
                    <th>Nominativo</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Stato</th>
                    <th>Azione</th>
                </thead>
                <?php 
                $part = $corso->partecipazioni();

                foreach ( $part as $p ) { 
                    if(!$p->haConclusoCorso()) { continue; }
                    $iscritto = $p->utente(); 

                    ?>
                    <tr>
                        <td><img width="50" height="50" src="<?php echo $iscritto->avatar()->img(10); ?>" class="img-polaroid" /></td>
                        <td><?php echo $iscritto->nomeCompleto(); ?></td>
                        <td>
                            <span data-nascondi="" data-icona="icon-phone"><?php echo $iscritto->cellulare(); ?></span>
                        </td>
                        <td>
                            <span data-nascondi="" data-icona="icon-envelope"><?php echo $iscritto->email(); ?></span>
                        </td>
                        <td>
                            <?= $conf['partecipazioneBase'][$p->stato]; ?>
                        </td>
                        <td width="15%">
                            <div class="btn-group-vertical">
                                <a href="<?= "?p=profilo.controllo&id={$iscritto->id}" ?>" class="btn btn-small" target="_new" title="Dettagli">
                                    <i class="icon-eye-open"></i> Dettagli
                                </a>
                                <a href="<?= "?p=formazione.corsibase.valutazione&id={$iscritto->id}&corso={$corso->id}&single" ?>" class="btn bn-small btn-info" target="_new" title="Dettagli">
                                    <i class="icon-file-alt"></i> Scheda
                                </a>
                                <?php if ( $p->stato == ISCR_SUPERATO ) { ?>
                                    <a href="<?= "?p=formazione.corsibase.attestato&id={$iscritto->id}&corso={$corso->id}" ?>" class="btn bn-small btn-primary" target="_new" title="Dettagli">
                                        <i class="icon-certificate"></i> Attestato
                                    </a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <?php } ?>
    </div>
</div>

