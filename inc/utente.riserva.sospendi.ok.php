<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

if(!isset($_POST['elimina']))
{
    redirect('utente.riserva');
}

$r = $me->unaRiservaInSospeso();
$r->annulla();

redirect('utente.riserva&ann');


?>
