<?php
/*
* ©2013 Croce Rossa Italiana
*/
 
paginaPrivata();
 
$email = minuscolo($_POST['inputEmail']);
$emailServizio = minuscolo($_POST['inputemailServizio']);
 
if ( $email !== $me->email && Utente::by('email', $email) ) {
	redirect('utente.email&ep');
}
 
$me->emailServizio = $emailServizio;
$me->email = $email;
 
redirect('utente.email&ok');