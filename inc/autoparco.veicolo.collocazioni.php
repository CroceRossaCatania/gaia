<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);

controllaParametri(array('id'), 'autoparco.veicoli&err');
$veicolo = $_GET['id'];
$veicolo = Veicolo::id($veicolo);

/* Mica posso vedere o modificare le collocazioni di altri veicoli */
proteggiVeicoli($veicolo, [APP_AUTOPARCO, APP_PRESIDENTE]);

?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<br/>
<div class="row-fluid">
    <div class="span4">
        <h2>
            <i class="icon-truck muted"></i>
            Collocazione
        </h2>
    </div>

    <div class="span4">
        <div class="btn-group btn-group-vertical span12">
            <a href="?p=autoparco.dash" class="btn btn-block ">
                <i class="icon-reply"></i> Torna alla dash
            </a>
        </div>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Collocazione..." type="text">
        </div>
    </div>  
    <br/>
</div>

<hr />

<div class="row-fluid">
    <div class="span12">
        <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Targa</th>
                <th>Autoparco</th>
                <th>Inizio</th>
                <th>Fine</th>
            </thead>
            <?php
            $collocazioni = Collocazione::filtra([['veicolo', $veicolo]],'inizio DESC');
            foreach ( $collocazioni as $collocazione ){ ?>
                    <tr>
                        <td><?= $veicolo->targa; ?></td>
                        <td><?= $collocazione->autoparco()->nome; ?></td>
                        <td><?= $collocazione->inizio(); ?></td>
                        <td><?= $collocazione->fine(); ?></td>
                    </tr>
                <?php }?>
        </table>
    </div>
</div>