<?php

/*
 * ©2012 Croce Rossa Italiana
 */

foreach ( Comitato::elenco() as $comitato ) {
  $presidenti = $comitato->membriAttuali(MEMBRO_PRESIDENTE);
  $pendenti = $comitato->appartenenzePendenti();
  $numPendenti = count($pendenti);
  foreach ( $presidenti as $presidente ) {
    $m = new Email('riepilogoPresidente','Riepilogo giornaliero pendenze su Gaia');
    $m->a = $presidente;
    $m->_APPPENDENTI = $numPendenti;
    $m->invia();
   }
}
?>