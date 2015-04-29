<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('id'), 'utente.storico&err');

$id = $_GET['id'];
$quota = Quota::id($id);
$v = $quota->volontario();

if($v->id != $me->id) {
	redirect('errore.permessi&cattivo');
}

if($quota->annullata()) {
    redirect('utente.storico&quotaAnn');
}

$attivo = false;
if ($quota->appartenenza()->statoSocio() == VOLONTARIO) {
  $attivo = true;
}
if (!$t = Tesseramento::by('anno', $quota->anno)) {
  $t = new StdClass();
  $t->attivo = 8;
  $t->ordinario = 16;
}

$quotaMin = $attivo ? $t->attivo : $t->ordinario;


$p = new PDF('ricevutaquota', 'ricevuta.pdf');
$p->_COMITATO 	= $quota->comitato()->locale()->nomeCompleto();
$p->_ID 		= $quota->progressivo();
$p->_NOME 		= $v->nome;
$p->_COGNOME 	= $v->cognome;
$p->_FISCALE 	= $v->codiceFiscale;
$p->_IMPORTO 	= soldi($quotaMin);
$p->_QUOTA      = $quota->causale;
if (($quota->quota - $quotaMin) > 0) {
	$p->_OFFERTA = $quota->offerta;
    $p->_OFFERIMPORTO = soldi($quota->quota - $quotaMin) . "  &#0128; ";
} else {
	$p->_OFFERTA    = '';
    $p->_OFFERIMPORTO = '';
}
$p->_TOTALE 	= $quota->quota;
$p->_LUOGO 		= $quota->comitato()->locale()->comune;
$p->_DATA 		= date('d/m/Y', $quota->tConferma);
$p->_CHINOME	= $quota->conferma()->nomeCompleto();
$p->_CHICF		= $quota->conferma()->codiceFiscale;
$f = $p->salvaFile($quota->comitato());  
$f->download();

?>
