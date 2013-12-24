<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$p = Privacy::by('volontario', $me);
if($p){
	$p = new Privacy($p);
}else{
	$p = new Privacy();
}

$p->volontario     	= $me;
$p->contatti        = $_POST['phoneradio'];
$p->mess  			= $_POST['messradio'];
$p->curriculum 		= $_POST['curriculumradio'];
$p->incarichi   	= $_POST['incarichiradio'];
$p->timestamp   	= time();

redirect('utente.privacy&ok');

?>
