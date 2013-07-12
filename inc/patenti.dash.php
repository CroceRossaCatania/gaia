<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_PATENTI , APP_PRESIDENTE]);

?>

<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>
    <div class="span9">
        <div class="row-fluid">
            <div class="span12">
                <h3>Ufficio Patenti</h3>
            </div>
        </div>
                    
        <div class="row-fluid">
            <div class="span3">
                
            </div>
            
            <div class="span6 allinea-centro">
                <img src="http://upload.wikimedia.org/wikipedia/it/thumb/4/4a/Emblema_CRI.svg/75px-Emblema_CRI.svg.png" />
            </div>

            <div class="span3">
                <table class="table table-striped table-condensed">
                
                    <tr><td>Num. Richieste</td><td>Funzione richieste</td></tr>
                    
                </table>
            </div>
        </div>
        <hr />
        
        <div class="span12">
            <div class="span6">
                <div class="btn-group btn-group-vertical span12">
                    <a href="?p=patenti.richieste" class="btn btn-primary btn-block">
                        <i class="icon-list"></i>
                        Richieste Rinnovo
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
