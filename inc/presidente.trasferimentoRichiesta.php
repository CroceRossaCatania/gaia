<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPresidenziale();

controllaParametri(array('id'), 'presidente.trasferimento&err');

$t = $_GET['id'];
$t = Trasferimento::id($t);
$_v = $t->volontario();
?>

<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <h2><i class="icon-chevron-right muted"></i> Presa in carico richiesta trasferimento</h2>
            <div class="alert alert-block alert-info ">
                <div class="row-fluid">
                    <span class="span12">
                        <p>Con questo modulo si prende in carico la richiesta di trasferimento del volontario <strong><?php echo $_v->nome; echo " "; echo $_v->cognome; ?></strong> al <strong><?php echo $t->comitato()->nomeCompleto(); ?></strong></p>
                    </span>
                </div>
            </div>           
        </div>
        
<div class="row-fluid">
    <form class="form-horizontal" action="?p=presidente.trasferimentoRichiesta.ok" method="POST">
    <input type="hidden" name="id" value="<?= $t->id; ?>">
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

