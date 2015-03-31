<?php

/*
 * ©2015 Croce Rossa Italiana
 */

paginaSupporto();
controllaParametri(array('input'), 'supporto.ricerca.utenti&err');
$u = Utente::by('codiceFiscale', $_POST['input']);
if(!$u){
	$u = Utente::by('id', $_POST['input']);
}
if(!$u){
	$u = Utente::by('email', $_POST['input']);
}
if(!$u){
	redirect('supporto.ricerca.utenti&no');	
}
redirect('presidente.utente.visualizza&id='.$u);
?>
