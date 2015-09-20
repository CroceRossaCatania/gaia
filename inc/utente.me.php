<?php

/*
* ©2013 Croce Rossa Italiana
*/

paginaPrivata(false);

$consenso = $me->consenso();

if ( $me->stato == ASPIRANTE && $consenso )
    redirect('aspirante.home');

/* Inizio sezione modali */


if ( !$consenso ){ ?>
<div class="modal fade automodal">
    <div class="modal-header">
        <h3 class="text-success"><i class="icon-cog"></i> Aggiornamento condizioni d'uso di Gaia!</h3>
    </div>
    <div class="modal-body">
        <p>Ciao <strong><?php echo $me->nome; ?></strong>, Gaia ha aggiornato le sue condizioni d'uso.</p>
        <p>È importante per noi che tu sia informato riguardo le finalità di questo portale e riguardo
            a come vengono trattati i tuoi dajuti. Per fare ciò hai due possibilità: </p>
        <ul>
            <li>Leggi la pagina delle <a href="?p=public.privacy" target="_new"> <i>condizioni d'uso</i></a> ; </li>
            <li>Apri una nuova finestra del browser. Digita gaia.cri.it, clicca <i>informazioni</i> in fondo alla pagina e poi <i>condizioni d'uso</i>.</li>
        </ul>
        <p>Ti raccomandiamo di leggere con attenzione il documento perché contiene importanti 
            informazioni su come i tuoi dati sono gestiti.</p>
        <p>Se hai letto premi il pulsante "Ho letto!". Verrai indirizzato ad una pagina
            in cui potrai dare il consenso e gestire le informazioni che ti riguardano.</p>
        <p>Se non sei d'accordo premi il pulsante "Logout": non ti sarà possibile utilizzare i servizi offerti dal portale fino
            a che non accetterai le condizioni d'uso. </p>
        <p>Le condizioni d'uso resteranno valide fino all'entrata in vigore della versione aggiornata. Quando ciò
            accradrà verrai subito informato.</p>
        <p>Grazie per la fiducia, <br />
        Lo staff di Gaia</p>
    </div>
    <div class="modal-footer">
        <a href="?p=logout" class="btn">
            <i class="icon-remove"></i>
            Logout
        </a>
        <a href="?p=utente.privacy&first" class="btn btn-success">
            <i class="icon-ok"></i>
            Ho letto!
        </a>
    </div>
</div>
<?php } 

if (isset($_GET['rimandaPrivatizzazione'])) {
    $sessione->rimandaPrivatizzazione = true;
}

if ($consenso && !$me->email ) { redirect('nuovaAnagraficaContatti'); }
if ($consenso && !$me->password && $sessione->tipoRegistrazione = VOLONTARIO ) { redirect('nuovaAnagraficaAccesso'); }

if ($consenso) {
    $d = $me->delegazioneAttuale();
    if ($d && $d->applicazione == APP_PRESIDENTE) {
        $p = $d->comitato()->unPresidente();
        if ( $p && $p == $me->id && !$d->comitato()->haPosizione() && !$d->comitato()->principale ) {
            redirect('presidente.wizard&forzato&oid=' . $d->comitato()->oid());
        }
    }
}

