<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();


controllaParametri(array('id'), 'errore.fatale');

$corso = $_GET['id'];
$corso = CorsoBase::id($corso);

foreach($corso->partecipazioni(ISCR_CONFERMATA) as $pb){
	$iscritto = $pb->utente();
	$elencoIscritti[] = $iscritto->nomeCompleto(true);
}
natcasesort($elencoIscritti);

$zip = new Zip();

foreach($corso->lezioni() as $lezione){

    $tabella = '<table border="1" style="width:100%">
                    <tbody>
                        <tr>
                            <td align="center" style="width:50%"><b>Cognome e Nome</b></td>
                            <td align="center" style="width:50%"><b>Firma</b></td>
                        </tr>';

    foreach($elencoIscritti as $nomeIscritto){
        $tabella .= "<tr>
                        <td>$nomeIscritto</td>
                        <td></td>
                    </tr>";

    }

    $tabella.= "</tbody></table>";

    $nome  = "Firme lezione ";
    $nome .= $lezione->nome;
    $nome .= ".pdf";

    $p = new PDF('fogliofirmelezione', $nome);
    $p->_COMITATO   = $corso->organizzatore()->nomeCompleto();
    $p->_LEZIONE    = $lezione->nome;
    $p->_DATA       = date('d/m/Y', $lezione->inizio);
    $p->_TABELLA    = $tabella;
    $f = $p->salvaFile(null,true);
    $zip->aggiungi($f);

}

$zip->comprimi("Fogli presenze.zip");
$zip->download();