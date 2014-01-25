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

?>

<div class="btn-group">
  <button class="btn">Action</button>
  <button class="btn dropdown-toggle" data-toggle="dropdown">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <?php foreach($d as $_d) {
        if ($_d->attuale()) {
            $g = GeoPolitica::daOid($_d->comitato);
            $s = "{$conf['applicazioni'][$_d->applicazione]}:{$g->nome}";
            echo("<li>{$s}</li>");
        }
    } ?>
  </ul>
</div>
<hr />