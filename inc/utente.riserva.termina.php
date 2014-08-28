<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('id'));

$id = $_GET['id'];
$ris = Riserva::id($id);
$ris->termina();

$m = new Email('riservaTermina', 'Termine riserva: ' . $ris->comitato()->nomeCompleto());
    $m->a = $ris->comitato()->primoPresidente();
    $m->_NOME       = $ris->volontario()->nomeCompleto();
    $m->_COMITATO   = $ris->comitato()->nomeCompleto();
    $m->invia();

redirect('utente.storico&rister');
?>