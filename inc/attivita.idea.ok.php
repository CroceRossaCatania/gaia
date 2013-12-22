<?php

/*
 * ©2013 Alfio Emanuele Fresta
 */

paginaPrivata();
paginaAttivita();

$parametri = array('comitato', 'inputArea', 'inputNome');
controllaParametri($parametri, 'attivita.gestione&err');

$comitato = $_POST['comitato'];
$comitato = GeoPolitica::daOid($comitato);

$area     = $_POST['inputArea'];
$area     = Area::id($area);

$attivita           = new Attivita();
$attivita->stato    = ATT_STATO_BOZZA;
$attivita->area     = $area;
$attivita->comitato = $comitato->oid();

$attivita->nome     = normalizzaTitolo($_POST['inputNome']);

$attivita->timestamp    = time();
$attivita->autore       = $me;
$attivita->visibilita   = ATT_VIS_UNITA;

if ( $_POST['inputGruppo'] ) {
    redirect('attivita.referente&g&id=' . $attivita->id);
}else{
    redirect('attivita.referente&id=' . $attivita->id);
}