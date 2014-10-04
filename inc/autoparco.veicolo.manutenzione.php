<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);

controllaParametri(['id'], 'autoparco.veicoli&err');
$veicolo = $_GET['id'];
$veicolo = Veicolo::id($veicolo);

/* Mica posso vedere o modificare le collocazioni di altri veicoli */
proteggiVeicoli($veicolo, [APP_AUTOPARCO, APP_PRESIDENTE]);

?>
<script type="text/javascript"><?php require './assets/js/presidente.utenti.js'; ?></script>
<br/>
<div class="row-fluid">
    <div class="span4">
        <h2>
            <i class="icon-wrench muted"></i>
            Manutenzioni
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
            <input autofocus required id="cercaUtente" placeholder="Cerca Manutenzione..." type="text">
        </div>
        <?php if ( $veicolo->stato == VEI_ATTIVO ){ ?>
            <a class="btn btn-success" href="?p=autoparco.veicolo.manutenzione.nuovo&id=<?= $veicolo; ?>">
                <i class="icon-plus"></i> Aggiungi Manutenzione
            </a>
        <?php } ?>
    </div>  
    <br/>
</div>

<hr />

<div class="row-fluid">
    <div class="span12">
        <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Tipo</th>
                <th>Data</th>
                <th>Km</th>
                <th>Descrizione</th>
                <th>Azioni</th>
            </thead>
            <?php
            $manutenzioni = Manutenzione::filtra([['veicolo', $veicolo]],'tIntervento DESC');
            $costo = 0;
            foreach ( $manutenzioni as $manutenzione ){ 
                $costo = $costo + $manutenzione->costo;
                ?>
                    <tr>
                        <td><?= $conf['man_tipo'][$manutenzione->tipo]; ?></td>
                        <td><?= $manutenzione->data(); ?></td>
                        <td><?= $manutenzione->km; ?></td>
                        <td><?= $manutenzione->intervento; ?></td>
                        <td>
                            <div class="btn-group">
                                <a  href="?p=autoparco.veicolo.manutenzione.dettagli&id=<?= $manutenzione->id; ?>" title="Visualizza dettagli manutenzione" class="btn btn-small">
                                    <i class="icon-eye-open"></i> Dettagli
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php }?>
        </table>
        <hr/>
        <h3>Costo complessivo manutenzioni: <?= soldi($costo); ?> €</h3>
    </div>
</div>