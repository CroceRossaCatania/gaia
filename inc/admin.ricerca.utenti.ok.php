<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('input'), 'admin.ricerca.utenti&err');
$u = Utente::by('codiceFiscale', $_POST['input']);
if(!$u){
	$u = Utente::by('id', $_POST['input']);
}
if(!$u){
	$u = Utente::by('email', $_POST['input']);
}
if(!$u){
	redirect('admin.ricerca.utenti&no');	
}
redirect('presidente.utente.visualizza&id='.$u);
?>
