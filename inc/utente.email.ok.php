<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();

$email      = minuscolo($_POST['inputEmail']);
$emailServizio = minuscolo($_POST['inputemailServizio']);

if (Utente::by('email', $email)) {
    $x=1;
}else{
    $me->email               = $email; 
}

if (Utente::by('emailServizio', $emailServizio)) {
    $h=1;
}else{
    $me->emailServizio   = $emailServizio;      
}

if($x==1 && $h==1){
    redirect('utente.email&ee');
}elseif($h==1){
    redirect('utente.email&ei');
}elseif($x==1){
    redirect('utente.email&ep');
}else{
redirect('utente.email&ok');
}