<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

controllaParametri(array('id'), 'presidente.riserva&err');

$t = $_GET['id'];
$t = Riserva::id($t);
$_v = $t->volontario();
?>
<script type="text/javascript"><?php require './js/presidente.trasferimentoRichiesta.js'; ?></script>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <h2><i class="icon-chevron-right muted"></i> Presa in carico richiesta riserva</h2>
            <div class="alert alert-block alert-info ">
                <div class="row-fluid">
                    <span class="span12">
                        <p>Con questo modulo si prende in carico la richiesta di riserva del volontario <strong><?php echo $_v->nome; echo " "; echo $_v->cognome; ?></strong>.</p>
                    </span>
                </div>
            </div>           
        </div>
        
<div class="row-fluid">
    <form class="form-horizontal" action="?p=presidente.riservaRichiesta.ok&id=<?php echo $t->id; ?>" method="POST">
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

