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
    $r->tVisita = time();
    $r->pVisita = $me;
    
}elseif (isset($_GET['stampa'])) {
    $r = new PatentiRichieste($id);
    $r->stato = PATENTE_ATTESA_CONSEGNA;
    $r->tStampa = time();
    $r->pStampa = $me;
 
}elseif(isset($_GET['consegna'])){
    $r = new PatentiRichieste($id);
    $r->stato = PATENTE_CONSEGNATA;
    $r->tConsegna = time();
    $r->pConsegna = $me;
    
}  

redirect('patenti.richieste');
?>