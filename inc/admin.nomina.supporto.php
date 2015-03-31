<?php

/*
 * ©2015 Croce Rossa Italiana
 */

paginaAdmin();

$id = $_GET['id'];

$u = Utente::id($id);

if($u->supporto != 0){ 
	$u->supporto = 0;
}else{
	$u->supporto = time();
}

redirect("presidente.utente.visualizza&id={$id}");
