<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaAttivita();

$attivita = $_GET['id'];
$attivita = new Attivita($attivita);

$g = new Gruppo();
	$g->nome        =   $attivita->nome;
	$g->comitato    =   $attivita->comitato()->id;
	$g->obiettivo   =   $attivita->area()->obiettivo;
	$g->area        =   $attivita->area();
	$g->referente   =   $attivita->referente();
	$g->attivita 	=	$attivita->id;

redirect('attivita.scheda&gok&id=' . $attivita->id);