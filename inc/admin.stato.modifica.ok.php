<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
$parametri = array('id','inputStato');
controllaParametri($parametri, 'admin.limbo&err');
$v = Utente::id($_GET['id']);
$stato = $_POST['inputStato'];

if($stato == NESSUNO){
	redirect('admin.double&err');
}elseif($stato == VOLONTARIO && !$v->appartenenze()){
	redirect('admin.limbo.comitato.nuovo&id='.$v);
}elseif($stato == PERSONA && $v->appartenenze()){
	redirect('admin.double&err');
}elseif($stato == ASPIRANTE && $v->appartenenze()){
	redirect('admin.double&err');
}else{
	$v->stato = $stato;
}

redirect('admin.double&ok');

?>