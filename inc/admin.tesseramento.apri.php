<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$anno = date('Y');

if(Tesseramento::by('anno', $anno)) {
	redirect('admin.tesseramento&anno');
}

$t = new Tesseramento();
$t->anno = $anno;
$t->stato = TESSERAMENTO_APERTO;

redirect('admin.tesseramento');

?>
