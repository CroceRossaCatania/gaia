<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$a = $_GET['a'];

$a = new Commento($a);
$a->commento = $_POST['inputCommento'];
$a->tCommenta = time();

redirect('attivita.pagina&a=' . $a->attivita);