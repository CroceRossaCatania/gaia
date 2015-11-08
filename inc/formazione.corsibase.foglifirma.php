<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();


controllaParametri(array('id'), 'errore.fatale');

$corso = $_GET['id'];
$corso = CorsoBase::id($corso);

$zip = new Zip();

foreach($corso->lezioni() as $lezione){

    $tabella = '<table border="1" style="width:100%">
                    <tbody>
                        <tr>
                            <td align="center"><b>Cognome e Nome</b></td>
                            <td align="center"><b>Firma</b></td>
                        </tr>';

    foreach($corso->partecipazioni(ISCR_CONFERMATA) as $pb){
        $iscritto = $pb->utente();
        $tabella .= "<tr>
                        <td>{$iscritto->nomeCompleto()}</td>
                        <td></td>
                    </tr>";

    }

    $tabella.= "</tbody></table>";

    $nome  = "Firme lezione ";
    $nome .= $lezione->nome;
    $nome .= ".pdf";

    $pdf = new PDF('fogliofirmelezione', $nome);
    $pdf->_COMITATO   = $corso->organizzatore()->nomeCompleto();
    $pdf->_LEZIONE    = $lezione->nome;
    $pdf->_DATA       = date('d/m/Y', $lezione->inizio);
    $pdf->_TABELLA    = $tabella;
    $f = $pdf->salvaFile(null,true);
    $zip->aggiungi($f);

}

$zip->comprimi("Fogli presenze.zip");
$zip->download();