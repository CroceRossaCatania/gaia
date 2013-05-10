<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$v = utente::by('email', $_POST['inputMail']);
$oggetto= $_POST['inputOggetto']; 
$testo = $_POST['inputTesto'];

if (isset($_GET['com'])) {
$elenco = $me->comitatiDiCompetenza();
        foreach($elenco as $comitato) {
            $t = $comitato->membriAttuali(MEMBRO_VOLONTARIO);
            foreach($t as $_t){
                $m = new Email('mailTestolibero', ''.$oggetto);
                $m->da = $me; 
                $m->a = $_t;
                $m->_TESTO = $testo;
                $m->invia();
         }
     }
}elseif (isset($_GET['mass'])) {
$f = $_GET['t'];
$t = TitoloPersonale::filtra([['titolo',$f]]);
if($me->presiede()){
  foreach($me->presidenziante() as $appartenenza){
             $c=$appartenenza->comitato()->id;     
  foreach ( $t as $_t ) { 
      $a=$_t->volontario()->id;
      $a = Appartenenza::filtra([['volontario',$a],['comitato',$c]]);
      if($a[0]!=''){
        if($_t->pConferma!=''){    
            
            $m = new Email('mailTestolibero', ''.$oggetto);
            $m->da = $me; 
            $m->a = $_t->volontario();
            $m->_TESTO = $testo;
            $m->invia();
                      
           
        }}}}}elseif($me->admin()){
                foreach ( $t as $_t ) {
                  if($_t->pConferma!=''){
                      
                    $m = new Email('mailTestolibero', ''.$oggetto);
                    $m->da = $me; 
                    $m->a = $_t->volontario();
                    $m->_TESTO = $testo;
                    $m->invia();
                
                  }}
            
        }
}elseif(isset($_GET['supp'])){

$m = new Email('mailTestolibero', 'Richiesta supporto: '.$oggetto);
$m->da = $me;
$m->_TESTO = $testo;
$m->invia();
redirect('utente.me&suppok');    
}else{

$m = new Email('mailTestolibero', ''.$oggetto);
$m->da = $me; 
$m->a = $v;
$m->_TESTO = $testo;
$m->invia();    

}  

redirect('utente.me&ok');
?>