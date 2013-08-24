<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

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
                    
                </table>
            </div>
        </div>
        <hr />
        
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
            </div>
            <div class="span6">
                <div class="btn-group btn-group-vertical span12">
                  <a href="?p=us.quoteNo" class="btn btn-block">
                        <i class="icon-certificate"></i>
                        Gestione quote associative
                    </a>
                     <a href="?p=us.quote.ricerca" class="btn btn-block">
                        <i class="icon-search"></i>
                        Ricerca quota associativa
                    </a>
                    <a href="?p=presidente.appartenenzepending" class="btn btn-block btn-success">
                        <i class="icon-group"></i>
                        Appartenenze in attesa
                    </a>
                    <a href="?p=presidente.titoli" class="btn btn-block btn-success">
                        <i class="icon-star"></i>
                        Titoli in attesa
                    </a>
                </div>
            </div>
        </div>
   </div>
</div>
