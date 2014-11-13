<?php

/*
* ©2014 Croce Rossa Italiana
*/

paginaPrivata();
controllaParametri(array('id'), 'formazione.corsibase&err');
$corso = CorsoBase::id($_GET['id']);
paginaCorsoBase($corso);

if(!$me->admin()) {
    $mieiComitati = $me->comitatiApp([APP_PRESIDENTE], false);

    if (!in_array($corso->organizzatore(), $mieiComitati)
        or !($corso->cancellabile())){
        redirect('formazione.corsibase&err');
    }
}
$corso->cancella();
redirect('formazione.corsibase&cancellato');
