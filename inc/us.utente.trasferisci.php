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
           <ol>
               <li>
                   <a data-selettore="true" data-input="inputVolontario"
                      data-stato="<?= MEMBRO_VOLONTARIO; ?>"
                      class="btn btn-inverse btn-small">
                        Seleziona un volontario... 
                        <i class="icon-pencil"></i>
                    </a><p></p>
               </li>
               <li>
                   <a class="btn btn-inverse btn-small" data-selettore-comitato="true" data-input="inputComitato">
                    Seleziona un comitato di destinazione... <i class="icon-pencil"></i>
                    </a><p></p>
               </li>
               <li><input class="span4 allinea-sinistra" type="text" name="inputMotivo" id="motivo" placeholder="Inserisci la motivazione" required></li>
               <li>Vai nella sezione trasferimenti in attesa e completa la procedura.</li>
           </ol>
           <p class="text-error"><i class="icon-warning-sign"></i> Attenzione questa operazione non è reversibile </p>
           <p>&nbsp;</p>
        </div>
        <div class="modal-footer">
          <a href="?p=us.dash" class="btn">Annulla</a>
         <button type="submit" class="btn btn-primary">
              <i class="icon-arrow-right"></i> Trasferisci Volontario
          </button>
        </div>
    </div>
</form>
