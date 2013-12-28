<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('id'));
$a = $_GET['id'];

$a = Commento::id($a);
$a->commento = $_POST['inputCommento'];
$a->tCommenta = time();

redirect('attivita.pagina&id=' . $a->attivita);

?>
