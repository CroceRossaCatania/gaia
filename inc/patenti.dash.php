<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_PATENTI , APP_PRESIDENTE]);
$_n     +=  $_n_pat    = $me->numPatentiPending([APP_PRESIDENTE, APP_PATENTI]);
?>

<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>
    <div class="span9">
        <?php if (isset($_GET['err'])) { ?>
            <div class="alert alert-block alert-error">
                <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
                <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
            </div> 
        <?php } ?>
        <div class="row-fluid">
            <div class="span12">
                <h3>Ufficio Patenti</h3>
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
                    <tr>
                        <td>Patenti in attesa</td>
                        <td><?= $_n_pat; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <hr />
        <div class="span12">
            <div class="span6">
                <div class="btn-group btn-group-vertical span12">
                    <a href="?p=patenti.pending" class="btn btn-block">
                        <i class="icon-truck"></i>
                        Patenti in attesa <span class="badge badge-important"><?= $_n_pat; ?></span>
                    </a>
                    <a href="?p=patenti.richieste" class="btn btn-primary btn-block">
                        <i class="icon-list"></i>
                        Richieste Rinnovo <span class="badge badge-important"><?= $_n_ric; ?></span>
                    </a>
                </div>
            </div>
            <div class="span6">
                <div class="btn-group btn-group-vertical span12">
                    <a href="?p=patenti.ricerca" class="btn btn-block">
                        <i class="icon-search"></i>
                        Ricerca patenti
                    </a>
                </div>
            </div>
        </div>
   </div>
</div>
