<?php

/*
 * ©2013 Croce Rossa Italiana
 */

global $me;
global $sessione;
global $conf;

$deleghe = Delegato::filtra([
        ['volontario', $me->id]
        ]);

$d = [];
foreach ($deleghe as $_d) {
    if($_d->attuale()) {
        $d[] = $_d;
    }
}

if (count($d) == 0) {
    return;
} elseif(count($d) == 1) {
    if(!$sessione->ambito) {
        $sessione->ambito = $d[0]->id;
    }
    return;
}

$r = $sessione->ambito;
$ruolo = "Seleziona ruolo";
if($r) {
    $attuale = Delegato::id($r);
    $g = GeoPolitica::daOid($attuale->comitato);
    $nome = "{$g->nome}";
    if ($g->_estensione() == EST_UNITA) {
        $nome = "Unità {$g->nome}";
    }
    if ($attuale->applicazione == APP_OBIETTIVO) {
        $ruolo = "Delegato {$conf['nomiobiettivi'][$attuale->dominio]}: {$nome}";   
    } else {
        $ruolo = "{$conf['applicazioni'][$attuale->applicazione]}: {$nome}";    
    }
    if (strlen($ruolo) > 30) {
        $ruolo = substr($ruolo, 0, 30) . '...';
    }
}
    

?>
<div class="btn-group" style="width:100%;">
  <button class="btn" style="width:90%;"><?php echo($ruolo); ?></button>
  <button class="btn dropdown-toggle" data-toggle="dropdown" style="width:10%;">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <?php foreach($d as $_d) {
        if ($_d->id != $sessione->ambito) {
            $g = GeoPolitica::daOid($_d->comitato);
            $nome = "{$g->nome}";
            if ($g->_estensione() == EST_UNITA) {
                $nome = "Unità {$g->nome}";
            }
            if ($_d->applicazione == APP_OBIETTIVO) {
                $s = "<a href='?p=utente.caricaRuolo.ok&ruolo={$_d->id}'>Delegato {$conf['nomiobiettivi'][$_d->dominio]}: {$nome}";
            } else {
                $s = "<a href='?p=utente.caricaRuolo.ok&ruolo={$_d->id}'>{$conf['applicazioni'][$_d->applicazione]}: {$nome}";
            }
            echo("<li>{$s}</li>");
        }
    } ?>
  </ul>
</div>
<hr />
