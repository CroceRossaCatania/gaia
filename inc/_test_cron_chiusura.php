<?php


/*
 * ©2013 Croce Rossa Italiana
 */
paginaPrivata();

$corso = Corso::id(205);
$corso->chiudi();
print "Generati $contatore certificati";
?>