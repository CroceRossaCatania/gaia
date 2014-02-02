<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);
$_n     +=  $_n_titoli = $me->numTitoliPending  ([APP_PRESIDENTE, APP_SOCI]);
$_n     +=  $_n_app    = $me->numAppPending     ([APP_PRESIDENTE, APP_SOCI]);
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
            <div class="span12">
                <h3>Ufficio Soci</h3>
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
            <hr />
            <div class="alert alert-block alert-info">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="icon-user"></i> <strong>Alcune indicazioni utili</strong><br />
                Se provi ad inserire un volontario o un socio ordinario ma non riesci a completare l'operazione 
                può essere che la persona abbia provato a registrarsi autonomamente e che l'operazione non sia andata a
                buon fine. <a href="?p=utente.supporto"><i class="icon-envelope"></i> Contatta il supporto</a> e spiega il 
                problema così che sia possibile risolvere la situazione.
                <br />
                Per caricare i volontari o i soci ordinari del tuo comitato in blocco sono disponibili dei format
                in excel da compilare e spedire al supporto che provvederà all'importazione. Non caricare i volontari
                uno ad uno: <a href="?p=utente.supporto"><i class="icon-envelope"></i> contatta il supporto</a> e ti 
                forniranno tutte le indicazioni per caricare in massa volontari e soci ordinari.
            </div>
        </div>
        <div class="row-fluid">
        <div class="span12">
            <div class="span6">
                <div class="row-fluid">
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
                <hr/>
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
                        <a href="?p=us.quoteNo" class="btn btn-block">
                            <i class="icon-certificate"></i>
                            Gestione quote associative
                        </a>
                        <a href="?p=us.quote.ricerca" class="btn btn-block">
                            <i class="icon-search"></i>
                            Ricerca quota associativa
                        </a>
                        <a href="?p=presidente.appartenenzepending" class="btn btn-block">
                            <i class="icon-group"></i>
                            Appartenenze in attesa <span class="badge badge-important"><?= $_n_app; ?></span>
                        </a>
                        <a href="?p=presidente.titoli" class="btn btn-block">
                            <i class="icon-star"></i>
                            Titoli in attesa <span class="badge badge-important"><?= $_n_titoli; ?></span>
                        </a>
                    </div>
                </div>
                <hr/>
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
