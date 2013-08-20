<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$id = $_POST['id'];
$est = new Estensione($id);
$est->termina();

$m = new Email('estensioneTermina', 'Termine estensione: ' . $app->comitato()->nome);
    $m->a = $me;
    $m->_NOME       = $est->volontario()->nomeCompleto();
    $m->_COMITATO   = $est->provenienza()->nomeCompleto();
    $m->invia();

redirect('utente.storico&ester');
?>