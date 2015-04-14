<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE, APP_OBIETTIVO]);

controllaParametri(array('id'), 'presidente.donazioni&err');

$id     = $_GET['id'];
$t      = DonazionePersonale::id($id);
$v      = $t->volontario();
if (!$v->modificabileDa($me)) {
    redirect('presidente.donazioni&err');
}

if (isset($_GET['si'])) {
    $t->tConferma   = time();
    $t->pConferma   = $me->id;
    $m = new Email('confermadonazione', 'Conferma donazione: ' . $t->donazione()->nome);
    $m->da = $me; 
    $m->a = $t->volontario();
    $m->_NOME       = $t->volontario()->nome;
    $m->_TITOLO   = $t->donazione()->nome;
    $m->invia();
} else {
    $m = new Email('negazionedonazione', 'Negazione donazione: ' . $t->donazione()->nome);
    $m->da = $me; 
    $m->a = $t->volontario();
    $m->_NOME       = $t->volontario()->nome;
    $m->_TITOLO   = $t->donazione()->nome;
    $m->invia();

	$m = DonazioneMerito::filtra([ ['volontario', $t->volontario()->id], ['donazione', $t->donazione()->tipo] ]);
	if(count($m)){
		$p = DonazioneMerito::id($m[(count($m)-1)]->id);
		foreach($conf['merito'][$t->donazione()->tipo] as $value){
			if(count($t->volontario()->donazioniTipo($t->donazione()->tipo)) <= $value)
				$p->cancella();
		}
	}

    $t->cancella();

}

redirect('presidente.donazioni&ok');
