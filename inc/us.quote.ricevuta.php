<?php

/*
 * ©2013 Croce Rossa Italiana
 */
paginaApp([APP_SOCI , APP_PRESIDENTE]);

controllaParametri(array('id'), 'us.dash&err');

$id = $_GET['id'];
$quota = Quota::id($id);
$v = $quota->volontario();

proteggiDatiSensibili($v, [APP_SOCI, APP_PRESIDENTE]);

if($quota->annullata()) {
    redirect('us.quote.visualizza&annullata&id='.$u->id);
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
$p->_COMITATO   = $quota->comitato()->locale()->nomeCompleto();
$p->_INDIRIZZO  = $quota->comitato()->locale()->formattato;
$p->_TEL        = $quota->comitato()->locale()->telefono;
$p->_ID         = $quota->progressivo();
$p->_NOME       = $v->nome;
$p->_COGNOME    = $v->cognome;
$p->_FISCALE    = $v->codiceFiscale;
$p->_IMPORTO    = soldi($quotaMin);
$p->_QUOTA      = $quota->causale;
if (($quota->quota - $quotaMin) > 0) {
	$p->_OFFERTA = $quota->offerta;
    $p->_OFFERIMPORTO = soldi($quota->quota - $quotaMin) . "  &#0128; ";
} else {
	$p->_OFFERTA    = '';
    $p->_OFFERIMPORTO = '';
}
$p->_TOTALE     = soldi($quota->quota);
$p->_LUOGO      = $quota->comitato()->locale()->comune;
$p->_DATA       = $quota->dataPagamento()->format('d/m/Y');
$f = $p->salvaFile($quota->comitato());  
$f->download();

?>
