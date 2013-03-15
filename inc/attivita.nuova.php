<?php
$a = new Attivita(@$_GET['id']);
?>

<div class="row-fluid">
    <div class="span7">    
        <div class="row-fluid">
            <h2>
                <i class="icon-list-alt"></i>
                Attività
            </h2>
        </div>
    <div class="alert alert-error alert-block">
        <h4><i class="icon-warning-sign"></i> Altamente sperimentale</h4>
        Potrebbe uccidere il tuo gatto.</p>
    </div>

          <div class="form-horizontal">
          <div class="control-group">
            <label class="control-label" for="inputNome">Nome</label>
            <div class="controls">
              <input class="input-xlarge" value="<?php echo $a->nome; ?>" type="text" id="inputNome" name="inputNome" placeholder="Es.: Aggiungi un Posto a Tavola" required autofocus pattern=".{2,}" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputRivolto">A chi è rivolta l'attività</label>
            <div class="controls">
                <select required name="inputRivolto" id="inputRivolto" autofocus class="input-xlarge">
                    <option value="" selected="selected">[ Seleziona un Comitato ]</option>
                    <?php foreach ( $me->comitati() as $c ) { ?>
                        <option value="<?php echo $c->id; ?>"><?php echo $c->nome; ?></option>
                    <?php } ?>
                </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Tipo attività</label>
            <div class="controls">
                <select required name="inputTipo" id="inputTipo" autofocus class="input-xlarge">
                    <option value="" selected="selected">[ Seleziona una Categoria ]</option>
                    <?php foreach ( $me->comitati() as $c ) { ?>
                        <option value="<?php echo $c->id; ?>"><?php echo $c->nome; ?></option>
                    <?php } ?>
                </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputDescrizione">Descrizione attività</label>
            <div class="controls">
              <textarea rows="7" class="input-xlarge" type="text" id="inputDescrizione" name="inputDesrizione" placeholder="Es.: Attività rivolta agli indigenti" required pattern=".{2,}"></textarea>
            </div>
          </div>
          
       <div class="span12">
       <table class="table table-striped table-bordered table-condensed" id="tabellaTurni">
            <thead>
                <th>Turno</th>
                <th>Inizio</th>
                <th>Fine</th>
            </thead>
            <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <tr>
                <td colspan="3"><button id="aggiungiTurno" class="btn btn-block btn-primary">
                  <i class="icon-plus"></i>
                  Aggiungi turno
              </button></td>
                
                
            </tr>
        </table>
          
          </div>
</div>
    
<div class="row-fluid">
          <div class="control-group">
            <div class="controls">
              <button type="submit" class="btn btn-large btn-success">
                  <i class="icon-ok"></i>
                  Registrati
              </button>
            </div>
          </div>
        </div>
</div>
    
<!--Mappa-->    
<div class="span5">

    <div class="span12">
        <h2>
            <i class="icon-map-marker"></i>
            Localizza l'attività
        </h2>
    </div>
    <div class="span12">
        <div class="alert alert-info">
            <i class="icon-info-sign"></i> <strong>Croce Rossa si muove.</strong>
            È importante localizzare un'attività così che questa possa essere visualizzata sulla mappa, ricercata per località o vicinanza.
        </div>
    </div>

<hr />

<div class="row-fluid">
    
    <div class="span12">
        <h2>
            1. <i class="icon-search"></i> Ricerca
        </h2>
        
        <hr />
        
        <p>Inserisci un indirizzo geografico.</p>
        
        <div class="input-append">
            <input type="text" id="ricercaLuogo" class="input-large" autofocus placeholder="es.: Via Massimo, 50 Roma" />
            <button class="btn btn-success">
                <i class="icon-search"></i>
            </button>
        </div>
    </div>
    
    
    <div class="span12">
        <h2>
            2. <i class="icon-list"></i> Seleziona
        </h2>
        
        <hr />
        
        <p>Seleziona un risultato tra i seguenti:</p>
        
        <div id="quiRisultati">
            <div class="alert alert-info">
                <i class="icon-info-sign"></i>
                Ancora nessuna ricerca effettuata.
            </div>
        </div>
    </div>

        <h2>
            3. <i class="icon-check"></i> Controlla
        </h2>
        
        <hr />
        
        <p>Controlla che la posizione sulla mappa sia corretta:</p>
        
        <div class=".mappaGoogle" id="mappaGeografica" style="height: 500px; width: 100%;"></div>
        
        <hr />
        <form action="?p=attivita.localita.ok" method="POST">
            <input type="hidden" id="formattato" name="formattato" value="" />
            <button id="pulsanteOk" type="submit" class="btn btn-block btn-success btn-large disabled" disabled="disabled">
                <i class="icon-ok"></i> Accetta questa posizione
            </button>
            
        </form>
    </div>
  
</div>
</div>
