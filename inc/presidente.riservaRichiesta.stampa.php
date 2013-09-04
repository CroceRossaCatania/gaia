<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$f = $_GET['id'];
$t = Riserva::by('id', $f);

$c = $t->volontario()->unComitato();
$app = Appartenenza::filtra([
    ['volontario',  $t->volontario()->id],
    ['comitato',    $c->id]
]);
$app = $app[0];

/* Modificando questo, modificare anche utente.trasferimento.ok */
$p = new PDF('riserva', 'Riserva.pdf');
$p->_COMITATO = $c->locale()->nome;
$p->_NOME = $t->volontario()->nome;
$p->_COGNOME = $t->volontario()->cognome;
$p->_LUOGO = $t->volontario()->comuneNascita;
$p->_DATA = date('d-m-Y', $t->volontario()->dataNascita);
$p->_ANNOCRI = date('d-m-Y', $app->inizio);
$p->_MOTIVO = $t->motivo;
$p->_INIZIO = date('d-m-Y', $t->inizio);
$p->_FINE = date('d-m-Y', $t->fine);
$p->_TIME = date('d-m-Y', $t->timestamp);
$f = $p->salvaFile();

if ( $sessione->inGenerazioneRiserva) {
    $sessione->inGenerazioneRiserva = null;
    
    /* Richiesta all'utente */
        $m = new Email('richiestaRiserva', 'Richiesta riserva');
        $m->a = $me;
        $m->_NOME       = $me->nome;
        $m-> _TIME = date('d-m-Y', $t->timestamp);
        $m->allega($f);
        $m->invia();
              
    redirect('utente.riserva&ok');
} else {
    
    $f->download();

}
