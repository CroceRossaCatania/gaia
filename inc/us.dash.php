<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);
$_n     +=  $_n_titoli = $me->numTitoliPending  ([APP_PRESIDENTE, APP_SOCI]);
$_n     +=  $_n_app    = $me->numAppPending     ([APP_PRESIDENTE, APP_SOCI]);
if(!$me->admin()) {
    $_n_trasf  = $me->numTrasfPending       ([APP_PRESIDENTE, APP_SOCI]);
    $_n_ris    = $me->numRisPending         ([APP_PRESIDENTE, APP_SOCI]);
    $_n_est    = $me->numEstPending         ([APP_PRESIDENTE, APP_SOCI]);
    $_n_foto   = $me->numFototesserePending ([APP_PRESIDENTE, APP_SOCI]);
}

?>

<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>
    <div class="span9">
        <div class="row-fluid">
            <?php if ( isset($_GET['trasfok']) ) { ?>
            <div class="alert alert-success">
                <i class="icon-ok"></i> <strong>Richiesta di trasferimento inoltrata</strong>.
                La richiesta di trasferimento è stata inoltrata con successo.
            </div>
            <?php } ?>
            <?php if ( isset($_GET['estok']) ) { ?>
                <div class="alert alert-success">
                    <i class="icon-ok"></i> <strong>Richiesta di estensione inoltrata</strong>.
                    La richiesta di estensione è stata inoltrata con successo.
                </div>
            <?php } ?>
            <?php if ( isset($_GET['risok']) ) { ?>
                <div class="alert alert-success">
                    <i class="icon-ok"></i> <strong>Richiesta di riserva inoltrata</strong>.
                    La richiesta di riserva è stata inoltrata con successo.
                </div>
            <?php } ?>
            <?php if ( isset($_GET['provok']) ) { ?>
                <div class="alert alert-success">
                    <i class="icon-ok"></i> <strong>Provvedimento registrato con successo</strong>.
                    Il provvedimento disciplinare è stato registrato con successo.
                </div>
            <?php } ?>
            <?php if ( isset($_GET['canc']) ) { ?>
                <div class="alert alert-success">
                    <i class="icon-ok"></i> <strong>Quota cancellata</strong>.
                    La quota è stata rimossa in maniera corretta.
                </div>
            <?php } ?>
            <?php if ( isset($_GET['annullata']) ) { ?>
                <div class="alert alert-success">
                    <i class="icon-ok"></i> <strong>Quota annullata</strong>.
                    La quota è stata annullata in maniera corretta. Rimarrà registrata nello storico quote dell'utente.
                </div>
            <?php } ?>            
            <?php if ( isset($_GET['riserrdate']) ) { ?>
                <div class="alert alert-error">
                    <i class="icon-warning-sign"></i> <strong>Richiesta di riserva non inserita</strong>.
                    Ricorda che la riserva può durare al massimo un anno e che non è possibile
                    inserire riserve che terminano nel passato.
                </div>
            <?php } ?>
            <?php if (isset($_GET['err'])) { ?>
                <div class="alert alert-block alert-error">
                    <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
                    <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
                </div> 
            <?php } ?>
            <?php if (isset($_GET['giaAnn'])) { ?>
                <div class="alert alert-block alert-error">
                    <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
                    <p>La quota che hai tentato di annullare risultava già annullata.</p>
                </div> 
            <?php } ?>   
            <?php if (isset($_GET['email'])) { ?>
                <div class="alert alert-block alert-success">
                    <h4><i class="icon-ok"></i> <strong>Email inviata con successo</strong>.</h4>
                    <p>L'email che hai inviato è stata inserita in coda di invio e al più presto sarà recapitata.</p>
                </div> 
            <?php } ?>    
            <?php if ( isset($_GET['date']) ) { ?>
                <div class="alert alert-error">
                    <i class="icon-warning-sign"></i> <strong>Le date specificate non sono corrette</strong>.
                    Una delle date inserite non è nel formato corretto ( gg/mm/aaaa ) riprova facendo attenzione
                </div>
            <?php } ?>     
            <div class="span12">
                <h3>Ufficio Soci</h3>
            </div>
            
            
        </div>
        
        <div class="alert alert-block alert-success">
            <h4><i class="icon-info-sign"></i> Gaia: Supporto Elezioni 2015</h4>
            <p>Uno degli obblighi derivante dalla indizione delle elezioni è la regolarizzazione degli elenchi dei soci. Dato l’estremo carico di traffico e richieste di assistenza, stiamo lavorando a delle misure particolari per supportare il vostro lavoro in questo periodo.</p>
            <p>&nbsp;</p>
            <div class="row-fluid">
                <div class="span6">
                    <h4><i class="icon-phone-sign"></i> SOS Elezioni 2016 - Numero di telefono</h4>
                    <p>Limitatamente a questioni riguardanti gli elenchi di elettorato, il caricamento massivo di volontari e l’attribuzione di soci ai comitati, abbiamo istituito un numero di assistenza che risponderà telefonicamente secondo gli orari riportati nella seguente tabella:</p>
                    
                    <table class="table table-bordered table-striped">
                        <thead>
                            <th>Giorno</th>
                            <th>Ora</th>
                        </thead>
                        <tbody>
                            <tr><td>12-16 gennaio 2016</td> <td>16.00&mdash;19.00</td></tr>
                            <tr><td>18-23 gennaio 2016</td> <td>16.00&mdash;19.30</td></tr>
                            <tr><td>25-28 gennaio 2016</td> <td>16.00&mdash;19.00</td></tr>
                        </tbody>
                    </table>
                    <p><strong>Nota</strong>: In caso il numero risulti irraggiungibile, questo potrebbe essere occupato. Attendere qualche minuto e riprovare. </p>
                    <p>&nbsp;</p>
                    <a href="javascript:
                            if(confirm('La tua domanda riguarda la gestione soci per le elezioni?')) {
                                alert('Chiama il 328 897 9123');
                            } else {
                                alert('Per favore contatta il supporto cliccando su Supporto in fondo alla pagina. Il numero di telefono riguarda solo problematiche legate ai soci per le elezioni.');
                            }" class="btn-primary btn-small btn-block">
                                Mostra il numero di telefono
                                <span class="badge badge-danger badge-warning">Nuovo</span>
                            </a>
                </div>
                <div class="span6">
                    <h4><i class="icon-warning-sign"></i> Problemi noti</h4>
                    <p>Siamo a conoscenza di alcuni problemi a riguardo degli elenchi di elettorato.</p>
                    <ul>
                        <li>Nel caso di alcuni soci che, nel passato, sono stati soggetto di dimissione, l’anzianità viene al momento calcolata senza tenere conto della dimissione;</li>
                        <li>L’elenco dell’elettorato passivo non segnala i soci giovani, come previsto dal nuovo regolamento elettorale;</li>
                        <li>Alcuni soci aventi diritto di comparire nell’elettorato attivo e passivo non appaiono nell’elenco generato da Gaia;</li>
                    </ul>
                    <p>&nbsp;</p>
                    <p><strong>Soluzione?</strong></p>
                    <p>Abbiamo lavorato alla soluzione di tutti e tre i problemi sopra elencati, come parte del progetto “Jorvik”. Prevediamo di rilasciare queste modifiche al pubblico prima del 19 gennaio 2016, in tempo per la pubblicazione degli elenchi.</p>
                    <p>Siamo spiacenti per il disagio che questo può causare - stiamo tutti lavorando duramente e cercando di massimizzare l’efficienza delle risorse a noi disponibili per ridurre i disagi in questo periodo pieno di lavoro.</p>
                    <p><strong>Affetto da uno di questi problemi?</strong></p>
                    <p>Ti preghiamo di <strong>attendere il rilascio dell’aggiornamento di Gaia</strong> e verificare la corretta risoluzione dei difetti nella generazione degli elenchi successivamente al 19 gennaio 2016. </p>
                    <p>Per favore, <strong><u>non aprire ticket di supporto</u></strong>, siamo già al lavoro per risolvere questi problemi.</p>
                    
                    
                </div>

                
            </div>
        </div>
        
        <div class="row-fluid">
            <div class="span3">
                
            </div>
            
            <div class="span6 allinea-centro">
                <img src="https://upload.wikimedia.org/wikipedia/it/thumb/4/4a/Emblema_CRI.svg/75px-Emblema_CRI.svg.png" />
            </div>

            <div class="span3">
                <table class="table table-striped table-condensed">
                    
                    <tr><td>Num. Volontari</td><td><?php echo $me->numVolontariDiCompetenza(); ?></td></tr>
                    <tr><td>Num. Soci Ordinari</td><td><?php echo $me->numOrdinariDiCompetenza(); ?></td></tr>
                    
                </table>
            </div>
        </div>
        <div class="row-fluid">
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#elenchi" data-toggle="tab">Elenchi</a></li>
                    <li><a href="#volontari" data-toggle="tab">Volontari</a></li>
                    <li><a href="#quote" data-toggle="tab">Amministrazione</a></li>
                    <?php if ($me->delegazioneAttuale()->applicazione != APP_SOCI) { ?>
                        <li><a href="#referenti" data-toggle="tab">Referenti</a></li>
                    <?php } ?>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="elenchi">
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="alert alert-block alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <i class="icon-user"></i> <strong>Alcune indicazioni utili</strong><br />
                                    Se provi ad inserire un volontario o un socio ordinario ma non riesci a completare l'operazione 
                                    può essere che la persona abbia provato a registrarsi autonomamente e che l'operazione non sia andata a
                                    buon fine. <a href="?p=utente.supporto"><i class="icon-envelope"></i> Contatta il supporto</a> e spiega il 
                                    problema così che sia possibile risolvere la situazione.
                                    <br />
                                    <a href="?p=us.import" class="btn btn-block btn-info">
                                        <i class="icon-list"></i>
                                        Voglio importare i miei soci in massa
                                    </a>
                                </div>
                                <hr />
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="btn-group btn-group-vertical span12">
                                            <a href="?p=presidente.utenti" class="btn btn-primary btn-block">
                                                <i class="icon-list"></i>
                                                Elenchi volontari
                                            </a>
                                            <a href="?p=us.elettorato" class="btn btn-danger btn-block">
                                                <i class="icon-list"></i>
                                                Elenchi elettorato
                                            </a>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="row-fluid">
                                            <div class="btn-group btn-group-vertical span12">
                                                <a href="?p=presidente.titoli.ricerca" class="btn btn-block">
                                                    <i class="icon-search"></i>
                                                    Ricerca per titoli
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="volontari">
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="row-fluid">
                                    <div class="btn-group btn-group-vertical span12">
                                        <a href="?p=us.utente.nuovo" class="btn btn-block btn-success">
                                            <i class="icon-plus"></i>
                                            Aggiungi volontario
                                        </a>
                                        <a href="?p=us.utente.trasferisci" class="btn btn-block">
                                            <i class="icon-arrow-right"></i>
                                            Trasferisci volontario
                                        </a>
                                        <a href="?p=us.utente.estendi" class="btn btn-block btn-info">
                                            <i class="icon-random"></i>
                                            Estendi volontario
                                        </a>
                                        <a href="?p=us.utente.riserva" class="btn btn-block btn-warning">
                                            <i class="icon-pause"></i>
                                            Metti in riserva volontario
                                        </a>
                                        <a href="?p=us.provvedimento.nuovo" class="btn btn-block btn-primary">
                                            <i class="icon-legal"></i>
                                            Registra provvedimento
                                        </a>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row-fluid">
                                    <div class="btn-group btn-group-vertical span12">
                                        <a href="?p=us.ordinario.nuovo" class="btn btn-block btn-success">
                                            <i class="icon-plus"></i>
                                            Aggiungi Socio Ordinario
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="row-fluid">
                                    <div class="btn-group btn-group-vertical span12">
                                        <a href="?p=presidente.appartenenzepending" class="btn btn-block">
                                            <i class="icon-group"></i>
                                            Appartenenze in attesa <span class="badge badge-important"><?= $_n_app; ?></span>
                                        </a>
                                        <a href="?p=presidente.titoli" class="btn btn-block">
                                            <i class="icon-star"></i>
                                            Titoli in attesa <span class="badge badge-important"><?= $_n_titoli; ?></span>
                                        </a>
                                        <a href="?p=presidente.trasferimento" class="btn btn-block">
                                            <i class="icon-arrow-right"></i>
                                            Trasferimenti in attesa <span class="badge badge-important"><?php if($_n_trasf) { echo($_n_trasf); } ?></span>
                                        </a>
                                        <a href="?p=presidente.estensione" class="btn btn-block">
                                            <i class="icon-random"></i>
                                            Estensioni in attesa <span class="badge badge-important"><?php if($_n_est) { echo($_n_est); } ?></span>
                                        </a>
                                        <a href="?p=presidente.riserva" class="btn btn-block">
                                            <i class="icon-pause"></i>
                                            Riserve in attesa <span class="badge badge-important"><?php if($_n_ris) { echo($_n_ris); } ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="quote">
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="row-fluid">
                                    <div class="btn-group btn-group-vertical span12">
                                        <a href="?p=us.quoteNo" class="btn btn-block">
                                            <i class="icon-certificate"></i>
                                            Gestione quote associative
                                        </a>
                                        <a href="?p=us.quote.ricerca" class="btn btn-block">
                                            <i class="icon-search"></i>
                                            Ricerca quota associativa
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="row-fluid">
                                    <div class="btn-group btn-group-vertical span12">
                                        <?php if ($me->admin() || ($me->delegazioneAttuale()->estensione > EST_PROVINCIALE)) { ?>
                                            <a href="?p=us.tesserini" class="btn btn-block">
                                                <i class="icon-credit-card"></i>
                                                Tesserini
                                            </a>
                                        <?php } ?>
                                        <a href="?p=us.tesserini.noRiconsegnati" class="btn btn-block btn-warning">
                                            <i class="icon-credit-card"></i>
                                            Tesserini non riconsegnati
                                        </a>
                                        <a href="?p=presidente.fototessere.pending" class="btn btn-block">
                                            <i class="icon-instagram"></i>
                                            Fototessere in attesa <span class="badge badge-important"><?= $_n_foto; ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                    if ($me->delegazioneAttuale()->applicazione != APP_SOCI) { ?>
                    <div class="tab-pane" id="referenti">
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="btn-group btn-group-vertical span12">
                                    <?php foreach([1, 2, 3, 4, 5, 6] as $a) { ?>
                                    <a href="?p=obiettivo.delegati&area=<?= $a ?>" class="btn btn-block">
                                        <i class="icon-book"></i>
                                        Delegati area <?= $a ?>
                                    </a>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="span6">
                                <?php if($me->delegazioneAttuale()->estensione > EST_LOCALE) { ?>
                                <a href="?p=presidente.presidenti&comitato=<?= $me->delegazioneAttuale()->comitato()->oid() ?>" class="btn btn-block">
                                    <i class="icon-book"></i>
                                    Elenco Presidenti
                                </a>
                                <?php } elseif($me->admin() ) { ?>
                                <a href="?p=presidente.presidenti&comitato=Nazionale:1>" class="btn btn-block">
                                    <i class="icon-book"></i>
                                    Elenco Presidenti
                                </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>        
            </div>
        </div>
    </div>
</div>
