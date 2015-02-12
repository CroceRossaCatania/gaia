<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('idDonazione'));
print_r($_POST);die;
$id = $_POST['idDonazione'];

$t = Donazione::id($id);

$p = new DonazionePersonale();
$p->volontario  = $me->id;
$p->donazione   = $t->id;

$data = @DateTime::createFromFormat('d/m/Y', $_POST['data']);
$data = @$data->getTimestamp();
$p->data = $data;

$p->luogo = normalizzaNome($_POST['luogo']);

if ( !$conf['donazioni'][$t->tipo][1] ) {
    $p->tConferma = time();
    $p->pConferma = $me->id;
}

if(in_array(count($me->donazioniTipo($t->tipo)),$conf['merito'][$t->tipo])){
	$p = new DonazioneMerito();
	$p->volontario  = $me->id;
	$p->donazione   = $t->tipo;
	$p->merito = count($me->donazioniTipo($t->tipo));
}

redirect('utente.donazioni&d=' . $t->tipo);
