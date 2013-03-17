<?php

/*
 * ©2012 Croce Rossa Italiana
 */
paginaPrivata();
$t = $_GET['id'];
?>
<form class="form-horizontal" action="?p=admin.newReferente.ok&id=<?php echo $t; ?>" method="POST">
<div class="control-group">
            <label class="control-label" for="inputApplicazione"> Applicazione</label>
            <div class="controls">
                <select required name="inputApplicazione" autofocus class="span8">
                    <?php foreach ( $conf['applicazioni'] as $numero => $app) { ?>
                        <option value="<?php echo $numero; ?>"><?php echo $app; ?></option>
                    <?php } ?>
                </select>
            </div>
          </div>
 <div class="control-group">
            <label class="control-label" for="inputDominio"> Dominio</label>
            <div class="controls">
                <select required name="inputDominio" autofocus class="span8">
                    <?php foreach ( $conf['app_attivita'] as $numero => $app) { ?>
                        <option value="<?php echo $numero; ?>"><?php echo $app; ?></option>
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

