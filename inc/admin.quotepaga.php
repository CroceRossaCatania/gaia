<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$elenco = Comitato::elenco();
foreach ( $elenco as $comitato ){
    $q = $comitato->quoteNo();
    foreach ($q as $_q){
        set_time_limit(0);
        $t = new Quota();
        $appartenenza = $_q->appartenenzeAttuali();
        $t->appartenenza = $appartenenza[0];
        $time = date('Y', time());
        $time = mktime(0,0,0,1,1,$time);
        $t->timestamp = $time;
        $t->tConferma = time();
        $t->pConferma = $me;
        $t->quota = QUOTA_RINNOVO;
        $s = QUOTA_RINNOVO;
        $i = "Versamento quota di rinnovo annuale";
        $t->causale = $i;
    }
}

redirect('us.quoteNo');
