<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAPP([APP_SOCI,APP_PRESIDENTE]);
$t = $_GET['id'];
?>
<form class="form-horizontal" action="?p=presidente.aspiranti.comitato.nuovo.ok&id=<?php echo $t; ?>" method="POST">
<div class="control-group">
            <label class="control-label" for="inputComitato">Nomina Presidente</label>
            <div class="controls">
                <select required name="inputComitato" autofocus class="span8">
                    <?php foreach ( $me->comitatiDiCompetenza() as $c ) { ?>
                        <option value="<?php echo $c->id; ?>"><?php echo $c->nomeCompleto(); ?></option>
                    <?php } ?>
                </select>
            </div>
          </div>
    <div class="control-group">
        <label class="control-label" for="dataingresso">Data esame corso base </label>
        <div class="controls">
            <input class="input-medium" type="text" name="dataingresso" id="dataingresso" required>
            </div>
   </div>
    <div class="control-group">
            <div class="controls">
              <button type="submit" class="btn btn-large btn-success">
                  <i class="icon-ok"></i>
                  Assegna
              </button>
            </div>
          </div>