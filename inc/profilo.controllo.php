<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$id = $_GET['id'];
$v = Volontario::by('id', $id);

if($me->admin()){
	redirect('restricted.utente&id=' . $id);
}elseif($me->presidenziante() || $me->delegazioni(APP_SOCI) || $me->delegazioni(APP_OBIETTIVO)){
	$comitati = $me->comitatiApp([APP_PRESIDENTE, APP_SOCI, APP_OBIETTIVO]);
	foreach ($comitati as $comitato){
		if($v->in($comitato)){
			redirect('restricted.utente&id=' . $id);			
		}else{
			continue;
		}
	}
	redirect('public.utente&id=' . $id);
}elseif($me->areeDiResponsabilita()){
	$ar = $me->areeDiResponsabilita();
	foreach( $ar as $_a ){
		$c = $_a->comitato();
		if($v->in($c)){
			redirect('restricted.utente&id=' . $id);
		}else{
			continue;
		}
	}
	redirect('public.utente&id=' . $id);
}elseif($me->attivitaReferenziate()){
	$a = $me->attivitaReferenziate();
	foreach( $a as $_a ){
		$c = $_a->area()->comitato();
		if($v->in($c)){
			redirect('restricted.utente&id=' . $id);
		}else{
			continue;
		}
	}
	redirect('public.utente&id=' . $id);
}else{
	redirect('public.utente&id=' . $id);
}

?>