<?php

paginaPresidenziale();

$c = $_POST['oid'];
$c = GeoPolitica::daOid($c);

/* A che scheda tornare? Indice 0-based */ 
$back = null;

/* Salvataggio obiettivi */
foreach ( $conf['obiettivi'] as $num => $nom ) {
    
    /* Se ho cambiato un obiettivo */
    if ( isset($_POST[$num] ) ) {
        
        /* Controllo se è il primo... */
        $primo = (bool) $c->obiettivi($num);
        $primo = !$primo;
        
        /* Se non è il primo */
        if ( !$primo ) {
            
            /* 
             * Termina delegati precedenti... 
             * Plurale per funzionare da hotfix per issue #176
             */
            foreach ( $c->obiettivi_delegati($num) as $del ) {
                $del->fine = time();
            }
            
        }
        
        $back = 0;
        /* Crea il nuovo delegato */
        $d = new Delegato();
        $d->inizio      = time();
        $d->fine        = 0;
        $d->volontario  = $_POST[$num];
        $d->applicazione= APP_OBIETTIVO;
        $d->dominio     = $num;
        $d->comitato    = $c->id;
        $d->pConferma   = $me->id;
        $d->tConferma   = time();
        $d->estensione  = $c->_estensione();
        
        /* Da fare: INVIA MAIL */
        $v = new Volontario($_POST[$num]);
        $m = new Email('nuovoObiettivo', 'Delegato per ' . $nom);
        $m->a           = $v;
        $m->_NOME       = $v->nome;
        $m->_OBIETTIVO  = $nom;
        $m->_COMITATO   = $c->nomeCompleto();
        $m->invia();
            
        /* Se è il primo, crea apposita AREA */
        if ( $primo && $c instanceOf Comitato ) {
            $a = new Area();
            $a->comitato    = $c->id;
            $a->obiettivo   = $num;
            $a->nome        = 'Generale';
            $a->responsabile= $v->id;
        }
            
    }
}


/* Salvataggio aree */
if ( $c instanceOf Comitato ) { 
    foreach ( $c->aree() as $a ) {
        
        /* Salva obiettivo variato */
        if (isset($_POST[$a->id . '_inputObiettivo'])) {
            $a->obiettivo = $_POST[$a->id . '_inputObiettivo'];
        }

        /* Salva nome variato */
        if (isset($_POST[$a->id . '_inputNome'])) {
            $a->nome     = normalizzaNome($_POST[$a->id . '_inputNome']);
        }
        
        /* Salva volontario variato */
        if (isset($_POST[$a->id . '_inputResponsabile'])) {
            
            $back = 2;$
            $v = new Volontario($_POST[$a->id . '_inputResponsabile']);
            $a->responsabile = $v->id;
            
            $m = new Email('responsabileArea', 'Responsabile per ' . $nom);
            $m->a           = $v;
            $m->_NOME       = $v->nome;
            $m->_AREA       = $a->nomeCompleto();
            $m->_COMITATO   = $c->nomeCompleto();
            $m->invia();
       
        }
        
    }
}

/* Creazione nuova area */
if ( isset($_POST['nuovaArea']) ) {
        
    $back = 2;
    $a = new Area();
    $a->comitato    = $c->id;
    $a->obiettivo   = OBIETTIVO_1;
    $a->nome        = 'NUOVA AREA SENZA NOME';
    $a->responsabile= $me->id;
    
}

$oid = $c->oid();
redirect("presidente.comitato&ok&oid={$oid}&back={$back}");