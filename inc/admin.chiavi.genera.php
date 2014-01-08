<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaAdmin();

// Se non esiste, genera la chiave web
if ( !APIKey::elenco() ) {
	$k = new APIKey;
	$k->chiave = 'bb2c08ff4da11f0b590a7ae884412e2bfd8ac28a';
	$k->email  = 'noreply@gaia.cri.it';
	$k->nome   = 'Client JS integrato';
	$k->attiva = 1;
	$k->giorno = 0;
	$k->limite = 0;
	redirect('admin.chiavi');
}

$k = new APIKey;
$k->generaChiave();
$k->nome   = '';
$k->attiva = 0;
$k->giorno = 0;
$k->limite = 5000;

redirect('admin.chiavi');
