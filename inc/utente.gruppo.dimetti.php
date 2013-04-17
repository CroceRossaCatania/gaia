<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$t = $_GET['id'];

/* Cerco i gruppi a cui appartengo attualmente */
$g = $me->gruppiAttuali();

/* Se appartengo solo ad un gruppo non dimetto
 */

$x = count ($g);
if($x == 1){
    
    redirect('utente.gruppo&last');
    
}               

/*Se non sono appartenente allora avvio la procedura*/

        $t = new AppartenenzaGruppo($t);
        $t->fine = time();
        
        redirect('utente.gruppo&del');