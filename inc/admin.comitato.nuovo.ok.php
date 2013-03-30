<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$c = new Comitato();
$c->nome = normalizzaNome( $_POST['inputNome'] );

redirect('admin.comitati&new');

?>
