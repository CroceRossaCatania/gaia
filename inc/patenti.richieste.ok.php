<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_PATENTI , APP_PRESIDENTE]);

$id = $_GET['id'];

if (isset($_GET['presa'])) {
    $r = new PatentiRichieste($id);
    $r->stato = PATENTE_ATTESA_VISITA;
    $r->tCarico = time();
    $r->pCarico = $me;

}elseif (isset($_GET['visita'])) {
    $r = new PatentiRichieste($id);
    $r->stato = PATENTE_ATTESA_STAMPA;
    $time = DT::createFromFormat('d/m/Y', $_POST['inputData']);
    $time = $time->getTimestamp();
    $r->tVisita = $time;
    $r->pVisita = $me;
    
}elseif (isset($_GET['stampa'])) {
    $r = new PatentiRichieste($id);
    $r->stato = PATENTE_ATTESA_CONSEGNA;
    $time = DT::createFromFormat('d/m/Y', $_POST['inputData']);
    $time = $time->getTimestamp();
    $r->tStampa = $time;
    $r->pStampa = $me;
 
}elseif(isset($_GET['consegna'])){
    $r = new PatentiRichieste($id);
    $r->stato = PATENTE_CONSEGNATA;
    $time = DT::createFromFormat('d/m/Y', $_POST['inputData']);
    $time = $time->getTimestamp();
    $r->tConsegna = $time;
    $r->pConsegna = $me;
    
}  

redirect('patenti.richieste');
?>