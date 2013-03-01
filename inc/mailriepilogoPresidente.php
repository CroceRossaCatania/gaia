<?php

/*
 * ©2012 Croce Rossa Italiana
 */

foreach ( Comitato::lista() as $comitato ) {
  $presidenti = $comitato->membriAttuali(MEMBRO_PRESIDENTE);
  $pendenti = $comitato->membriPendenti();
  $numPendenti = count($pendenti);
  foreach ( $presidenti as $presidente ) {
    $m = new Email('riepilogoPresidente','Riepilogo giornaliero pendenze su Gaia');
    $m->a = $presidente;
    $m->_apppendenti = $pendenti;
    $m->invia();
   }
}
?>