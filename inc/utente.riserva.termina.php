<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$id = $_GET['id'];
$ris = new Riserva($id);
$ris->termina();

$m = new Email('riservaTermina', 'Termine riserva: ' . $ris->comitato()->nomeCompleto());
    $m->a = $me;
    $m->_NOME       = $ris->volontario()->nomeCompleto();
    $m->_COMITATO   = $ris->comitato()->nomeCompleto();
    $m->invia();

redirect('utente.storico&rister');
?>