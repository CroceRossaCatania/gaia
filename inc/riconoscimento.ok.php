<?php

controllaParametri(array('inputCodiceFiscale'), 'recuperaPassword&e');

$codiceFiscale = $_POST['inputCodiceFiscale'];
$codiceFiscale = maiuscolo($codiceFiscale);
$sessione->codiceFiscale = $codiceFiscale;

if ( !preg_match("/^[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]$/", $codiceFiscale) )
	redirect('riconoscimento&e');

if ( !captcha_controlla($_POST['sckey'], $_POST['scvalue']) )
	redirect('riconoscimento&captcha');

$p = Persona::by('codiceFiscale', $codiceFiscale);
if (!$p) {
	$p = new Persona();
	$p->codiceFiscale = $codiceFiscale;
	$sessione->stoRegistrando = $p->id;
	redirect('nuovaAnagrafica&2');
} else {
	if ( !($p->password) ) {
		$sessione->stoRegistrando = $p->id;
		redirect('nuovaAnagrafica&1');
	} else { 
		redirect('giaRegistrato');
	}
}