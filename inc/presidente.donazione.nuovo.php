<?php

/*
 * ©2013 Croce Rossa Italiana
 */
print_r($_POST);exit;
paginaApp([APP_SOCI , APP_PRESIDENTE]);

$parametri = array('idDonazione', 'id');
controllaParametri($parametri, 'presidente.donazioni&err');

$id = $_POST['idDonazione'];
$f = $_GET['id']; 
$v= Volontario::id($f);

$t = Donazione::id($id);

$p = new DonazionePersonale();
$p->volontario  = $v->id;
$p->donazione      = $t->id;

$data = @DateTime::createFromFormat('d/m/Y', $_POST['data']);
$data = @$data->getTimestamp();
$p->data = $data;

$p->luogo = normalizzaNome($_POST['ospedale']);

$p->tConferma = time();
$p->pConferma = $me->id;

if(in_array(count($v->donazioniTipo($t->tipo)),$conf['merito'][$t->tipo])){
	$p = new DonazioneMerito();
	$p->volontario  = $v->id;
	$p->donazione   = $t->tipo;
	$p->merito = count($v->donazioniTipo($t->tipo));
}

redirect('presidente.utente.visualizza&id=' . $v);
