<?php


/*
 * ©2013 Croce Rossa Italiana
 */
paginaPrivata();

$contatore = Corso::chiudiCorsi();
print "Generati $contatore certificati";
?>