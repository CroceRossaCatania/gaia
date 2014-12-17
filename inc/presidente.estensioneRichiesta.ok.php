<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

$parametri = array('id', 'numprotocollo', 'dataprotocollo');
controllaParametri($parametri, 'presidente.estensione&err');


$e     = $_GET['id'];

$a = Estensione::id($e);
$v = $a->volontario();

if (!$v->modificabileDa($me) && !$me->admin()) {
  redirect('presidente.estensione&err');
}

if($a->protData && $a->protNumero) {
	redirect('presidente.estensione&giaprot');
}

$a->protNumero = $_POST['numprotocollo'];
$protData = @DateTime::createFromFormat('d/m/Y', $_POST['dataprotocollo']);
$protData = @$protData->getTimestamp();
$a->protData = $protData;
$m = new Email('richiestaEstensioneprot', 'Richiesta estensione Protocollata: ' . $a->comitato()->nomeCompleto());
$m->a = $a->volontario();
$m->_NOME       = $a->volontario()->nome;
$m->_COMITATO   = $a->comitato()->nomeCompleto();
$m-> _TIME = date('d-m-Y', $a->protData);
$m-> _NUM = $a->protNumero;
$m->invia();
                                    
redirect('presidente.estensione&prot');   
?>
