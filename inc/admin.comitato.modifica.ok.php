<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$c = $_POST['oid'];
$c = GeoPolitica::daOid($c);

paginaApp([APP_PRESIDENTE]);

$c->nome        =   normalizzaNome($_POST['inputNome']);

redirect('admin.comitati');

?>
