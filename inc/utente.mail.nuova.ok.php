<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$v = utente::by('email', $_POST['inputMail']);
$oggetto= $_POST['inputOggetto']; 
$testo = $_POST['inputTesto'];

if (isset($_GET['unit'])) {
        $c = $_GET['id'];
        $c = Comitato::id($c);
        $t = $c->membriAttuali(MEMBRO_VOLONTARIO);
        foreach($t as $_t){
            $m = new Email('mailTestolibero', ''.$oggetto);
            $m->da = $me; 
            $m->a = $_t;
            $m->_TESTO = $testo;
            $m->invia();
         }

}elseif (isset($_GET['com'])) {
$elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
        foreach($elenco as $comitato) {
            $t = $comitato->membriAttuali(MEMBRO_VOLONTARIO);
            foreach($t as $_t){
                $m = new Email('mailTestolibero', $oggetto);
                $m->da = $me; 
                $m->a = $_t;
                $m->_TESTO = $testo;
                $m->invia();
         }
     }
}elseif (isset($_GET['mass'])) {
$f = $_GET['t'];
$f= Titolo::id($f);
foreach($me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE, APP_OBIETTIVO ]) as $elenco){
      $volontari =  $elenco->ricercaMembriTitoli([$f]);
            foreach($volontari as $volontario){
                $m = new Email('mailTestolibero', $oggetto);
                $m->a= $volontario;
                $m->da = $me;
                $m->_TESTO = $testo;
                $m->invia();
            }
    }
    redirect('utente.me&mass');   
}elseif(isset($_GET['supp'])){
    $text = strip_tags($testo);                 
    if (strlen($text) < 10) {
        redirect('utente.supporto&len');    
    }

    $m = new Email('mailSupporto', 'Richiesta supporto: '.$oggetto);
    $m->da = $me;
    $m->_TESTO = $testo;
    $m->_STATO = $conf['statoPersona'][$me->stato];
    $m->_NOME = $me->nomeCompleto();
    $m->_ID = $me->id;
    $comitato = $me->unComitato();
    if ($comitato) {
        $comitato = $comitato->nomeCompleto();
    } else {
        $comitato = 'nessun comitato assegnato';
    }
    $m->_APP = $comitato;
    $m->invia();
    redirect('utente.me&suppok');    

}elseif (isset($_GET['comgio'])) {
$elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
        foreach($elenco as $comitato) {
            $t = $comitato->membriAttuali(MEMBRO_VOLONTARIO);
            foreach($t as $_t){
                if ($_t->giovane()){
                $m = new Email('mailTestolibero', ''.$oggetto);
                $m->da = $me; 
                $m->a = $_t;
                $m->_TESTO = $testo;
                $m->invia();
                }
         }
     }
     
}elseif (isset($_GET['unitgio'])) {
        $c = $_GET['id'];
        $c = Comitato::id($c);
        $t = $c->membriAttuali(MEMBRO_VOLONTARIO);
        foreach($t as $_t){
            if ($_t->giovane()){
            $m = new Email('mailTestolibero', ''.$oggetto);
            $m->da = $me; 
            $m->a = $_t;
            $m->_TESTO = $testo;
            $m->invia();
            }
         }

}elseif (isset($_GET['comquoteno'])) {
$elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
        foreach($elenco as $comitato) {
            $t = $comitato->quoteNo();
            foreach($t as $_t){
                $m = new Email('mailTestolibero', ''.$oggetto);
                $m->da = $me; 
                $m->a = $_t;
                $m->_TESTO = $testo;
                $m->invia();
         }
     }
}elseif (isset($_GET['comquotesi'])) {
$elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
        foreach($elenco as $comitato) {
            $t = $comitato->quoteSi();
            foreach($t as $_t){
                $m = new Email('mailTestolibero', ''.$oggetto);
                $m->da = $me; 
                $m->a = $_t;
                $m->_TESTO = $testo;
                $m->invia();
         }
     }
}elseif (isset($_GET['unitquoteno'])) {
        $c = $_GET['id'];
        $c = Comitato::id($c);
        $t = $c->quoteNo();
        foreach($t as $_t){
            $m = new Email('mailTestolibero', ''.$oggetto);
            $m->da = $me; 
            $m->a = $_t;
            $m->_TESTO = $testo;
            $m->invia();
         }

}elseif (isset($_GET['unitquotesi'])) {
        $c = $_GET['id'];
        $c = Comitato::id($c);
        $t = $c->quoteNo();
        foreach($t as $_t){
            $m = new Email('mailTestolibero', ''.$oggetto);
            $m->da = $me; 
            $m->a = $_t;
            $m->_TESTO = $testo;
            $m->invia();
         }

}elseif (isset($_GET['comeleatt'])) {
$elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
        foreach($elenco as $comitato) {
            $time = $_GET['time'];
            $time = DT::daTimestamp($time);
            $t = $comitato->elettoriAttivi($time);
            foreach($t as $_t){
                $m = new Email('mailTestolibero', ''.$oggetto);
                $m->da = $me; 
                $m->a = $_t;
                $m->_TESTO = $testo;
                $m->invia();
         }
     }
}elseif (isset($_GET['comelepass'])) {
$elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
        foreach($elenco as $comitato) {
            $time = $_GET['time'];
            $time = DT::daTimestamp($time);
            $t = $comitato->elettoriPassivi($time);
            foreach($t as $_t){
                $m = new Email('mailTestolibero', ''.$oggetto);
                $m->da = $me; 
                $m->a = $_t;
                $m->_TESTO = $testo;
                $m->invia();
         }
     }
}elseif (isset($_GET['uniteleatt'])) {
        $c = $_GET['id'];
        $c = Comitato::id($c);
        $time = $_GET['time'];
        $time = DT::daTimestamp($time);
        $t = $c->elettoriAttivi($time);
        foreach($t as $_t){
            $m = new Email('mailTestolibero', ''.$oggetto);
            $m->da = $me; 
            $m->a = $_t;
            $m->_TESTO = $testo;
            $m->invia();
         }

}elseif (isset($_GET['unitelepass'])) {
        $c = $_GET['id'];
        $c = Comitato::id($c);
        $time = $_GET['time'];
        $time = DT::daTimestamp($time);
        $t = $c->elettoriPassivi($time);
        foreach($t as $_t){
            $m = new Email('mailTestolibero', ''.$oggetto);
            $m->da = $me; 
            $m->a = $_t;
            $m->_TESTO = $testo;
            $m->invia();
         }

}elseif (isset($_GET['gruppo'])) {
        $g = $_GET['id'];
        $g = Gruppo::id($g);
        $v = $g->membri();
        foreach($v as $_v){
            $m = new Email('mailTestolibero', ''.$oggetto);
            $m->da = $me; 
            $m->a = $_v;
            $m->_TESTO = $testo;
            $m->invia();
         }

}elseif (isset($_GET['estesi'])) {
        $g = $_GET['id'];
        $comitato = Comitato::id($g);
        $estesi = array_diff( $comitato->membriAttuali(MEMBRO_ESTESO), $comitato->membriAttuali(MEMBRO_VOLONTARIO) );
        foreach($estesi as $_v){
            $m = new Email('mailTestolibero', ''.$oggetto);
            $m->da = $me; 
            $m->a = $_v;
            $m->_TESTO = $testo;
            $m->invia();
         }

}elseif (isset($_GET['riserva'])) {
        $g = $_GET['id'];
        $comitato = Comitato::id($g);
        $r = $comitato->membriRiserva();
        foreach($r as $_v){
            $m = new Email('mailTestolibero', ''.$oggetto);
            $m->da = $me; 
            $m->a = $_v;
            $m->_TESTO = $testo;
            $m->invia();
         }

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
                $m->invia();
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
            $m->invia();
        }
    }

}else{

$m = new Email('mailTestolibero', ''.$oggetto);
$m->da = $me; 
$m->a = $v;
$m->_TESTO = $testo;
$m->invia();    

}  

redirect('utente.me&ok');
?>