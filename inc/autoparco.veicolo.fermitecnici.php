<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);

controllaParametri(['id'], 'autoparco.veicoli&err');
$veicolo = $_GET['id'];
$veicolo = Veicolo::id($veicolo);

proteggiVeicoli($veicolo, [APP_AUTOPARCO, APP_PRESIDENTE]);

?>
<script type="text/javascript"><?php require './assets/js/presidente.utenti.js'; ?></script>
<br/>
<div class="row-fluid">
    <div class="span4">
        <h2>
            <i class="icon-unlink muted"></i>
            Fermi tecnici
        </h2>
        Veicolo: <b><?= $veicolo->targa; ?></b>
    </div>

    <div class="span4">
        <div class="span12">
            <a href="?p=autoparco.dash" class="btn btn-block ">
                <i class="icon-reply"></i> Torna alla dash
            </a>
        </div>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Fermo tecnico..." type="text">
        </div>
    </div>  
    <br/>
</div>

<hr />

<div class="row-fluid">
    <div class="span12">
        <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Motivo</th>
                <th>Inizio</th>
                <th>Fine</th>
                <th>Dichiarato da</tH>
            </thead>
            <?php
            $fermitecnici = Fermotecnico::filtra([['veicolo', $veicolo]],'inizio DESC');
            foreach ( $fermitecnici as $fermotecnico ){ ?>
                    <tr>
                        <td><?= $fermotecnico->motivo; ?></td>
                        <td><?= $fermotecnico->inizio(); ?></td>
                        <td><?= $fermotecnico->fine(); ?></td>
                        <td><?= $fermotecnico->pInizio()->nomeCompleto(); ?></td>
                    </tr>
                <?php }?>
        </table>
    </div>
</div>