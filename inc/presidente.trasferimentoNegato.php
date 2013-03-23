<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPresidenziale();
$t = $_GET['id'];
$t = new Trasferimento($t);
$c=$t->comitato();
$v = $t->volontario();

?>

<hr />
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <h2><i class="icon-warning-sign muted"></i> Negazione richiesta trasferimento</h2>
                <div class="alert alert-error">
                    <div class="row-fluid">
                        <span class="span12">
                            <p><strong><?php if($me->presiede()){?><span class="muted">Presidente,</span><?php } ?></strong></p>
                            <p>Stai negando la richiesta di trasferimento di <strong><?php echo $v->nome; echo " "; echo $v->cognome;?></strong> presso il <strong><?php echo $c->nome; ?></strong>.</p>
                            <p>Specifica il motivo di tale decisione</p>
                        </span>
                    </div>
                </div>           
        </div>
                    

<div class="row-fluid">
    <form class="form-horizontal" action="?p=presidente.trasferimento.ok&id=<?php echo $t->id; ?>&no" method="POST">
       <div class="control-group">
        <label class="control-label" for="motivo">Motivazione </label>
        <div class="controls">
            <input class="span8" type="text" name="motivo" id="motivo" placeholder="es.: Provvedimento disciplinare" required>
            </div>
          </div>
    <div class="control-group">
            <div class="controls">
              <button type="submit" class="btn btn-large btn-danger">
                  <i class="icon-remove"></i>
                  Nega trasferimento
              </button>
            </div>
          </div>
        </div>
    
    </div>
</div>


