<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$t = $_GET['oid'];
$t = GeoPolitica::daOid($t);

if (isset($_GET['com'])){
    
    $t = new Comitato($t);
    $t->cancella();
    redirect('admin.comitati&del');
    
}elseif (isset($_GET['loc'])){
    
    $t = new Locale($t);
    $t->cancella();
    redirect('admin.comitati&del');
    
}elseif (isset($_GET['pro'])){
    
    $t = new Provinciale($t);
    $t->cancella();
    redirect('admin.comitati&del');
    
}elseif (isset($_GET['regi'])){
    
    $t = new Regionale($t);
    $t->cancella();
    redirect('admin.comitati&del');
    
}elseif (isset($_GET['naz'])){
    
    $t = new Nazionale($t);
    $t->cancella();
    redirect('admin.comitati&del');
    
}
