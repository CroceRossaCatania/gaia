<?php

/* 
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaAttivita();

$t = new Turno($_GET['t']);
$id = $_POST['idTitolo'];
$titolo = Titolo::by('id', $id);
$richiesta = RichiestaTurno::by('turno', $t);
$gia = ElementoRichiesta::filtra([['richiesta', $richiesta],['titolo', $titolo]]);

if ($gia) {
    redirect("attivita.richiesta.turni&id={$t}&gia");  
}

if (!$titolo) {
    redirect("attivita.richiesta.turni&id={$t}");  
}

if($richiesta){
	$r = RichiestaTurno::by('id', $richiesta);
}else{
	$r = new RichiestaTurno();
}

$r->turno = $t;
$r->timestamp = time();

$e = new ElementoRichiesta();
if ($richiesta){
	$e->operatore == $_POST['inputOperatore'];
}else{
	$e->operatore == RIC_UNICA;
}
$e->titolo = $titolo;
$e->richiesta = $r;

redirect("attivita.richiesta.turni&id={$t}");