<?php

/*
 * ©2013 Croce Rossa Italiana
 */
paginaApp([APP_SOCI , APP_PRESIDENTE]);

controllaParametri(array('id'), 'us.dash&err');

$q = $_GET['id'];
$app = Quota::id($q);
$p = new PDF('ricevutaquota', 'ricevuta.pdf');
$p->_COMITATO = $app->comitato()->locale()->nomeCompleto();
$p->_INDIRIZZO = $app->comitato()->locale()->formattato;
$iva = $app->comitato()->locale()->piva();
$p->_PIVA = $iva;
$p->_ID = $app->id;
$p->_NOME = $app->volontario()->nome;
$p->_COGNOME = $app->volontario()->cognome;
$p->_FISCALE = $app->volontario()->codiceFiscale;
$p->_NASCITA = date('d/m/Y', $app->volontario()->dataNascita);
$p->_LUOGO = $app->volontario()->luogoNascita;
$p->_QUOTA = $app->quota;
$p->_CAUSALE = $app->causale;
$p->_LUOGO = $app->comitato()->locale()->comune;
$p->_DATA = date('d-m-Y', $app->timestamp);
$f = $p->salvaFile();  
$f->download();

?>
