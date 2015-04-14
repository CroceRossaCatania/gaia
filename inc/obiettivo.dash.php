<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_OBIETTIVO , APP_PRESIDENTE]);

$d = $me->delegazioneAttuale();

$tutto = false;
if($me->admin() || $me->presidenziante()) {
    $tutto = true;
} else {
    $area = $d->dominio;
}

?>

<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>
    <div class="span9">
        <div class="row-fluid">
            <div class="span12">
                <h3>Delegato d'Area </h3>
                <?php if (isset($_GET['err'])) { ?>
                    <div class="alert alert-block alert-error">
                        <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
                        <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
                    </div> 
                <?php } ?>
                <?php if (isset($_GET['email'])) { ?>
                    <div class="alert alert-block alert-success">
                        <h4><i class="icon-ok"></i> <strong>Email inviata con successo</strong>.</h4>
                        <p>L'email che hai inviato è stata inserita in coda di invio e al più presto sarà recapitata.</p>
                    </div> 
                <?php } ?>
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
                </table>
            </div>
        </div>
        <hr />
        
        <div class="row-fluid">
            <div class="span6">
                <div class="btn-group btn-group-vertical span12">
                    <a href="?p=presidente.titoli.ricerca" class="btn btn-block">
                        <i class="icon-search"></i>
                        Ricerca per titoli
                    </a>
                    <a href="?p=obiettivo.titoli.inserisci" class="btn btn-block">
                        <i class="icon-certificate"></i>
                        Inserisci titoli
                    </a>
               </div>
            </div>
            <div class="span6">
                <div class="btn-group btn-group-vertical span12">
                    <?php if ($tutto || $area == 5 ){ ?>
                    <a href="?p=presidente.utenti.giovani" class="btn btn-block btn-info">
                        <i class="icon-list"></i>
                        Volontari giovani
                    </a>
                    <?php } if ( $tutto || $area == 3 ){ ?>
                        <a href="?p=co.reperibilita" class="btn btn-block">
                            <i class="icon-thumbs-up"></i>
                            Volontari reperibili
                        </a>
                        <a href="?p=obiettivo.report.reperibilita" class="btn btn-block">
                            <i class="icon-time"></i>
                            Report reperibilità
                        </a>
                    <?php } ?>
                </div>
            </div>
                <hr />
                <br/>
        </div>
        <div class="row-fluid">
            <div class="span6">
            </div>
            <div class="span6">
                <div class="btn-group btn-group-vertical span12">
                    <?php if ($tutto) {
                            foreach([1, 2, 3, 4, 5, 6] as $a) { ?>
                                <a href="?p=obiettivo.delegati&area=<?= $a ?>" class="btn btn-block">
                                    <i class="icon-book"></i>
                                    Delegati area <?= $a ?>
                                </a>
                           <?php }
                        } else if($me->delegazioneAttuale()->estensione > EST_UNITA) { ?>
                        <a href="?p=obiettivo.delegati&area=<?= $area ?>" class="btn btn-block">
                            <i class="icon-book"></i>
                            Delegati area <?= $area ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
   </div>
    <hr/>
</div>
            
