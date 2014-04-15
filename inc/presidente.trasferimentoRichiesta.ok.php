<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

$parametri = array('id', 'numprotocollo', 'dataprotocollo');
controllaParametri($parametri, 'presidente.trasferimento&err');

$t = $_POST['id'];


$a = Trasferimento::id($t);

$v = $a->volontario();
if(!$v->modificabileDa($me)) {
	redirect('errore.permessi&cattivo');
}

if($a->protData && $a->protNumero) {
	redirect('presidente.trasferimento&giaprot');
}

$a->protNumero = $_POST['numprotocollo'];
$protData = @DateTime::createFromFormat('d/m/Y', $_POST['dataprotocollo']);
$protData = @$protData->getTimestamp();
$a->protData = $protData;
$m = new Email('richiestaTrasferimentoprot', 'Richiesta trasferimento Protocollata: ' . $a->comitato()->nome);
$m->a = $a->volontario();
$m->_NOME       = $a->volontario()->nome;
$m->_COMITATO   = $a->comitato()->nomeCompleto();
$m->_TIME = $a->dataRichiesta()->format('d/m/Y');
$m->_NUM = $a->protNumero;
$m->invia();

redirect('presidente.trasferimento&prot');   
?>