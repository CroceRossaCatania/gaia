<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

controllaParametri(array('id'), 'presidente.utenti&errGen');

$v = $_GET['id'];
$v = Volontario::id($v);
?>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <h2><i class="icon-warning-sign muted"></i> Dimissione Volontario</h2>
            <div class="alert alert-error">
                <div class="row-fluid">
                    <span class="span12">
                        <p>Stai dimettendo il volontario <strong><?php echo $v->nomeCompleto();?></strong>.</p>
                        <p>Specifica il motivo di tale decisione</p>
                    </span>
                </div>
            </div>           
        </div>
        

        <div class="row-fluid">
            <form class="form-horizontal" action="?p=presidente.utente.dimetti.ok&id=<?php echo $v->id; ?>" method="POST">
                <div class="control-group">
                    <label class="control-label" for="motivo">Motivazione</label>
                    <div class="controls">
                        <select class="input-xlarge" id="motivo" name="motivo"  required>
                            <?php
                            foreach ( $conf['dimissioni'] as $numero => $dimissione ) { ?>
                            <option value="<?php echo $numero; ?>"><?php echo $dimissione; ?></option>
                            <?php } ?>
                        </select>   
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="info">Informazioni aggiuntive </label>
                    <div class="controls">
                        <input class="span8" type="text" name="info" id="info" placeholder="es.: Provvedimento di radiazione n. 134 del 12/12/2013" >
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                      <button type="submit" class="btn btn-large btn-danger">
                          <i class="icon-remove"></i>
                          Dimetti Volontario
                      </button>
                  </div>
              </div>
          </div>
          
      </div>
  </div>


