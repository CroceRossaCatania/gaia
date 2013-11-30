<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPresidenziale();

$t     = $_GET['id'];
$t = Trasferimento::id($t);

if (isset($_GET['si'])) {
    $t->trasferisci();    
    redirect('presidente.trasferimento&ok');  
}

if (isset($_GET['no'])) {
    $t->nega($_POST['motivo']);
    redirect('presidente.trasferimento&no');   
}
?>