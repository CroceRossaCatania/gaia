<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);

$numVeicoli=0;
$numFermotecnico=0;
$fermotecnico=[];
$revisioni=[];
$manutenzioni=[];
$comitati = $me->comitatiApp([APP_PRESIDENTE,APP_AUTOPARCO],false);
foreach ( $comitati as $comitato ){
    foreach( Veicolo::filtra([['comitato', $comitato->oid()],['stato', VEI_ATTIVO]],'targa ASC') as $veicolo ) {
        $numVeicoli++;
        if ( $veicolo->fermoTecnico() ){
            $numFermotecnico++;
            $fermotecnico[] = $veicolo;
        }
        $revisione = $veicolo->ultimaRevisione();
        if ( ($revisione + $veicolo->intervalloRevisione) < (time()+MESE) ){
            $revisioni[] = $veicolo;
        }
        $manutenzione = $veicolo->ultimaManutenzione();
        if ( ($manutenzione + ANNO ) < time() ){
            $manutenzioni[] = $veicolo;
        }
    }
}
$numAttivi = $numVeicoli - $numFermotecnico;

?>

<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>
    <div class="span9">
        <div class="row-fluid">
            <div class="span12">
                <h3>Autoparco</h3>
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
        
        <div class="span12">
            <div class="row-fluid">
                <div class="span4 centrato">
                    <h4><i class="icon-truck"></i> Registrati: <?= $numVeicoli; ?> </h4>
                </div>
                <div class="span4 centrato">
                    <h4><i class="icon-ok"></i> Attivi: <?= $numAttivi;?> </h4>
                </div>
                <div class="span4 centrato">
                    <h4><i class="icon-unlink"></i> Fermo tecnico: <?= $numFermotecnico;?> </h4>
                    <?php foreach ( $fermotecnico as $fermo ){ 
                        echo $fermo->targa, "<br/>";
                    } ?>
                </div>
            </div>
            <hr/>
            <?php if ( $revisioni ) { ?>
                <div class="span12">
                    <div class ="row-fluid">
                        <div class="alert alert-danger">
                            <i class="icon-exclamation"></i> <strong>Attenzione revisione in scadenza</strong>.
                            <p>I seguenti veicoli necessitano revisione periodica: </p>
                            <?php foreach ( $revisioni as $revisione ){
                                echo "<b>", $revisione->targa, "</b> - Ultima revisione: ", date('d/m/Y', $revisione->ultimaRevisione()), "<br/>";
                            } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ( $manutenzioni ) { ?>
                <div class="span12">
                    <div class ="row-fluid">
                        <div class="alert alert-danger">
                            <i class="icon-exclamation"></i> <strong>Attenzione mancata manutenzione</strong>.
                            <p>I seguenti veicoli non vengono manutentati da un anno: </p>
                            <?php foreach ( $manutenzioni as $manutenzione ){
                                echo "<b>", $manutenzione->targa, "</b> - Ultima manutenzione: ", date('d/m/Y', $manutenzione->ultimaManutenzione()), "<br/>";
                            } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="row-fluid">
                <div class="span6">
                    <div class="row-fluid">
                        <div class="btn-group btn-group-vertical span12">
                            <a href="?p=autoparco.veicoli" class="btn btn-success btn-block">
                                <i class="icon-truck"></i>
                                Veicoli
                            </a>
                            <a href="?p=autoparco.veicoli.fuoriuso" class="btn btn-danger btn-block">
                                <i class="icon-truck"></i>
                                Veicoli fuori uso
                            </a>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="btn-group btn-group-vertical span12">
                        <a href="?p=autoparco.autoparchi" class="btn btn-info btn-block">
                            <i class="icon-truck"></i>
                            Autoparchi
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
    </div>
</div>            