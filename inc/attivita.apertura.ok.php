<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();
paginaAttivita();

$parametri = array('id');
controllaParametri($parametri, 'attivita.gestione&err');

$attivita = $_GET['id'];

$attivita           = Attivita::id($attivita);

if ( $_GET['chiudi']){

	$attivita->apertura = ATT_CHIUSA;
	redirect('attivita.gestione&chiusa');

}elseif ( $_GET['apri']){

	$attivita->apertura = ATT_APERTA;
	redirect('attivita.gestione&aperta');

}

?>