<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('id'));

$id = $_POST['id'];
$est = Estensione::id($id);
$est->termina();

$m = new Email('estensioneTermina', 'Termine estensione: ' . $est->comitato()->nomeCompleto());
    $m->a 			= $est->comitato()->unPresidente();
    $m->_NOME       = $est->volontario()->nomeCompleto();
    $m->_COMITATO   = $est->provenienza()->nomeCompleto();
    $m->invia();

redirect('utente.storico&ester');
?>