<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);
caricaSelettore();
paginaModale();

?>

<input type="hidden" name="id"  />

<div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-arrow-right"></i> Trasferisci volontario</h3>
        </div>
        <div class="modal-body">
          <p><strong>Trasferimento</strong>
           <p> Con questo modulo potrai trasferire un volontario presso un altro Comitato </p>
           <p>&nbsp;</p>
          <p>
              <a data-selettore="true" data-input="inputReferente" data-autosubmit="true" 
                 class="btn btn-inverse btn-block btn-large">
                  Seleziona un volontario... <i class="icon-pencil"></i>
              </a>
          </p>
        </div>
        <div class="modal-footer">
          <a href="?p=us.dash" class="btn">Annulla</a>
         <!-- <button type="submit" class="btn btn-primary">
              <i class="icon-asterisk"></i> Crea attività
          </button>-->
        </div>
</div>
    
</form>
