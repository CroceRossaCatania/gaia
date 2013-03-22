<?php

/*
 * ©2013 Croce Rossa Italiana
 */

foreach ( Comitato::elenco() as $comitato ) {
  $presidenti = $comitato->membriAttuali(MEMBRO_PRESIDENTE);
  $pendenti = $comitato->appartenenzePendenti();
  $numPendenti = count($pendenti);
  foreach ( $presidenti as $presidente ) {
    $m = new Email('riepilogoPresidente','Riepilogo giornaliero pendenze su Gaia');
    $m->a = $presidente;
    $m-> _NOME = $presidente->nome;
    $m-> _COMITATO = $comitato->nome;
    $m->_APPPENDENTI = $numPendenti;
    $m->invia();
   }
}
?>