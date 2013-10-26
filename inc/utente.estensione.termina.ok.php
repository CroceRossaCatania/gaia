<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$id = $_POST['id'];
$est = Estensione::id($id);
$est->termina();

$m = new Email('estensioneTermina', 'Termine estensione: ' . $est->comitato()->nomeCompleto());
    $m->a = $ris->comitato()->unPresidente();
    $m->_NOME       = $est->volontario()->nomeCompleto();
    $m->_COMITATO   = $est->provenienza()->nomeCompleto();
    $m->invia();

redirect('utente.storico&ester');
?>