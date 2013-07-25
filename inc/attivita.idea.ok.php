<?php

/*
 * ©2013 Alfio Emanuele Fresta
 */

paginaPrivata();
paginaAttivita();

$comitato = $_POST['comitato'];
$comitato = new Comitato($comitato);

$area     = $_POST['inputArea'];
$area     = new Area($area);

$attivita           = new Attivita();
$attivita->stato    = ATT_STATO_BOZZA;
$attivita->area     = $area;
$attivita->comitato = $comitato;

$attivita->nome     = normalizzaTitolo($_POST['inputNome']);

$attivita->timestamp    = time();
$attivita->autore       = $me;
$attivita->visibilita   = ATT_VIS_UNITA;

if ( $_POST['inputGruppo'] ) {
    redirect('attivita.referente&g&id=' . $attivita->id);
}else{
    redirect('attivita.referente&id=' . $attivita->id);
}