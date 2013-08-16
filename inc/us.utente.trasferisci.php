<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);
caricaSelettore();
caricaSelettoreComitato();
paginaModale();

?>

<form action="?p=us.utente.trasferisci.ok" method="POST">
    <div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-arrow-right"></i> Trasferisci volontario</h3>
        </div>
        <div class="modal-body">
           <p> Con questo modulo potrai trasferire un volontario presso un altro Comitato </p>
           <p class="text-error"><i class="icon-warning-sign"></i> Attenzione questa operazione non è reversibile </p>
           <p>&nbsp;</p>
          <p>
              <a data-selettore="true" data-input="inputVolontario"
                 class="btn btn-inverse btn-block btn-large">
                  Seleziona un volontario... <i class="icon-pencil"></i>
              </a>
          </p>
          <p>
                <a class="btn btn-inverse btn-block btn-large" data-selettore-comitato="true" data-input="inputComitato">
                    Seleziona un comitato di destinazione... <i class="icon-pencil"></i>
                </a>
          </p>
          <p class="allinea-centro">
                 <input class="span6 allinea-centro" type="text" name="inputMotivo" id="motivo" placeholder="Motivazione" required>
          </p>
        </div>
        <div class="modal-footer">
          <a href="?p=us.dash" class="btn">Annulla</a>
         <button type="submit" class="btn btn-primary">
              <i class="icon-arrow-right"></i> Trasferisci Volontario
          </button>
        </div>
    </div>
</form>
