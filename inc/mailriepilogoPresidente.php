<?php

/*
 * ©2012 Croce Rossa Italiana
 */

$presidenti = Appartenenza::filtra([['stato','4']]);
foreach ($presidenti as $presidente)
    {
if($presidente->fine >= time())
    { 
foreach($presidente as $p)
    { 
    $c=$p->comitato;
    echo $c;
    $volontari = Appartenenza::filtra([['stato', '0'],['comitato',$c]]);
    echo count($volontari);
foreach($volontari as $volontario)
    {
        $_v = $volontario->volontario()->id;
        echo $_v;
    }
    }
    }
    }
?>