<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

$parametri = array('id', 'numprotocollo', 'dataprotocollo');
controllaParametri($parametri, 'presidente.riserva&err');

$t     = $_GET['id'];

$a = Riserva::id($t);

$v = $a->volontario();

if (!$v->modificabileDa($me) && !$me->admin()) {
  redirect('presidente.riserva&err');
}

if($a->protData && $a->protNumero) {
	redirect('presidente.riserva&giaprot');
}


$a->protNumero = $_POST['numprotocollo'];
$protData = @DateTime::createFromFormat('d/m/Y', $_POST['dataprotocollo']);
$protData = @$protData->getTimestamp();
$a->protData = $protData;
                                    
redirect('presidente.riserva&prot');   
?>