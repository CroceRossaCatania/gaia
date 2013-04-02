<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$f = $_GET['id'];
$t = Trasferimento::by('id', $f);
$cin = $t->comitato();

$cout = $t->volontario()->unComitato();
$app = Appartenenza::filtra([
    ['volontario',  $t->volontario()->id],
    ['comitato',    $cout->id]
]);
$app = $app[0];

/* Modificando questo, modificare anche utente.trasferimento.ok */
$p = new PDF('trasferimento', 'Trasferimento.pdf');
$p->_COMITATOOUT = $cout->nome;
$p->_COMITATOIN = $cin->nome;
$p->_NOME = $t->volontario()->nome;
$p->_COGNOME = $t->volontario()->cognome;
$p->_LUOGO = $t->volontario()->comuneNascita;
$p->_DATA = date('d-m-Y', $t->volontario()->dataNascita);
$p->_ANNOCRI = date('d-m-Y', $app->inizio);
$p->_MOTIVO = $t->motivo;
$p->_TIME = date('d-m-Y', time());
$f = $p->salvaFile();

if ( $sessione->inGenerazioneTrasferimento) {
    
    /* Richiesta all'utente */
        $m = new Email('richiestaTrasferimento', 'Richiesta trasferimento: ' . $t->comitato()->nome);
        $m->a = $me;
        $m->_NOME       = $me->nome;
        $m->_COMITATO   = $t->comitato()->nome;
        $m-> _TIME = date('d-m-Y', $t->timestamp);
        $m->allega($f);
        $m->invia();
        
         /* Richiesta per conoscenza al nuvo presidente */
        $m = new Email('richiestaTrasferimento.cc', 'Richiesta trasferimento in arrivo a: ' . $t->comitato()->nome);
        $m->a = $t->comitato()->unPresidente();
        $m->_NOME       = $me->nomeCompleto();
        $m->_COMITATO   = $t->comitato()->nome;
        $m->_USCENTE = $cout->nome;
        $m-> _TIME = date('d-m-Y', $t->timestamp);
        $m->allega($f);
        $m->invia();
       
        
    redirect('utente.trasferimento&ok');
} else {
    
    $f->download();

}
