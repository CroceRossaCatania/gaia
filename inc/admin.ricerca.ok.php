<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('input'), 'admin.ricerca.cf&err');
$u = Utente::by('codiceFiscale', $_POST['input']);
if(!$u){
	$u = Utente::by('id', $_POST['input']);
}
if(!$u){
	$u = Utente::by('email', $_POST['input']);
}
if(!$u){
	redirect('admin.ricerca&no');	
}
redirect('presidente.utente.visualizza&id='.$u);
?>
