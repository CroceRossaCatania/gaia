<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();

?>
<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    <div class="span9">
        
        <h2>
            <i class="icon-certificate muted"></i>
            Richieste di partecipazione
        </h2>
        <hr />

        <?php
        $richieste = $me->autorizzazioniPendenti(); 
        
        //if (!$richieste) { ?>
            <h4 class="text-success">Nessun'altra richiesta, per ora.</h4>
            <p>Verrai avvertito per email non appena ti verrà richiesto di
                autorizzare una partecipazione ad attività.</p>
        
        



    </div>
</div>