<?php

/*
 * ©2013 Croce Rossa Italiana
 */
if (isset($_GET['mass'])) {
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
      
            $mail= $_t->volontario()->email;
            $oggetto= $_POST['inputOggetto'];
            $testo = $_POST['inputTesto'];
            $mittente = $me->email;
            $nome=$me->nome;
            $cognome=$me->cognome;
            $header = "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html; charset=utf-8\r\n";
            $header .= 'From: "'.$nome.' '.$cognome.'" <'.$mittente.'> \r\n';
            mail($mail, $oggetto, $testo, $header); 
           
        }}}}}elseif($me->admin()){
                foreach ( $t as $_t ) {
                    
                $mail= $_t->volontario()->email;
                $oggetto= $_POST['inputOggetto'];
                $testo = $_POST['inputTesto'];
                $mittente = $me->email;
                $nome=$me->nome;
                $cognome=$me->cognome;
                $header = "MIME-Version: 1.0\r\n";
                $header .= "Content-type: text/html; charset=utf-8\r\n";
                $header .= 'From: "'.$nome.' '.$cognome.'" <'.$mittente.'> \r\n';
                mail($mail, $oggetto, $testo, $header);    
                
                }
            
        }
}else{

$mail= $_POST['inputMail'];
$oggetto= $_POST['inputOggetto'];
$testo = $_POST['inputTesto'];
$mittente = $me->email;
$nome=$me->nome;
$cognome=$me->cognome;
$header = "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html; charset=utf-8\r\n";
$header .= 'From: "'.$nome.' '.$cognome.'" <'.$mittente.'> \r\n';
mail($mail, $oggetto, $testo, $header);
}  
/*redirect('admin.inviaMail.inviata&ok');*/
?>