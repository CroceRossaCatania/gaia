<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$f = $_GET['id'];
$e = Estensione::by('id', $f);
$cest = $e->comitato();

$capp = $e->volontario()->unComitato();
$app = Appartenenza::filtra([
    ['volontario',  $e->volontario()->id],
    ['comitato',    $capp->id]
]);
$app = $app[0];

/* Modificando questo, modificare anche utente.estensione.ok */
$p = new PDF('estensione', 'Estensione.pdf');
$p->_COMITATOOUT = $capp->nomeCompleto();
$p->_COMITATOIN = $cest->nomeCompleto();
$p->_NOME = $e->volontario()->nome;
$p->_COGNOME = $e->volontario()->cognome;
$p->_LUOGO = $e->volontario()->comuneNascita;
$p->_DATA = date('d-m-Y', $e->volontario()->dataNascita);
$p->_ANNOCRI =$e->volontario()->ingresso()->format('d/m/Y');
$p->_MOTIVO = $e->motivo;
$p->_TIME = date('d-m-Y', $e->timestamp);
$f = $p->salvaFile();

if ( $sessione->inGenerazioneEstensione) {
    $sessione->inGenerazioneEstensione = null;
    
        /* Richiesta all'utente */
        $m = new Email('richiestaEstensione', 'Richiesta estensione: ' . $e->comitato()->nome);
        $m->a = $me;
        $m->_NOME       = $me->nome;
        $m->_COMITATO   = $cest->nomeCompleto();
        $m-> _TIME = date('d-m-Y', $e->timestamp);
        $m->allega($f);
        $m->invia();
        
         /* Richiesta per conoscenza al nuovo presidente */
        $m = new Email('richiestaEstensione.cc', 'Richiesta estensione in arrivo a: ' . $e->comitato()->nome);
        $m->a = $cest->unPresidente();
        $m->_NOME       = $me->nomeCompleto();
        $m->_COMITATO   = $cest->nomeCompleto();
        $m->_USCENTE = $capp->nomeCompleto();
        $m-> _TIME = date('d-m-Y', $e->timestamp);
        $m->allega($f);
        $m->invia();
       
        
    redirect('utente.estensione&ok');
} else {
    
    $f->download();

}
