<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPresidenziale();
$e = $_GET['id'];
$e = Estensione::id($e);
$_v = $e->volontario();
?>

<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <h2><i class="icon-chevron-right muted"></i> Presa in carico richiesta estensione</h2>
            <div class="alert alert-block alert-info ">
                <div class="row-fluid">
                    <span class="span12">
                        <p>Con questo modulo si prende in carico la richiesta di estensione del volontario <strong><?php echo $_v->nome; echo " "; echo $_v->cognome; ?></strong> al <strong><?php echo $e->comitato()->nomeCompleto(); ?></strong></p>
                    </span>
                </div>
            </div>           
        </div>
        
<div class="row-fluid">
    <form class="form-horizontal" action="?p=presidente.estensioneRichiesta.ok&id=<?php echo $e->id; ?>" method="POST">
     <div class="control-group">
        <label class="control-label" for="numprotocollo">Numero Protocollo </label>
        <div class="controls">
            <input class="input-large" type="text" name="numprotocollo" id="numprotocollo" required>
            </div>
          </div>   
    
   <div class="control-group">
        <label class="control-label" for="dataprotocollo">Data protocollo </label>
        <div class="controls">
            <input class="input-medium" type="text" name="dataprotocollo" id="dataprotocollo" required>
            </div>
          </div>
    <div class="control-group">
            <div class="controls">
              <button type="submit" class="btn btn-large btn-success">
                  <i class="icon-ok"></i>
                  Accetta richiesta
              </button>
            </div>
          </div>
        </div>
    
    </div>
</div>

