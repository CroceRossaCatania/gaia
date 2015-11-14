<?php

/* 
 * (c)2015 Croce Rossa Italiana
 */

paginaPrivata();

$t = TitoloPersonale::id($_GET['id']);
if (!$t || $t->volontario != $me)
	redirect('utente.titoli');

$p = new PDF('titolocertificato', 'Certificato.pdf');
$p->orientamento = ORIENTAMENTO_ORIZZONTALE;
$p->_NOME 		 = $t->volontario()->nomeCompleto();
$p->_TITOLO 	 = $t->titolo()->nome;
$p->_DATA 		 = date('d/m/Y', $t->tConferma);
//$p->_ESAMINATORE = $t->pConferma->volontario()->nomeCompleto();

$f = $p->salvaFile(null, true);
$f->anteprima();