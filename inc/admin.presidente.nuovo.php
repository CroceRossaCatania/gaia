<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$t = $_GET['id'];
?>
<form class="form-horizontal" action="?p=admin.presidente.nuovo.ok&id=<?php echo $t; ?>" method="POST">
<div class="control-group">
            <label class="control-label" for="inputComitato">Nomina Presidente</label>
            <div class="controls">
                <select required name="inputComitato" autofocus class="span8">
                    <?php foreach ( $me->comitatiDiCompetenza() as $c ) { ?>
                        <option value="<?php echo $c->id; ?>"><?php echo $c->nome; ?></option>
                    <?php } ?>
                </select>
            </div>
          </div>
    <div class="control-group">
            <div class="controls">
              <button type="submit" class="btn btn-large btn-success">
                  <i class="icon-ok"></i>
                  Nomina
              </button>
            </div>
          </div>

