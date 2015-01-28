<?php

/*
* ©2013 Croce Rossa Italiana
*/

paginaPrivata();
if (isset($_POST['inputDestinatario'])) {
    $id = $_POST['inputDestinatario'];
    $v = utente::id($id);
}

$oggetto= $_POST['inputOggetto']; 
$testo = $_POST['inputTesto'];

if (isset($_GET['unit'])) {
    $c = $_GET['id'];
    $c = Comitato::id($c);
    $v = $c->membriAttuali(MEMBRO_VOLONTARIO);
    $m = new Email('mailTestolibero', ''.$oggetto);
    $m->da = $me; 
    $m->a = $v;
    $m->_TESTO = $testo;
    $m->accoda();


} elseif(isset($_GET['com'])) {
    $elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
    $v = [];
    foreach($elenco as $comitato) {
        $v = array_merge($v, $comitato->membriAttuali());
    }
    if(!$v) { redirect('utente.me&nodest'); }
    $m = new Email('mailTestolibero', $oggetto);
    $m->da = $me; 
    $m->a = $v;
    $m->_TESTO = $testo;
    $m->accoda();
} elseif(isset($_GET['mass'])) {
    $f = $_GET['t'];
    $f= Titolo::id($f);
    $v = [];
    foreach($me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE, APP_OBIETTIVO ]) as $elenco){
        $v = array_merge($v, $elenco->ricercaMembriTitoli([$f]));
    }
    if(!$v) { redirect('utente.me&nodest'); }
    $m = new Email('mailTestolibero', $oggetto);
    $m->a = $v;
    $m->da = $me;
    $m->_TESTO = $testo;
    $m->accoda();
    redirect('utente.me&mass');   
} elseif(isset($_GET['supp'])){
    $text = strip_tags($testo);                 
    if (strlen($text) < 10) {
        redirect('utente.supporto&len');    
    }
    //se ho un volontario per cui richiedere la cosa
    if (isset($_POST['inputVolontario'])) {
        //inserisco i dati del richiedente
        $m = new Email('mailSupportoDaUfficio', 'Richiesta supporto: '.$oggetto);
        $m->da = $me;
        $m->_TESTO = $testo;
        $m->_STATO = $conf['statoPersona'][$me->stato];
        $m->_NOME = $me->nomeCompleto();
        $m->_ID = $me->id;
        $comitato = $me->unComitato();
        if ($comitato) {
            $comitato = $comitato->nomeCompleto();
        } else {
            $comitato = 'nessun comitato assegnato o volontario in attesa di conferma';
        }
        $m->_APP = $comitato;
        $d = $me->delegazioneAttuale();
        if($d) {
            $g = GeoPolitica::daOid($d->comitato);
            $nome = "{$g->nome}";
            if ($g->_estensione() == EST_UNITA) {
                $nome = "Unità {$g->nome}";
            }
            if ($d->applicazione == APP_OBIETTIVO) {
                $ruolo = "Delegato {$conf['nomiobiettivi'][$d->dominio]}: {$nome}";   
            } else {
                $ruolo = "{$conf['applicazioni'][$d->applicazione]}: {$nome}";    
            }
            $m->_DELEGA = $ruolo;
        } else {
            $m->_DELEGA = "Il volontario non ha deleghe o non ne sta usando nessuna";
        }
        $m->_BROSWER = $_SERVER['HTTP_USER_AGENT'] . "\n\n";
        //inserisco i dati del volontari per cui è richiesta assistenza
        $u = Utente::id($_POST['inputVolontario']);
        $m->_VSTATO = $conf['statoPersona'][$u->stato];
        $m->_VNOME = $u->nomeCompleto();
        $m->_VID = $u->id;
        $comitato = $u->unComitato();
        if ($comitato) {
            $comitato = $comitato->nomeCompleto();
        } else {
            $comitato = 'nessun comitato assegnato o volontario in attesa di conferma';
        }
        $m->_VAPP = $comitato;

        $m->invia();
        redirect('utente.me&suppok');
    }

    $m = new Email('mailSupporto', 'Richiesta supporto: '.$oggetto);
    $m->da = $me;
    $m->_TESTO = $testo;
    $m->_STATO = $conf['statoPersona'][$me->stato];
    $m->_NOME = $me->nomeCompleto();
    $m->_ID = $me->id;
    if ($comitato = $me->unComitato()) {
        $comitato = ''.$comitato->nomeCompleto().' - membro volontario';
    } else if($comitato = $me->unComitato(MEMBRO_PENDENTE)) {
        $comitato = ''.$comitato->nomeCompleto().' - membro pendente';
    } else {
        $comitato = 'nessun comitato assegnato';
    }
    $m->_APP = $comitato;
    $d = $me->delegazioneAttuale();
    if($d) {
        $g = GeoPolitica::daOid($d->comitato);
        $nome = "{$g->nome}";
        if ($g->_estensione() == EST_UNITA) {
            $nome = "Unità {$g->nome}";
        }
        if ($d->applicazione == APP_OBIETTIVO) {
            $ruolo = "Delegato {$conf['nomiobiettivi'][$d->dominio]}: {$nome}";   
        } else {
            $ruolo = "{$conf['applicazioni'][$d->applicazione]}: {$nome}";    
        }
        $m->_DELEGA = $ruolo;
    } else {
        $m->_DELEGA = "Il volontario non ha deleghe o non ne sta usando nessuna";
    }
    $m->_BROSWER = $_SERVER['HTTP_USER_AGENT'] . "\n\n";
    $m->invia();
    redirect('utente.me&suppok');    

}elseif (isset($_GET['comgio'])) {
    $elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE, APP_OBIETTIVO ]);
    $v = [];
    foreach($elenco as $comitato) {
        $v = array_merge($v, $comitato->membriGiovani());
    }
    if(!$v) { redirect('utente.me&nodest'); }
    $m = new Email('mailTestolibero', ''.$oggetto);
    $m->da = $me; 
    $m->a = $v;
    $m->_TESTO = $testo;
    $m->accoda();

}elseif (isset($_GET['unitgio'])) {
    $c = $_GET['id'];
    $c = Comitato::id($c);
    $g = $c->membriGiovani();
    $m = new Email('mailTestolibero', ''.$oggetto);
    $m->da = $me; 
    $m->a = $g;
    $m->_TESTO = $testo;
    $m->accoda();

}elseif (isset($_GET['comquoteno'])) {
    $anno = date('Y');
    $elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
    $v = [];
    foreach($elenco as $comitato) {
        $v = array_merge($v, $comitato->quoteNo($anno));
    }
    if(!$v) { redirect('utente.me&nodest'); }
    $m = new Email('mailTestolibero', ''.$oggetto);
    $m->da = $me; 
    $m->a = $v;
    $m->_TESTO = $testo;
    $m->accoda();

} elseif (isset($_GET['comquotenoordinari'])) {
    $questanno = $anno = date('Y');
    $elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
    $v = [];
    foreach($elenco as $comitato) {
        $v = array_merge($v, $comitato->quoteNo($anno, MEMBRO_ORDINARIO));
    }
    if(!$v) { redirect('utente.me&nodest'); }
    $m = new Email('mailTestolibero', ''.$oggetto);
    $m->da = $me; 
    $m->a = $v;
    $m->_TESTO = $testo;
    $m->accoda();

} elseif (isset($_GET['unitquoteno'])) {
    $anno = date('Y');
    if (!isset($_GET['id'])) {
        redirect('us.quoteNo');
    }
    $c = $_GET['id'];
    $c = Comitato::id($c);
    $v = $c->quoteNo($anno);
    $m = new Email('mailTestolibero', ''.$oggetto);
    $m->da = $me; 
    $m->a = $v;
    $m->_TESTO = $testo;
    $m->accoda();

} elseif (isset($_GET['unitquotenoordinari'])) {
    $anno = date('Y');
    if (!isset($_GET['id'])) {
        redirect('us.quoteNo');
    }
    $c = $_GET['id'];
    $c = Comitato::id($c);
    $v = $c->quoteNo($anno, MEMBRO_ORDINARIO);
    $m = new Email('mailTestolibero', ''.$oggetto);
    $m->da = $me; 
    $m->a = $v;
    $m->_TESTO = $testo;
    $m->accoda();

} elseif(isset($_GET['comeleatt'])) {
    $elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
    $v = [];
    foreach($elenco as $comitato) {
        $time = $_GET['time'];
        $time = DT::daTimestamp($time);
        $v = array_merge($v, $comitato->elettoriAttivi($time));
    }
    if(!$v) { redirect('utente.me&nodest'); }
    $m = new Email('mailTestolibero', ''.$oggetto);
    $m->da = $me; 
    $m->a = $v;
    $m->_TESTO = $testo;
    $m->accoda();

} elseif(isset($_GET['comelepass'])) {
    $elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
    $v = [];
    foreach($elenco as $comitato) {
        $time = $_GET['time'];
        $time = DT::daTimestamp($time);
        $v = array_merge($v, $comitato->elettoriPassivi($time));
    }
    if(!$v) { redirect('utente.me&nodest'); }
    $m = new Email('mailTestolibero', ''.$oggetto);
    $m->da = $me; 
    $m->a = $v;
    $m->_TESTO = $testo;
    $m->accoda();

} elseif(isset($_GET['uniteleatt'])) {
    $c = $_GET['id'];
    $c = Comitato::id($c);
    $time = $_GET['time'];
    $time = DT::daTimestamp($time);
    $v = $c->elettoriAttivi($time);
    $m = new Email('mailTestolibero', ''.$oggetto);
    $m->da = $me; 
    $m->a = $v;
    $m->_TESTO = $testo;
    $m->accoda();

} elseif(isset($_GET['unitelepass'])) {
    $c = $_GET['id'];
    $c = Comitato::id($c);
    $time = $_GET['time'];
    $time = DT::daTimestamp($time);
    $v = $c->elettoriPassivi($time);
    $m = new Email('mailTestolibero', ''.$oggetto);
    $m->da = $me; 
    $m->a = $v;
    $m->_TESTO = $testo;
    $m->accoda();

} elseif(isset($_GET['gruppo'])) {
    $g = $_GET['id'];
    $g = Gruppo::id($g);
    $v = $g->membri();
    $m = new Email('mailTestolibero', ''.$oggetto);
    $m->da = $me; 
    $m->a = $v;
    $m->_TESTO = $testo;
    $m->accoda();

} elseif(isset($_GET['estesi'])) {
    $g = $_GET['id'];
    $comitato = Comitato::id($g);
    $estesi = array_diff( $comitato->membriAttuali(MEMBRO_ESTESO), $comitato->membriAttuali(MEMBRO_VOLONTARIO) );
    $m = new Email('mailTestolibero', ''.$oggetto);
    $m->da = $me; 
    $m->a = $estesi;
    $m->_TESTO = $testo;
    $m->accoda();

} elseif(isset($_GET['estensione'])) {
    $g = $_GET['id'];
    $comitato = Comitato::id($g);
    $estensione = $comitato->membriInEstensione();
    foreach ( $estensione as $esteso ){   
        $v = $esteso->volontario();
        $m = new Email('mailTestolibero', ''.$oggetto);
        $m->da = $me; 
        $m->a = $v;
        $m->_TESTO = $testo;
        $m->accoda();
    }

}elseif (isset($_GET['riserva'])) {
    $g = $_GET['id'];
    $comitato = Comitato::id($g);
    $v = $comitato->membriRiserva();
    $m = new Email('mailTestolibero', ''.$oggetto);
    $m->da = $me; 
    $m->a = $v;
    $m->_TESTO = $testo;
    $m->accoda();

}elseif (isset($_GET['zeroturnicom'])) {
    $anno = date('Y', $_GET['time']);
    $mese = date('m', $_GET['time']);
    $inizio = mktime(0, 0, 0, $mese, 1, $anno);
    $giorno = cal_days_in_month(CAL_GREGORIAN, $mese, $anno);
    $fine = mktime(0, 0, 0, $mese, $giorno, $anno);
    $comitati = $me->comitatiApp (APP_PRESIDENTE);
    foreach($comitati as $comitato){
        $volontari = $comitato->membriAttuali();
        foreach($volontari as $v){
            $partecipazioni = $v->partecipazioni();
            $x=0;
            foreach ($partecipazioni as $part){
                if ($x==0){
                    if ( $part->turno()->inizio >= $inizio && $part->turno()->fine <= $fine ){
                        $auts = $part->autorizzazioni();
                        if ($auts[0]->stato == AUT_OK){
                            $x=1;
                        }
                        $turno = $part->turno();
                        $co = Coturno::filtra([['turno', $turno],['volontario', $v]]);
                        if ($co){
                            $x=1;
                        }
                    }
                }
            }

            if ( $x==0 ){
                $m = new Email('mailTestolibero', ''.$oggetto);
                $m->da = $me; 
                $m->a = $v;
                $m->_TESTO = $testo;
                $m->accoda();
            }
        }
    }

}elseif (isset($_GET['zeroturnicom'])) {
    $anno = date('Y', $_GET['time']);
    $mese = date('m', $_GET['time']);
    $inizio = mktime(0, 0, 0, $mese, 1, $anno);
    $giorno = cal_days_in_month(CAL_GREGORIAN, $mese, $anno);
    $fine = mktime(0, 0, 0, $mese, $giorno, $anno);
    $comitato = $_GET['id'];
    $comitato = new Comitato($comitato);
    $volontari = $comitato->membriAttuali();
    foreach($volontari as $v){
        $partecipazioni = $v->partecipazioni();
        $x=0;
        foreach ($partecipazioni as $part){
            if ($x==0){
                if ( $part->turno()->inizio >= $inizio && $part->turno()->fine <= $fine ){
                    $auts = $part->autorizzazioni();
                    if ($auts[0]->stato == AUT_OK){
                        $x=1;
                    }
                    $turno = $part->turno();
                    $co = Coturno::filtra([['turno', $turno],['volontario', $v]]);
                    if ($co){
                        $x=1;
                    }
                }
            }
        }

        if ( $x==0 ){
            $m = new Email('mailTestolibero', ''.$oggetto);
            $m->da = $me; 
            $m->a = $v;
            $m->_TESTO = $testo;
            $m->accoda();
        }
    }

} elseif(isset($_GET['ordinaricom'])) {
    $comitati = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
    $v = [];
    foreach($comitati as $comitato){
        $v = array_merge($v, $comitato->membriOrdinari());
    }
    if(!$v) { redirect('utente.me&nodest'); }
    foreach ($v as $_v){
        try {
              $m = new Email('mailTestolibero', ''.$oggetto);
              $m->da = $me; 
              $m->a = $_v; 
              $m->_TESTO = $testo;
              $m->accoda();
            } catch ( Errore $e ) {
              // Questo volontario non ha email, non faccio niente...
            }
    }
} elseif(isset($_GET['ordinariunit'])) {
    $c = $_GET['id'];
    $c = Comitato::id($c);
    $volontari = $c->membriOrdinari();
    $m = new Email('mailTestolibero', ''.$oggetto);
    $m->da = $me; 
    $m->a = $volontari;
    $m->_TESTO = $testo;
    $m->accoda();

} elseif(isset($_GET['ordinaridimessiunit'])) {
    $c = $_GET['id'];
    $c = Comitato::id($c);
    $volontari = $c->membriOrdinariDimessi();
    $m = new Email('mailTestolibero', ''.$oggetto);
    $m->da = $me; 
    $m->a = $volontari;
    $m->_TESTO = $testo;
    $m->accoda();

} elseif(isset($_GET['ordinaridimessicom'])) {
    $comitati = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
    $v = [];
    foreach($comitati as $comitato){
        $v = array_merge($v, $comitato->membriOrdinariDimessi());
    }
    if(!$v) { redirect('utente.me&nodest'); }
    $m = new Email('mailTestolibero', ''.$oggetto);
    $m->da = $me; 
    $m->a = $v;
    $m->_TESTO = $testo;
    $m->accoda();

} else {

    $m = new Email('mailTestolibero', ''.$oggetto);
    $m->da = $me; 
    $m->a = $v;
    $m->_TESTO = $testo;
    $m->accoda();    

}  

redirect('utente.me&ok');
