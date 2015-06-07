<?php

/*
 * ©2015 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('id'));

$id  = $_POST['id'];
$est = Estensione::id($id);
$v = $est->volontario();

if ( $v != $me and !$v->modificabileDa($me) ){
	redirect('errore.permessi');
}

$est->termina();

$m = new Email('estensioneTermina', 'Termine estensione: ' . $est->comitato()->nomeCompleto());
    $m->a 			= $est->comitato()->primoPresidente();
    $m->_NOME       = $v->nomeCompleto();
    $m->_COMITATO   = $est->provenienza()->nomeCompleto();
    $m->invia();

redirect('utente.storico&ester');