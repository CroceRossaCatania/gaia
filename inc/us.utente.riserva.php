<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);
caricaSelettore();
caricaSelettoreComitato();
paginaModale();

?>
<form action="?p=us.utente.riserva.ok" method="POST">
    <div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-pause"></i> Metti in riserva volontario</h3>
        </div>
        <div class="modal-body">
           <p> Con questo modulo potrai mettere in riserva un volontario</p>
           <ol>
               <li>
                   <a data-selettore="true" data-input="inputVolontario"
                      data-stato="<?= MEMBRO_VOLONTARIO; ?>"
                      class="btn btn-inverse btn-small">
                        Seleziona un volontario... 
                        <i class="icon-pencil"></i>
                    </a><p></p>
               </li>
               <li><input class="input-large allinea-sinistra" type="text" name="datainizio" id="datainizio" placeholder="Inserisci data di inizio riserva" autocomplete="off" required></li>
               <li><input class="input-large allinea-sinistra" type="text" name="datafine" id="datafine" placeholder="Inserisci data di fine riserva" autocomplete="off" required></li>
               <li><input class="span4 allinea-sinistra" type="text" name="inputMotivo" id="motivo" placeholder="Inserisci la motivazione" required></li>
               <li>Vai nella sezione riserve in attesa e completa la procedura.</li>
           </ol>
           <p class="text-error"><i class="icon-warning-sign"></i> Attenzione questa operazione non è reversibile </p>
           <p>&nbsp;</p>
        </div>
        <div class="modal-footer">
          <a href="?p=us.dash" class="btn">Annulla</a>
         <button type="submit" class="btn btn-primary">
              <i class="icon-pause"></i> Metti in riserva Volontario
          </button>
        </div>
    </div>
</form>
