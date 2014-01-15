<?php

/*
 * ©2013 Croce Rossa Italiana
 */
paginaApp([APP_SOCI , APP_PRESIDENTE]);

controllaParametri(array('id'), 'us.dash&err');

$id = $_GET['id'];
$quota = Quota::id($id);
$v = $quota->volontario();
$p = new PDF('ricevutaquota', 'ricevuta.pdf');
$p->_COMITATO 	= $quota->comitato()->locale()->nomeCompleto();
$p->_INDIRIZZO 	= $quota->comitato()->locale()->formattato;
$iva 			= $quota->comitato()->locale()->piva();
$p->_PIVA 		= $iva;
$p->_ID 		= $quota->progressivo();
$p->_NOME 		= $v->nome;
$p->_COGNOME 	= $v->cognome;
$p->_FISCALE 	= $v->codiceFiscale;
$p->_NASCITA 	= date('d/m/Y', $v->dataNascita);
$p->_LUOGO 		= $v->luogoNascita;
$p->_QUOTA 		= $quota->quota;
$p->_CAUSALE 	= $quota->causale;
$p->_LUOGO 		= $quota->comitato()->locale()->comune;
$p->_DATA 		= date('d-m-Y', time());
$f = $p->salvaFile();  
$f->download();

?>
