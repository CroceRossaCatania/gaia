<?php

/*
 * ©2013 Croce Rossa Italiana
 */

global $me;
global $sessione;
global $conf;

$d = Delegato::filtra([
        ['volontario', $me->id]
        ]);

$r = $sessione->applicazione;
$ruolo = "Seleziona ruolo";
if($r) {
    $attuale = Delegato::id($r);
    $g = GeoPolitica::daOid($attuale->comitato);
    if ($attuale->applicazione == APP_OBIETTIVO) {
        $ruolo = "Delegato {$conf['nomiobiettivi'][$attuale->dominio]}:{$g->nome}";   
    } else {
        $ruolo = "{$conf['applicazioni'][$attuale->applicazione]}:{$g->nome}";    
    }
    if (strlen($ruolo) > 30) {
        $ruolo = substr($ruolo, 0, 15) . '...';
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
        if ($_d->attuale()) {
            $g = GeoPolitica::daOid($_d->comitato);
            if ($_d->applicazione == APP_OBIETTIVO) {
                $s = "<a href='?p=utente.caricaRuolo.ok&ruolo={$_d->id}'>Delegato {$conf['nomiobiettivi'][$_d->dominio]}:{$g->nome}";
            } else {
                $s = "<a href='?p=utente.caricaRuolo.ok&ruolo={$_d->id}'>{$conf['applicazioni'][$_d->applicazione]}:{$g->nome}";
            }
            echo("<li>{$s}</li>");
        }
    } ?>
  </ul>
</div>
<hr />