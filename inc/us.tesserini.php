<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI,APP_PRESIDENTE]);

$f = $_GET['id'];
$t = Volontario::by('id', $f);

$p = new PDF('tesserini', 'tesserino.pdf');
$p->_NOME = $t->nome;
$p->_COGNOME = $t->cognome;
$p->_NASCITA = $t->comuneNascita;
$p->_DATA = date('d-m-Y', $t->volontario()->dataNascita);
$p->_IMG = 'http://beta.cricatania.it//.'.$t->avatar()->img(20);
$f = $p->salvaFile();
$f->download();
