<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();

$parametri = array('id');
controllaParametri($parametri, 'attivita.gestione&err');

$attivita = $_GET['id'];
$attivita = Attivita::id($attivita);
paginaAttivita($attivita);

$attivita->timestamp = time();

if ( isset($_GET['chiudi']) ) {

	if ( $attivita->turniFut() ){
		redirect('attivita.gestione&turni');
	}

	$attivita->apertura = ATT_CHIUSA;
	redirect('attivita.gestione&chiusa');

}elseif ( isset($_GET['apri']) ) {

	$attivita->apertura = ATT_APERTA;
	redirect('attivita.gestione&aperta');

}

?>