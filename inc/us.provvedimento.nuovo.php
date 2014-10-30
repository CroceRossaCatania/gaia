<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);
caricaSelettore();
paginaModale();

?>

<form action="?p=us.provvedimento.nuovo.ok" method="POST">
    <div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-legal"></i> Registra provvedimento</h3>
        </div>
        <div class="modal-body">
           <p> Con questo modulo potrai registrare un provvedimento disciplinare intrapreso nei confronti di un volontario </p>
           <ol>
               <li>
                   <a data-selettore="true" data-input="inputVolontario"
                 class="btn btn-inverse btn-small">
                  Seleziona un volontario... <i class="icon-pencil"></i>
                    </a><p></p>
               </li>
               <li>
                <div class="controls">
                  <select class="input-large" id="inputTipo" name="inputTipo">
                    <?php
                      foreach ( $conf['provvedimenti'] as $numero => $tipo ) { ?>
                        <option value="<?php echo $numero; ?>"><?php echo $tipo; ?></option>
                    <?php } ?>
                  </select>   
                </div>
               </li>
               <li><input class="input-large allinea-sinistra" type="text" name="datainizio" id="datainizio" placeholder="Inserisci data di inizio provvedimento" autocomplete="off" required></li>
               <li><input class="input-large allinea-sinistra" type="text" name="datafine" id="datafine" placeholder="Inserisci data di fine provvedimento" autocomplete="off" required></li>
               <li><input class="span4 allinea-sinistra" type="text" name="inputMotivo" id="motivo" placeholder="Inserisci la motivazione" autocomplete="off" required></li>
               <li><input class="input-large allinea-sinistra" type="text" name="protNum" id="protNum" placeholder="Inserisci il numero di protocollo" autocomplete="off" required></li>
               <li><input class="input-large allinea-sinistra" type="text" name="protData" id="protData" placeholder="Inserisci la data di protocollo" autocomplete="off" required></li>
           </ol>
           <p class="text-error"><i class="icon-warning-sign"></i> Attenzione questa operazione non è reversibile </p>
           <p>&nbsp;</p>
        </div>
        <div class="modal-footer">
          <a href="?p=us.dash" class="btn">Annulla</a>
         <button type="submit" class="btn btn-primary">
              <i class="icon-legal"></i> Registra Provvedimento
          </button>
        </div>
    </div>
</form>
