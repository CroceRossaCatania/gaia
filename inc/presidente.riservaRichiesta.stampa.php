<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('id'), 'presidente.riserva&err');

$f = $_GET['id'];
$t = Riserva::id($f);

$c = $t->volontario()->unComitato();
$app = $me->appartenenzaAttuale();

/* Modificando questo, modificare anche utente.trasferimento.ok */
$p = new PDF('riserva', 'Riserva.pdf');
$p->_COMITATO   = $c->locale()->nome;
$p->_NOME       = $t->volontario()->nome;
$p->_COGNOME    = $t->volontario()->cognome;
$p->_LUOGO      = $t->volontario()->comuneNascita;
$p->_DATA       = date('d/m/Y', $t->volontario()->dataNascita);
$p->_ANNOCRI    = $t->volontario()->ingresso()->format('d/m/Y');
$p->_MOTIVO     = $t->motivo;
$p->_INIZIO     = date('d/m/Y', $t->inizio);
$p->_FINE       = date('d/m/Y', $t->fine);
$p->_TIME       = date('d/m/Y', $t->timestamp);
$f = $p->salvaFile();

if ( $sessione->inGenerazioneRiserva) {
    $sessione->inGenerazioneRiserva = null;
    
    try{
        /* Richiesta all'utente */
        $m = new Email('richiestaRiserva', 'Richiesta riserva');
        $m->a       = $me;
        $m->_NOME   = $me->nome;
        $m->_TIME   = date('d/m/Y', $t->timestamp);
        $m->allega($f);
        $m->accoda();
    }catch(Exception $e){

    }

    try{
        /* Richiesta al presidente */
        $m = new Email('richiestaRiserva.presidente', 'Richiesta riserva da ' . $me->nomeCompleto);
        $m->a       = $c->unPresidente();
        $m->_NOME   = $me->nomeCompleto();
        $m->_MOTIVO = $t->motivo;
        $m->_TIME   = date('d/m/Y', $t->timestamp);
        $m->allega($f);
        $m->accoda();
    }catch(Exception $e){
        
    }
          
    redirect('utente.riserva&ok');
} else {
    
    $f->download();

}
