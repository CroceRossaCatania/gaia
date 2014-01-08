<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaAdmin();

foreach ( $_POST['chiavi'] as $chiave ) {
	$c = APIKey::id($chiave);
	$c->nome 		= $_POST["{$c}_nome"];
	$c->email 		= $_POST["{$c}_email"];
	$c->limite 		= $_POST["{$c}_limite"];
	$c->attiva 		= $_POST["{$c}_attiva"];
}

redirect('admin.chiavi');