if (!$sessione->rimandaPrivatizzazione && $consenso) {
    foreach($me->comitatiPresidenzianti() as $comitato) {
        $p = $comitato->unPresidente();
        if ( $p && $p == $me->id && !$comitato->cf()) { ?>
        <div class="modal fade automodal">
            <div class="modal-header">
                <h3 class="text-success"><i class="icon-cog"></i> Privatizzazione della CRI!</h3>
            </div>
            <div class="modal-body">
                <p>Ciao <strong><?php echo $me->nome; ?></strong>, con il nuovo anno anche Gaia
                    si adegua alla privatizzazione della CRI.</p>
                <p>Come prima passo ti chiediamo di inserire, se sono già in tuo possesso, le informazioni
                    su nuovo <strong>Codice Fiscale</strong> e nuova <strong>Partita IVA</strong> del comitato di cui sei il presidente.</p>
                <p>Dovrai completare questa procedura entro la fine del mese di Gennaio 2014, altrimenti
                    verrà bloccato l'utilizzo del portale a tutti gli appartenenti al comitato di cui sei Presidente.</p>
                <p>La procedura può essere completata in ogni momento dal pannello <strong>Presidente</strong>.</p>
                <p>Lo staff di Gaia</p>
            </div>
            <div class="modal-footer">
                <a href="?p=utente.me&rimandaPrivatizzazione" class="btn">
                    <i class="icon-remove"></i> Rimanda
                </a>
                <a href="?p=presidente.wizard&oid=<?php echo($comitato->oid()); ?>" class="btn btn-success">
                    <i class="icon-ok"></i> Inserisci i dati!
                </a>
            </div>
        </div>
    <?php }
    }
}
/*
// C'è il webinar!!!
if (!$sessione->rimandaPrivatizzazione && $consenso && $me->presidenziante() && !$me->admin) { ?>
    <div class="modal fade automodal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3><i class="icon-bullhorn"></i> La formazione online continua...</h3>
        </div>
        <div class="modal-body">
            <p>Hai dubbi su una determinata funzionalità di <i>GAIA</i>? Partecipa ai nostri webinar online!
                A breve tratteremo i seguenti argomenti:</p>
            <p>
            <ul>
                <li>martedì 4 novembre alle 21.00: <i>Gestione del corso base e dell'aspirante</i></li>
            </ul>
            </p>
            <p>Cliccando su <strong>Maggiori dettagli</strong> potri accedere alla pagina dedicata
            alla formazione e iscriverti all'incontro online.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Non ora</button>
            <a href="?p=public.formazione" class="btn btn-primary">
                <i class="icon-asterisk"></i> Maggiori dettagli
            </a>
        </div>
    </div>
<?php }
*/
/* Noi siamo cattivi >:) */
// redirect('curriculum');

$attenzione = false;

$rf = $me->attivitaReferenziateDaCompletare();
if ($consenso && $rf) {
    $attenzione = true;
    $attivita = $rf[0];
?>

    <!-- BLOCCO ATTIVITA DA COMPLETARE -->
    <div class="modal fade automodal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="text-error"><i class="icon-warning-sign"></i> Attività da completare</h3>
        </div>
        <div class="modal-body">
            <p><?php echo $me->nome; ?>, sei stato selezionato come referente per l'attività:</p>
            <hr />
            <p class="allinea-centro">
                <strong><?php echo $attivita->nome; ?></strong>
                <br />
                <?php echo $attivita->area()->nomeCompleto(); ?><br />
                <span class="muted">
                    <?php echo $attivita->comitato()->nomeCompleto(); ?>
                </span>
            </p>
            <hr />
            <h4>Completa i dettagli dell'attività</h4>
            <p><strong>Devi inserire le seguenti informazioni:</strong>
                <ul>
                  <li><i class="icon-time"></i> Giorni e turni;</li>
                  <li><i class="icon-globe"></i> Locazione dell'attività;</li>
                  <li><i class="icon-pencil"></i> Informazioni per i volontari;</li>
                  <li><i class="icon-group"></i> A chi è aperta l'attività;</li>
              </ul><br />
            </p>
            <p class="text-error">
                <i class="icon-info-sign"></i> Non appena verranno inseriti tutti
                i dettagli riguardanti l'attività, questa comparirà sul calendario dei volontari.
                Potranno così richiedere di partecipare attraverso Gaia.
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Non ora</button>
            <a href="?p=attivita.modifica&id=<?php echo $attivita->id; ?>" class="btn btn-primary">
                <i class="icon-asterisk"></i> Vai all'attività
            </a>
        </div>
    </div>

<?php } 

/* Blocco per direttori di corso */

