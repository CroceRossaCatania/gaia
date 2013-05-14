<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$a = $_GET['a'];
$h = $_GET['h'];

$c = new Commento();
$c->attivita = $a;
$c->commento = $_POST['inputCommento']; 
if($h != 0){
$h = $_GET['h'];
$c->upCommento = $h;
}else{
$c->upCommento = 0;
}
$c->volontario = $me;
$c->tCommenta = time();

redirect('attivita.pagina&a=' . $a);
