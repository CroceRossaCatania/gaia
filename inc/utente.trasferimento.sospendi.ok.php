<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

if(!isset($_POST['elimina']))
{
    redirect('utente.riserva');
}

$t = $me->trasferimenti(TRASF_INCORSO);
$t = $t[0];


$t->annulla();

redirect('utente.trasferimento&ann');


?>