$cb = $me->corsiBaseDirettiDaCompletare();
if ($consenso && $cb && !$rf) {
    $attenzione = true;
    $corsoBase = $cb[0];
    ?>

    <div class="modal fade automodal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="text-error"><i class="icon-warning-sign"></i> Corso Base da Completare</h3>
        </div>
        <div class="modal-body">
            <p><?php echo $me->nome; ?>, sei stato selezionato come direttore per un corso base:</p>
            <hr />
            <p class="allinea-centro">
                <strong><?php echo $corsoBase->nome(); ?></strong>
                <br />
                <span class="muted">
                    Organizzatore: <?php echo $corsoBase->organizzatore()->nomeCompleto(); ?>
                </span>
            </p>
            <hr />
            <h4>Completa i dettagli del corso</h4>
            <p><strong>Devi inserire le seguenti informazioni:</strong>
                <ul>
                  <li><i class="icon-time"></i> Lezioni;</li>
                  <li><i class="icon-globe"></i> Luogo di svolgimento del corso;</li>
                  <li><i class="icon-pencil"></i> Informazioni per gli aspiranti volontari.</li>
              </ul><br />
            </p>
            <p class="text-error">
                <i class="icon-info-sign"></i> Non appena verranno inseriti tutti
                i dettagli riguardanti il corso verranno informati tutti gli aspiranti volontari
                presenti in zona.
                Potranno così richiedere di partecipare attraverso Gaia.
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Non ora</button>
            <a href="?p=formazione.corsibase.modifica&id=<?php echo $corsoBase->id; ?>" class="btn btn-primary">
                <i class="icon-asterisk"></i> Vai al corso
            </a>
        </div>
    </div>  

<?php } 

/* Blocco per presidenti con corsi senza direttore */


$cs = $me->corsiBaseSenzaDirettore();
if ($consenso && $cs && !$cb && !$rf) {
    $attenzione = true;
    $corsoBase = $cs[0];
    ?>

    <div class="modal fade automodal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="text-error"><i class="icon-warning-sign"></i> Corso Base da Completare</h3>
        </div>
        <div class="modal-body">
            <p>Hai attivato un corso base ma non ne hai ancora selezionato il direttore:</p>
            <hr />
            <p class="allinea-centro">
                <strong><?php echo $corsoBase->nome(); ?></strong>
                <br />
                <span class="muted">
                    Organizzatore: <?php echo $corsoBase->organizzatore()->nomeCompleto(); ?>
                </span>
            </p>
            <hr />
            <h4>Completa i dettagli del corso</h4>

            <p class="text-error">
                <i class="icon-info-sign"></i> Non appena verranno avrai nominato
                il direttore del corso questa persona potrà inserire tutte le informazioni
                necessarie e rendere visibile in corso ai futuri aspiranti.
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Non ora</button>
            <a href="?p=formazione.corsibase.direttore&id=<?php echo $corsoBase->id; ?>" class="btn btn-primary">
                <i class="icon-asterisk"></i> Vai al corso
            </a>
        </div>
    </div>  

<?php } 

/* Blocco blocco appartenenza non valida */

if ( $consenso && !$me->appartenenzaValida() && !$me->dipendenteComitato ) { ?>
    <div class="modal fade automodal">
        <div class="modal-header">
            <h4 class="text-error"><i class="icon-warning-sign"></i> Seleziona il tuo Comitato</h4>
        </div>
        <div class="modal-body">
            <p>Ciao <?= $me->nome; ?>, ci risulta che non hai selezionato alcun Comitato di appartenenza.
                Fino a che non avrai scelto il comitato di cui fai parte e non sarai stato approvato dal tuo presidente non potrai
                utilizzare le funzionalità del portale Gaia.</p>
            <p>Se pensi che ci sia un errore invia una mail a <i class="icon-envelope"></i><a href="mailto:supporto@gaia.cri.it"> supporto@gaia.cri.it</a></p>
            <hr />
            <p class="allinea-centro">
                <a href="?p=utente.comitato" class="btn btn-large"><i class="icon-sitemap"></i> 
                    Seleziona il tuo comitato
                </a>
                <a href="?p=logout" class="btn btn-large"><i class="icon-remove"></i> Esci</a>
            </p>
        </div>
    </div>
<?php }

/* blocco sondaggio per barcode */

