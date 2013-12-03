<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();



if(isset($_GET['ok'])) {
	$sessione->barcode = time();
	header("Location: https://docs.google.com/forms/d/1ZUGwlLJj8lQRwRABGyZ3C6UotVZYCOi2rkY-uE97wjI/viewform");
	exit(0);
} elseif(isset($_GET['no'])) {
	$sessione->barcode = time();
	redirect('utente.me');
} 

redirect('utente.me');


?>