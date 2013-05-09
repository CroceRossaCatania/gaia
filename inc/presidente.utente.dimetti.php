<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();
$v = $_GET['id'];
$v = Volontario::by('id', $v);
?>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <h2><i class="icon-warning-sign muted"></i> Dimissione Volontario</h2>
                <div class="alert alert-error">
                    <div class="row-fluid">
                        <span class="span12">
                            <p><strong><?php if($me->presiede()){?><span class="muted">Presidente,</span><?php } ?></strong></p>
                            <p>Stai dimettendo il volontario <strong><?php echo $v->nomeCompleto();?></strong>.</p>
                            <p>Specifica il motivo di tale decisione</p>
                        </span>
                    </div>
                </div>           
        </div>
                    

<div class="row-fluid">
    <form class="form-horizontal" action="?p=presidente.utente.dimetti.ok&id=<?php echo $v->id; ?>" method="POST">
       <div class="control-group">
        <label class="control-label" for="motivo">Motivazione </label>
        <div class="controls">
            <input class="span8" type="text" name="motivo" id="motivo" placeholder="es.: Mancato versamento quota associativa" required>
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


