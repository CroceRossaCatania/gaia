<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

foreach ( $conf['dimissioni'] as $numero => $dimissioni ) {
    if ( $numero == DIM_QUOTA) { $motivo =  $dimissioni;} 
                    }
                    
$elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
        foreach($elenco as $comitato) {
            $t = $comitato->quoteNo();
            foreach ( $t as $_v ) {

$m = new Email('dimissionevolontario', 'Dimissione Volontario: ' . $_v->nomeCompleto());
$m->da = $me; 
$m->a = $_v->volontario();
$m->_NOME       = $_v->volontario()->nome;
$m-> _MOTIVO = $motivo;
$m-> _INFO = $_POST['info'];
$m->invia();
                
$d = new Dimissione();
$d->volontario = $_v->id;

$a = Appartenenza::filtra([['volontario', $_v]]);
$i = Delegato::filtra([['volontario',$_v]]);

foreach ($i as $_i){
    $b = Delegato::id($_i);
    $b->fine = time();   
}

foreach ( $a as $_a){
    if($_a->attuale()){
        $d->appartenenza = $_a;
        $d->comitato = $_a->comitato;
        $d->motivo = DIM_QUOTA;
        $d->tConferma = time();
        $d->pConferma = $me;
        $x = Appartenenza::id($_a);
        $x->fine = time();
        $x->stato = MEMBRO_DIMESSO;
        $f = Persona::id($_v);
        $f->stato = PERSONA;
        $f->admin='';
    }
}
            }
        }
redirect('us.quoteNo&close');   
?>