if(false && $consenso && !$sessione->barcode) { ?>

    <div class="modal fade automodal">
        <div class="modal-header">
            <h3 class="text-error"><i class="icon-warning-sign"></i> Gaia ha bisogno di te!</h3>
        </div>
        <div class="modal-body">
            <p>Ciao <?php echo $me->nome; ?>, abbiamo bisogno del tuo aiuto per migliorare la qualità del servizio
                fornito da Gaia.</p>
            <p>Stiamo effettuando uno studio sull'uso dei dispositivi mobili (smartphone e tablet) da parte 
                dei Volontari che usano Gaia, con particolare riferimento all'uso della fotocamera 
                per la scansione dei codici a barre.</p>
            <p>Se hai una stampante ed uno smartphone o tablet, aiutaci nel nostro esperimento, 
                completando il questionario!</p>

            <p><i>Grazie della collaborazione</i><br />
                <i>Lo staff di Gaia</i></p>

        </div>
        <div class="modal-footer">
            <a class="btn btn-danger" href="?p=utente.barcode&no">
                Non sono interessato
            </a>
            <a class="btn btn-success" href="?p=utente.barcode&ok">
                Ok, ci sto!
            </a>
        </div>
    </div>

<?php } ?>

<!-- FINE SEZIONE MODALI -->

<!-- BLOCCO PAGINA -->

