<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.titoli&err');
$t = $_GET['id'];
$f = Titolo::id($t);
$tp = TitoloPersonale::filtra([['titolo', $f]]);
foreach ( $tp as $_tp ){
    $_tp->cancella();
}
$f->cancella();

redirect('admin.titoli&del');

?>
