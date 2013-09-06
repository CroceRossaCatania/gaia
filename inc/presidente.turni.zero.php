<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();
paginaModale();

?>
<form action="?p=presidente.turni.zero.ok" method="POST">
<div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-time"></i> Report volontari zero turni</h3>
        </div>
    <div class="modal-body">
        <p>Con questo strumento è possibile generare il report dei volontari che non hanno eseguito turni nel mese specificato.<br/>
          Selezionare, <strong>anno</strong>, <strong>mese</strong> e cliccare su un <strong>giorno</strong> a caso nel calendario.</p>
        <hr />
          <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label" for="inputData"> Mese</label>
                </div>
                <div class="span8">
                  <input class="input-large" type="text" name="inputData" id="inputData" required placeholder='Mese YYYY' />
                </div>
        </div>
    </div>
        <div class="modal-footer">
          <a href="?p=presidente.dash" class="btn">Annulla</a>
          <button type="submit" class="btn btn-primary" data-attendere="Generazione in corso attendere...">
              <i class="icon-time"></i> Genera report
          </button>
        </div>
</div>
    
</form>
