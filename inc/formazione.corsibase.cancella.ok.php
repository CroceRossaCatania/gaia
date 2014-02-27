<?php

paginaPrivata();
controllaParametri(array('id'), 'formazione.corsibase&err');
$corso = CorsoBase::id($_GET['id']);
paginaCorsoBase($corso);

$mieiComitati = $me->comitatiApp([APP_PRESIDENTE], false);
if (!in_array($corso->organizzatore(), $mieiComitati)
    or !$corso->stato == CORSO_S_DACOMPLETARE
    or !$me->admin()){
    redirect('formazione.corsibase&err');
}
$corso->cancella();


redirect('formazione.corsibase&cancellato');
