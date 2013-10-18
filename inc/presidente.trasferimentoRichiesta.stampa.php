<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$f = $_GET['id'];
$t = Trasferimento::id($f);
$cin = $t->comitato();

$cout = Comitato::id($t->cProvenienza);
$app = Appartenenza::filtra([
    ['volontario',  $t->volontario()->id],
    ['comitato',    $cout->id]
]);
$app = $app[0];

/* Modificando questo, modificare anche utente.trasferimento.ok */
$p = new PDF('trasferimento', 'Trasferimento.pdf');
$p->_COMITATOOUT = $cout->locale()->nomeCompleto();
$p->_COMITATOIN = $cin->nomeCompleto();
$p->_COMITATOC = $cout->nomeCompleto();
$p->_NOME = $t->volontario()->nome;
$p->_COGNOME = $t->volontario()->cognome;
$p->_LUOGO = $t->volontario()->comuneNascita;
$p->_DATA = date('d/m/Y', $t->volontario()->dataNascita);
$p->_ANNOCRI =$t->volontario()->ingresso()->format('d/m/Y');
$p->_MOTIVO = $t->motivo;
$p->_TIME = date('d/m/Y', $t->timestamp);
$f = $p->salvaFile();

if ( $sessione->inGenerazioneTrasferimento) {
    $sessione->inGenerazioneTrasferimento = null;
    
    /* Richiesta all'utente */
        $m = new Email('richiestaTrasferimento', 'Richiesta trasferimento: ' . $t->comitato()->nome);
        $m->a = $me;
        $m->_NOME       = $me->nome;
        $m->_COMITATO   = $t->comitato()->nomeCompleto();
        $m-> _TIME = date('d/m/Y', $t->timestamp);
        $m->allega($f);
        $m->invia();
        
         /* Richiesta per conoscenza al nuovo presidente */
        $m = new Email('richiestaTrasferimento.cc', 'Richiesta trasferimento in arrivo a: ' . $t->comitato()->nome);
        $m->a = $t->comitato()->unPresidente();
        $m->_NOME       = $me->nomeCompleto();
        $m->_COMITATO   = $t->comitato()->nomeCompleto();
        $m->_USCENTE = $cout->nomeCompleto();
        $m-> _TIME = date('d/m/Y', $t->timestamp);
        $m->allega($f);
        $m->invia();
       
        
    redirect('utente.trasferimento&ok');
} else {
    
    $f->download();

}
