<?php

/*
 * ©2013 Croce Rossa Italiana
 */	

paginaApp([APP_SOCI , APP_PRESIDENTE]);
controllaParametri(array('id'), 'presidente.utenti.dimessi&errGen');
$u = Utente::id($_GET['id']);

if(!$u->riammissibile() || !$u->modificabileDa($me)){
	redirect('presidente.utenti.dimessi&err');
}