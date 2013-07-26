<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_CO , APP_PRESIDENTE]);

?>

<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>
    <div class="span9">
        <div class="row-fluid">
            <div class="span12">
                <h3>Centrale Operativa</h3>
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
<!--                
                    <tr><td>Reperibili</td><td><?php echo "help"; ?></td></tr>
                    <tr><td>In servizio</td><td><?php echo "help"; ?></td></tr>
                    -->
                </table>
            </div>
        </div>
        <hr />
        
        <div class="span12">
            <div class="span6">
                <div class="btn-group btn-group-vertical span12">
                    <a href="?p=co.attivita" class="btn btn-primary btn-block">
                        <i class="icon-calendar"></i>
                        Servizi
                    </a>
               </div>
            </div>
            <div class="span6">
                <div class="btn-group btn-group-vertical span12">
                    <a href="?p=co.reperibilita" class="btn btn-block">
                        <i class="icon-thumbs-up"></i>
                        Volontari reperibili
                    </a>
                </div>
            </div>
        </div>
   </div>
    <hr/>
    <!--
    <div class="span9">
    <div class="row-fluid">
            <div class="span12">
                <br/>
                <h3><i class="icon-road"> Autoparco</i></h3>
            </div>
        </div>
    
        <div class="span12">
            <div class="span6">
                <div class="btn-group btn-group-vertical span12">
                    <a href="?p=autoparco.veicoli" class="btn btn-primary btn-block">
                        <i class="icon-plane"></i>
                        Veicoli
                    </a>
                    <a href="?p=autoparco.nuovo" class="btn btn-block btn-success">
                        <i class="icon-plus"></i>
                        Aggiungi veicolo
                    </a>
               </div>
            </div>
            <div class="span6">
                <div class="btn-group btn-group-vertical span12">
                    <a href="?p=autoparco.manutenzione" class="btn btn-block">
                        <i class="icon-wrench"></i>
                        Manutenzione
                    </a>
                </div>
            </div>
        </div>
    </div>
    -->
</div>
            
