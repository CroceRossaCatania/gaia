<?php

/* 
 * (c)2015 Croce Rossa Italiana
 */

paginaPrivata();

$t = TitoloPersonale::id($_GET['id']);
if (!$t || $t->volontario != $me)
	redirect('utente.titoli');

$p = new PDF('titolocertificato', 'Certificato.pdf');
$p->orientamento    = ORIENTAMENTO_ORIZZONTALE;;

$f = $p->salvaFile(null, true);
$f->anteprima();