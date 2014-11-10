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
<?php if ( isset($_GET['del']) ) { ?>
    <div class="alert alert-danger">
        <i class="icon-trash"></i> <strong>Rifornimento cancellato</strong>.
        Il rifornimento è stato cancellato con successo.
    </div>
<?php } ?>
<script type="text/javascript"><?php require './assets/js/presidente.utenti.js'; ?></script>
<br/>
<div class="row-fluid">
    <div class="span4">
        <h2>
            <i class="icon-credit-card"></i>
            Rifornimenti
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
            <input autofocus required id="cercaUtente" placeholder="Cerca Rifornimento..." type="text">
        </div>
    </div>  
    <br/>
</div>

<hr />

<div class="row-fluid">
    <div class="span12">
        <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Km</th>
                <th>Data</th>
                <th>Litri</th>
                <th>Costo</th>
                <th>registrato da</th>
                <th>Azioni</th>
            </thead>
            <?php
            $rifornimenti = Rifornimento::filtra([['veicolo', $veicolo]],'data DESC');
            $costo   = 0;
            foreach ( $rifornimenti as $rifornimento ){ 
                $costo    = $costo + $rifornimento->costo;
                 ?>
                    <tr>
                        <td><?= $rifornimento->km; ?></td>
                        <td><?= date('d/m/Y', $rifornimento->data); ?></td>
                        <td><?= $rifornimento->litri; ?></td>
                        <td><?= $rifornimento->costo; ?></td>
                        <td><?= $rifornimento->volontario()->nomeCompleto(); ?></td>
                        <td>
                            <a  href="?p=autoparco.veicolo.rifornimento.nuovo&id=<?= $rifornimento->id; ?>&mod" title="Modifica rifornimenti veicolo" class="btn btn-small btn-info">
                                <i class="icon-edit"></i> Modifica
                            </a>
                        </td>
                    </tr>
                <?php } ?>
        </table>
        <hr/>
        <h3>Costo complessivo rifornimenti: <?= $costo; ?> €</h3>
        <h3>Consumo medio carburante: <?= $veicolo->consumoMedio(); ?> l/100km</h3>
    </div>
</div>