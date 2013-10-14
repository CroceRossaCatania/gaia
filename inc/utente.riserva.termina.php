<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$id = $_GET['id'];
$ris = new Riserva($id);

$m = new Email('riservaTermina', 'Termine riserva: ' . $ris->comitato()->nomeCompleto());
    $m->a = $ris->comitato()->unPresidente();
    $m->_NOME       = $ris->volontario()->nomeCompleto();
    $m->_COMITATO   = $ris->comitato()->nomeCompleto();
    $m->invia();

$ris->termina();
redirect('utente.storico&rister');
?>