<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(['id'],'admin.tesseramento&err');

$t = Tesseramento::id($_GET['id']);
if ($t->haQuote()) {
	redirect('admin.tesseramento&haquote');
}

$t->cancella();

redirect('admin.tesseramento&ok');

?>