<div class="row-fluid">

    <div class="span3"><?php menuVolontario(); ?></div>

    <!-- BLOCCO NON MENU -->
    <div class="span9">

        <div class="row-fluid">
            <div class="span8">
                <h2><span class="muted">Ciao </span>
                    <?= $me->nome; ?>
                </h2>
                <?php if (isset($_GET['suppok'])) { $attenzione = true; ?>
                <div class="alert alert-success">
                    <h4><i class="icon-ok-sign"></i> Richiesta supporto inviata</h4>
                    <p>La tua richiesta di supporto è stata inviata con successo, a breve verrai contattato da un membro dello staff.</p>        
                </div> 
                <?php } if (isset($_GET['ok'])) { $attenzione = true;  ?>
                <div class="alert alert-success">
                    <i class="icon-ok"></i> <strong>Mail inviata</strong>.
                    La tua mail è stata inviata con successo.
                </div> 
                <?php } if (isset($_GET['mass'])) { $attenzione = true;  ?>
                <div class="alert alert-success">
                    <i class="icon-ok"></i> <strong>Mail inviate</strong>.
                    Mail di massa inviata con successo.
                </div> 
                <?php } if (isset($_GET['err'])) { $attenzione = true;  ?>
                <div class="alert alert-block alert-error">
                    <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
                    <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
                </div> 
                <?php } if (isset($_GET['nodest'])) { $attenzione = true;  ?>
                <div class="alert alert-block alert-error">
                    <h4><i class="icon-warning-sign"></i> <strong>Nessun destinatario valido</strong>.</h4>
                    <p>L'email che stavi inviando non può essere spedita.</p>
                </div> 
                <?php } 
                ?>
    

                <?php
                $d = $me->delegazioneAttuale();
                if ($d && $d->applicazione == APP_PRESIDENTE) {
                    $c = $d->comitato(); $num_aspiranti = Aspirante::numChePassanoPer($c);
                    if ( $num_aspiranti > 20 && !$c->corsiBase(false, true) ) { ?>
                <div class="alert alert-block alert-warning">
                    <div class="row-fluid">
                        <h4><i class="icon-warning-sign"></i> Un numero significante di persone ha registrato il suo interesse ad entrare in CRI nella zona del Comitato!</h4>
                        <p>Ben <strong><?= $num_aspiranti; ?></strong> persone hanno registrato il loro interesse ed aspettano l'attivazione di un Corso Base in una zona che comprende il
                         <?= $c->nomeCompleto(); ?>.</p>
                        <p>Potresti voler attivare un Corso Base tramite Gaia. Cos&igrave; facendo, Gaia invier&agrave; a tutti loro un avviso immediato di attivazione del nuovo Corso, assieme 
                         a dei promemoria settimanali, contenenti i Corsi Base attivi nelle rispettive zone di interesse. Gli aspiranti volontari potranno quindi pre-iscriversi online.</p>
                        <p class="grassetto"><i class="icon-info-sign"></i> Puoi tenere sotto controllo la domanda formativa per ogni sede ed avviare corsi dal 
                        <a href="?p=presidente.dash">Pannello Presidente</a>, selezionando una sede, quindi "Corsi Base".</p>

                    </div>
                </div>


                <?php } } ?>


                <div class="alert alert-block alert-success">
                    <div class="row-fluid">
                        <h4><strong><i class="icon-beaker"></i> Aggiornamento titoli di studio (Diplomi e Lauree)</strong></h4>
                        <p>Ti invitiamo ad aggiornare il tuo curriculum con i nuovi titoli di studio sostituendo anche i precedenti.</p>
                        <p>Maggiori informazioni sono disponibili nell’apposita sezione.</p>
                        <p>Ti ricordiamo che i titoli contrassegnati come <strong>"vecchio"</strong> saranno rimossi.</strong></p>
                        <p><a href="?p=utente.titoli&t=3" class="btn btn-large"><i class="icon-refresh"></i> Aggiorna subito!</a></p>
                    </div>
                </div>
                
                <div class="alert alert-block alert-info">
                    <div class="row-fluid">
                        <div class="span9">
                            <h4>GAIA è alla ricerca di personale</h4>
                                <p>Siamo alla ricerca di <strong>Sviluppatory Python & Technical Writer</strong>.</p>
                                Regalati un'esperienza di Volontariato tutta nuova. <a href="http://www.cri.it/flex/cm/pages/ServeBLOB.php/L/IT/IDPagina/21231/YY/2015/MM/6" target="_blank"><i class="icon-link"></i> Clicca qui.</a></p>
                        </div>
                        <div class="span3">
                            <a href="http://www.cri.it/flex/cm/pages/ServeBLOB.php/L/IT/IDPagina/24818" target="_blank"><img src="/img/pulsantehelp.png" /></a>
                        </div>
                    </div>
                </div>
              
                <!-- BLOCCO SENZA IMMAGINE
                <div class="alert alert-block alert-info">
                    <div class="row-fluid">
                        
                            <h4><strong>Formazione online sui tesserini!</strong></h4>
                            <p>Il giorno 19/12/2014 alle ore 15.30 ci sarà il <strong>primo</strong> appuntamento di formazione sull'utilizzo di questa nuova funzionalità!.</p> 
                             <p>L'evento è principalmente destinato agli uffici soci dei comitati. </a></p>
                             
                            <p><a href="https://attendee.gotowebinar.com/register/103686508739557377" class="btn btn-large"><i class="icon-ok"></i> Iscriviti subito!</a></p>

                      
                    </div>
                </div>-->
                <!-- Blocco aggiornamento titoli -->
                 
                <?php
                // fine blocco jump
                if (!$me->wizard) { $attenzione = true;  ?>
                <div class="alert alert-block alert-error">
                    <h4><i class="icon-warning-sign"></i> Completa il tuo profilo</h4>
                    <p>Inserisci titoli, patenti, certificazioni e competenze dalla sezione curriculum.</p>        
                    <p><a href="?p=utente.titoli&t=0" class="btn btn-large"><i class="icon-ok"></i> Clicca qui per iniziare</a></p>
                </div>
                <?php } elseif (!$me->ordinario()) { ?>
                <div class="alert alert-block alert-success">
                    <div class="row-fluid">
                        <span class="span7">
                            <h4><i class="icon-ok"></i> Grande, hai finito!</h4>
                            <p>Quando vorrai modificare qualcosa, clicca sul pulsante per ricominciare la procedura di Modifica curriculum.</p> 
                        </span>
                        <span class="span5">
                            <a href="?p=utente.titoli&t=0" class="btn btn-large">
                                <i class="icon-refresh"></i>
                                Ricominciamo
                            </a>
                        </span>
                    </div>
                </div>
                <?php } 

                foreach ( $me->appartenenzePendenti() as $app ) { $attenzione = true;  ?>
                <div class="alert alert-block">
                    <h4><i class="icon-time"></i> In attesa di conferma</h4>
                    <p>La tua appartenenza a <strong><?php echo $app->comitato()->nomeCompleto(); ?></strong> attende conferma.</p>
                    <p>Successivamente riceverai una email di notifica e potrai partecipare ai servizi del comitato.</p>

                </div>
                <?php } 

                $h=0;
                foreach ( $patenti =  TitoloPersonale::scadenzame($me)  as $patente ) { 
                    if($h!=1){  ?>
                        <div class="alert alert-error">
                            <h4><i class="icon-warning-sign"></i> Patente in scadenza</h4>
                            <p>La tua <strong>PATENTE CRI</strong> scadrà il <strong><?php echo date('d-m-Y', $patente->fine); ?></strong></p>
                        </div>
                        <?php $h=1;
                    }
                } 

                /* Utente in riserva */
                
                if($me->inRiserva()){
                    $r = Riserva::filtra([
                        ['volontario', $me->id],
                        ['stato', RISERVA_OK]
                        ]);
                    $r = $r[0];
                    ?>
                    <div class="alert alert-block">
                        <h4><i class="icon-pause"></i> In riserva</h4>
                        <p>Sei nel ruolo di riserva fino al  <strong><?php echo date('d/m/Y', $r->fine); ?></strong>.</p>
                    </div>
                <?php } 

                /* Utente con provvedimento */

                if($me->provvedimento()){ ?>
                    <div class="alert alert-block">
                        <h4><i class="icon-legal"></i> Provvedimento in corso</h4>
                        <p>Sei sottoposto ad un provvedimento disciplinare, ottieni maggiori informazioni consultando il tuo storico.</p>
                    </div>
                <?php } 

                /* Presto iscriviti ad un gruppo! */

                if ( $me->comitati() && $me->gruppiDisponibili() ) { 
                    if (!$me->mieiGruppi()){ ?>
                    <div class="alert alert-danger">
                        <div class="row-fluid">
                            <span class="span7">
                                <h4><i class="icon-group"></i> Non sei iscritto a nessun gruppo!</h4>
                                <p>Il tuo Comitato ha attivato i gruppi di lavoro, sei pregato di regolarizzare l'iscrizione ad un gruppo.</p>
                            </span>
                            <span class="span5">
                                <a href="?p=utente.gruppo" class="btn btn-large">
                                    <i class="icon-group"></i>
                                    Iscriviti ora!
                                </a>
                            </span>
                        </div>
                    </div>
                    <?php }
                } 

                if ($me->compleanno()){ ?>
                    <div class="alert alert-info">
                        <div class="row-fluid">
                            <span class="span12">
                                <h4><i class="icon-glass"></i> Auguri!</h4>
                                <p>Tantissimi auguri di un buon compleanno.</p>
                            </span>
                        </div>
                    </div>
                <?php }

                if(false) {?>
                <!-- Per ora mostra sempre... -->
                <div class="alert alert-block alert-info">
                    <h4><i class="icon-folder-open"></i> Hai già caricato i tuoi documenti?</h4>
                    <p>Ricordati di caricare i tuoi documenti dalla sezione <strong>Documenti</strong>.</p>
                </div>

                <?php } ?>
            </div>

            <!-- PANNELLO ULTIME EMAIL -->
            <div class="span4">
                <div class="row-fluid">
                    <h4><i class="icon-time"></i> Ultime comunicazioni</h4>
                    
                    <div
                        data-posta      ="true"
                        data-direzione  ="ingresso"
                        data-perPagina  ="5"
                        data-mini       ="true"
                    ></div>
                </div>
                <div class="row-fluid">
                    <a class="twitter-timeline" href="https://twitter.com/progettogaiacri/gaia-update" data-widget-id="441278779487305729">Tweets from https://twitter.com/progettogaiacri/gaia-update</a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                </div>
            </div>
        </div>
    </div>
</div>
