<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('id'), 'gruppi.dash&err');

$id = $_GET['id'];
$g = AppartenenzaGruppo::id($id);

$gruppo = $g->gruppo();
proteggiClasse($gruppo, $me);

?>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <h2><i class="icon-warning-sign muted"></i> Espulsione Volontario da gruppo di lavoro</h2>
                <div class="alert alert-error">
                    <div class="row-fluid">
                        <span class="span12">
                            <p><strong><?php if($me->presiede()){?><span class="muted">Presidente,</span><?php } ?></strong></p>
                            <p>Stai espellendo il volontario <strong><?php echo $g->volontario()->nomeCompleto(); ?></strong> dal gruppo di lavoro <strong><?php echo $g->gruppo()->nome; ?></strong>.</p>
                            <p>Specifica il motivo di tale decisione</p>
                        </span>
                    </div>
                </div>           
        </div>
                    

<div class="row-fluid">
    <form class="form-horizontal" action="?p=gruppo.utente.espelli.ok&id=<?php echo $g->id; ?>&no" method="POST">
       <div class="control-group">
        <label class="control-label" for="motivo">Motivazione </label>
        <div class="controls">
            <input class="span8" type="text" name="motivo" id="motivo" placeholder="es.: Manca dei requisiti per l'accesso a questo gruppo" required>
            </div>
          </div>
    <div class="control-group">
            <div class="controls">
              <button type="submit" class="btn btn-large btn-danger">
                  <i class="icon-remove"></i>
                  Espelli volontario
              </button>
            </div>
          </div>
        </div>
    
    </div>
</div>


