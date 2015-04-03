<?php

$oid = $_GET['oid'];

$c = GeoPolitica::daOid($oid);

paginaApp(APP_PRESIDENTE, [$c]);

if($c->permettiTrasferimentiUS()){
	$c->trasferimentiUS = 0;
}else{
	$c->trasferimentiUS = time();
}

redirect("presidente.comitato&oid=".$c->oid());