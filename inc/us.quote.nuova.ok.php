<?php

/*
 * ©2013 Croce Rossa Italiana
 */


$parametri = ['id', 'inputImporto', 'inputData'];
controllaParametri($parametri, 'us.dash&err');

$v = Volontario::id($_GET['id']);

proteggiDatiSensibili($v, [APP_SOCI , APP_PRESIDENTE]);

$importo = (float) $_GET['inputImporto'];
$importo = round($importo, 2);
if ($importo < QUOTA_ATTIVO) {
    redirect('us.quote.nuova&id='.$id.'&importo');
}

$app = $v->appartenenzaAttuale();

$anno = date('Y');

/* Controllo se gà vi è una quota pagata per l'anno in corso */
$gia = Quote::filtra([['appartenenza', $app],['anno', $anno]]);

if($gia){
	redirect('us.quoteNo&gia');
}

$time = DT::createFromFormat('d/m/Y', $_GET['inputData']);
$causale = 'Rinnovo quota '.$anno;

$q = new Quota();
$q->appartenenza = $app;
$q->timestamp = $time->getTimestamp();
$q->tConferma = time();
$q->pConferma = $me;
$q->anno = $anno;
$q->quota = $importo;
$q->causale = $causale;


$p = new PDF('ricevutaquota', 'ricevuta.pdf');
$p->_COMITATO = $app->comitato()->locale()->nomeCompleto();
$p->_INDIRIZZO = $app->comitato()->locale()->formattato;
$iva = PIVA;
$p->_PIVA = $iva;
$p->_ID = $q;
$p->_NOME = $v->nome;
$p->_COGNOME = $v->cognome;
$p->_FISCALE = $v->codiceFiscale;
$p->_NASCITA = date('d/m/Y', $v->dataNascita);
$p->_LUOGO = $v->luogoNascita;
$p->_QUOTA = $importo;
$p->_CAUSALE = $causale;
$p->_LUOGO = $app->comitato()->locale()->comune;
$p->_DATA = date('d-m-Y', time());
$f = $p->salvaFile();                                

/* Invio ricevuta all'utente */

$m = new Email('ricevutaQuota', 'Ricevuta versamento Quota');
$m->a = $v;
$m->da = $me;
$m->_NOME       = $v->nome;
$m->allega($f);
$m->invia();

redirect('us.quoteNo&ok');
    