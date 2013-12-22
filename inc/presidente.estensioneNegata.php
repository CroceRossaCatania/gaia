<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPresidenziale();

controllaParametri(array('id'));

$e = $_GET['id'];
$e = Estensione::id($e);
$c=$e->comitato();
$v = $e->volontario();

?>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <h2><i class="icon-warning-sign muted"></i> Negazione richiesta di estensione</h2>
                <div class="alert alert-error">
                    <div class="row-fluid">
                        <span class="span12">
                            <p><strong><?php if($me->presiede()){?><span class="muted">Presidente,</span><?php } ?></strong></p>
                            <p>Stai negando la richiesta di estensione di <strong><?php echo $v->nome; echo " "; echo $v->cognome;?></strong> presso il <strong><?php echo $c->nomeCompleto(); ?></strong>.</p>
                            <p>Specifica il motivo di tale decisione</p>
                        </span>
                    </div>
                </div>           
        </div>
                    

<div class="row-fluid">
    <form class="form-horizontal" action="?p=presidente.estensione.ok&id=<?php echo $e->id; ?>&no" method="POST">
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
                  Nega estensione
              </button>
            </div>
          </div>
        </div>
    
    </div>
</div>


