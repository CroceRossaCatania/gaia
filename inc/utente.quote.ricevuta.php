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

$p = new PDF('ricevutaquota', 'ricevuta.pdf');
$p->_COMITATO 	= $quota->comitato()->locale()->nomeCompleto();
$p->_INDIRIZZO 	= $quota->comitato()->locale()->formattato;
$p->_TEL		= $quota->comitato()->locale()->telefono;
$p->_PIVA 		= $quota->comitato()->piva();
$p->_ID 		= $quota->progressivo();
$p->_NOME 		= $v->nome;
$p->_COGNOME 	= $v->cognome;
$p->_FISCALE 	= $v->codiceFiscale;
$p->_IMPORTO 	= $quota->quota;
$p->_QUOTA 	   	= $quota->causale;
$p->_TOTALE 	= $quota->quota;
$p->_LUOGO 		= $quota->comitato()->locale()->comune;
$p->_DATA 		= date('d/m/Y', $quota->tConferma);
$p->_CHINOME	= $quota->conferma()->nomeCompleto();
$p->_CHICF		= $quota->conferma()->codiceFiscale;
$f = $p->salvaFile($quota->comitato());  
$f->download();

?>
