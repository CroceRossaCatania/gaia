<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$a = $_GET['a'];

$f = new Commento($a);
$a = $f->attivita;
$f->cancella();

redirect('attivita.pagina&a=' . $a);