<?php

paginaPresidenziale();

controllaParametri(array('oid'));

$c = $_POST['oid'];
$c = GeoPolitica::daOid($c);

/* A che scheda tornare? Indice 0-based */ 
$back = null;

if(isset($_POST[date('Y') . '_benemerito'])) {
    $back = 'benemeriti';
    $oid = $c->oid();
    $anno = date('Y');
    $property = 'quota_' . $anno;
    $t = Tesseramento::by('anno', $anno);
    $nuova = (float) $_POST[date('Y') . '_benemerito'];
    if($t->stato == TESSERAMENTO_APERTO 
        and (float) $c->quotaBenemeriti() == (float) $t->benemerito
        and $nuova > (float) $t->benemerito) {
        $c->$property = $nuova;
    } else {
        redirect("presidente.comitato&errquota&oid={$oid}&back={$back}");
    }
}

if(isset($_POST['cancellaDelegato'])) {
    $back = 'obiettivi';
    $num = $_POST['cancellaDelegato'];
    $delega = $c->obiettivi_delegati($num)[0];
    $delega->dimettiDelegatoObiettivo($num);
}

/* Salvataggio obiettivi */
foreach ( $conf['obiettivi'] as $num => $nom ) {
    
    /* Se ho cambiato un obiettivo */
    if ( isset($_POST[$num] ) ) {
        
        /* Controllo se è il primo... */
        $vecchioDelegato = $c->obiettivi($num, true);
        $primo = (bool) $vecchioDelegato;
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
        
        $back = 'obiettivi';
        /* Crea il nuovo delegato */
        $d = new Delegato();
        $d->inizio      = time();
        $d->fine        = 0;
        $d->volontario  = $_POST[$num];
        $d->applicazione= APP_OBIETTIVO;
        $d->dominio     = $num;
        $d->comitato    = $c->oid();
        $d->pConferma   = $me->id;
        $d->tConferma   = time();
        $d->estensione  = $c->_estensione();
        
        /* Da fare: INVIA MAIL */
        $v = Volontario::id($_POST[$num]);
        $m = new Email('nuovoObiettivo', 'Delegato per ' . $nom);
        $m->a           = $v;
        $m->_NOME       = $v->nome;
        $m->_OBIETTIVO  = $nom;
        $m->_COMITATO   = $c->nomeCompleto();
        $m->invia();
            
        /* Se è il primo, crea apposita AREA */
        if ( $primo ) {
            $a = new Area();
            $a->comitato    = $c->oid();
            $a->obiettivo   = $num;
            $a->nome        = 'Generale';
            $a->responsabile= $v->id;
        } else {
            /* Il problema è che se è cambiato il delegato col cazzo che ribecco l'area.... */
            $vecchioDelegato = $vecchioDelegato[0]->id;
            /* Controllo se c'è l'area del precedente delegato */
            $area = Area::filtra([
                ['responsabile', $vecchioDelegato],
                ['comitato', $c->oid()],
                ['obiettivo', $num]
                ]);

            if (!$area) {
            /* Controllo se c'è almeno un'area con il nome Generale */
                $area = Area::filtra([
                ['comitato', $c->oid()],
                ['nome', 'Generale'],
                ['obiettivo', $num]
                ]);  
            } 
            if ($area) {
                $area = $area[0];
                $area->responsabile = $v->id;
            } else {
                /* Per compatibilità con le aree cancellate, se l'area non c'è più la ricreo*/
                $a = new Area();
                $a->comitato    = $c->oid();
                $a->obiettivo   = $num;
                $a->nome        = 'Generale';
                $a->responsabile= $v->id;
            }     
        }
    }
}

if(isset($_POST['cancellaProgetto'])) {
    $back = 'aree';
    $a = $_POST['cancellaProgetto'];
    $area = Area::id($a);
    $area->cancella();
}

if(isset($_POST['rimuoviReferente'])) {
    $back = 'aree';
    $a = $_POST['rimuoviReferente'];
    $area = Area::id($a);
    $area->dimettiReferente();
}

/* Creazione nuova area */
if ( isset($_POST['nuovaArea_volontario']) ) {
        
    $back = 'aree';

    $nome = normalizzaTitolo($_POST['nuovaArea_nome']);
    if ($nome == 'Generale') {
        $oid = $c->oid();
        redirect("presidente.comitato&errnome&oid={$oid}&back={$back}");
    }

    
    $a = new Area();
    $a->comitato    = $c->oid();
    $a->obiettivo   = (int) $_POST['nuovaArea_inputObiettivo'];
    $a->nome        = $nome;
    $a->responsabile= $_POST['nuovaArea_volontario'];
    
    $v = $a->responsabile();

    $m = new Email('responsabileArea', 'Responsabile per ' . $nom);
    $m->a           = $v;
    $m->_NOME       = $v->nome;
    $m->_AREA       = $a->nomeCompleto();
    $m->_COMITATO   = $c->nomeCompleto();
    $m->invia();

    $oid = $c->oid();
    redirect("presidente.comitato&ok&oid={$oid}&back={$back}");
       
}


/* Salvataggio aree */
foreach ( $c->aree() as $a ) {

    /* Salva nome variato */
    if (isset($_POST[$a->id . '_inputNome'])) {
        $back = 'aree';
        $nome = normalizzaNome($_POST[$a->id . '_inputNome']);
        if ($nome == 'Generale' || strlen($nome) < 3) {
            $oid = $c->oid();
            redirect("presidente.comitato&errnome&oid={$oid}&back={$back}");
        }
        $a->nome     = $nome;
    }
    
    /* Salva volontario variato */
    if (isset($_POST[$a->id . '_inputResponsabile'])) {
        
        $back = 'aree';
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

$oid = $c->oid();
redirect("presidente.comitato&ok&oid={$oid}&back={$back}");


