<?php

/*
 * ©2015 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);
controllaParametri(['id'], 'autoparco.veicoli&err');
$veicolo = $_GET['id'];


proteggiVeicoli($veicolo, [APP_AUTOPARCO, APP_PRESIDENTE]);

$p = new PDF("tuttirifornimenti","rifornimenti{$_GET['id']}.pdf");
$corpo = "<table>
            <thead>
                <th>Km</th>
                <th>Data</th>
                <th>Litri</th>
                <th>Costo</th>
                <th>registrato da</th>
                <th>Azioni</th>
            </thead>";
 $rifornimenti = Rifornimento::filtra([['veicolo', $veicolo]],'data DESC');
            $costo   = 0;
            foreach ( $rifornimenti as $rifornimento ){ 
                $costo    = $costo + $rifornimento->costo;
                $corpo .="<tr>
                        <td>{ $rifornimento->km; }</td>
                        <td>{ date('d/m/Y', $rifornimento->data); }</td>
                        <td>{ $rifornimento->litri; }</td>
                        <td>{ $rifornimento->costo; }</td>
                        <td>{ $rifornimento->volontario()->nomeCompleto(); }</td>
                        <tr>";
            }
            $corpo .="</table>
        <hr/>
        <h3>Costo complessivo rifornimenti: { $costo; } €</h3>
        <h3>Consumo medio carburante: { $veicolo->consumoMedio(); } l/100km</h3>";
    $p->_CORPO = $corpo

$f = $p->salvaFile();
$f->download();

                    
                