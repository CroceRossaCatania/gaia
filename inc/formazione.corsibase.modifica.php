<?php

/* 
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
caricaSelettore();

controllaParametri(['id'], 'formazione.corsibase&err');
$corso = CorsoBase::id($_GET['id']);
paginaCorsoBase($corso);

if (!$corso->haPosizione()) {
    redirect('formazione.corsibase.localita&id=' . $corso->id);
}

?>

<form action="?p=formazione.corsibase.modifica.ok" method="POST">
<input type="hidden" name="id" value="<?php echo $corso->id; ?>" />
    
<div class="row-fluid">
    
    <div class="span7">
        <h2><i class="icon-flag muted"></i> Dettagli del corso</h2>
    </div>
    
    <div class="btn-group pull-right">
        <button type="submit" name="azione" value="salva" class="btn btn-success btn-large">
            <i class="icon-save"></i> Salva le informazioni
        </button>
    </div>
    
</div>
    <hr />
<div class="row-fluid">
    <div class="span8">
    
        <div class="alert alert-info">
            <i class="icon-info-sign"></i>
            Presta molta attenzione quando inserisci i <strong> dettagli del corso </strong>:</br>
            <ul>
                <li>queste informazioni sono fondamentali per gli aspiranti che vogliono frequentare
                un corso base per volontari CRI nella zona in cui il corso si svolge, fornisci loro
                tutte le indicazioni che ritieni possano essere utili;</li>
                <li>Queste informazioni saranno rese pubbliche ed accessibili a chiunque: <strong>evita</strong>
                di inserire dati personali, numeri di telefono privati o informazioni che vorresti fossero divulgate;</li>
                <li>Agli aspiranti volontari che si registrano verranno fornite in le informazioni per 
                contattare il direttore del corso in caso necessità.</li>
            </ul>

        </div>
        
          <div class="form-horizontal">
            
          <div class="control-group">
            <label class="control-label" for="inputDescrizione">Descrizione ed informazioni per gli aspiranti volontari</label>
            <div class="controls">
              <textarea rows="10" class="input-xlarge conEditor" type="text" id="inputDescrizione" name="inputDescrizione"><?php echo $corso->descrizione; ?></textarea>
            </div>
          </div>
          
      
       

        </div>
    

    </div>
    
    <div class="span4">
        
        <p>
            <strong>Direttore</strong><br />
            <?php echo $corso->direttore()->nomeCompleto(); ?>
        </p>
        
        <p>
            <strong>Organizzatore</strong><br />
            <?php 
            
            echo $corso->organizzatore()->nomeCompleto(); ?>
        </p>   
        
        <p>
            <strong>Posizione geografica</strong><br />
            <?php echo $corso->luogo; ?><br />
            <a href='?p=formazione.corsibase.localita&id=<?= $corso->id; ?>'>
                <i class='icon-pencil'></i>
                modifica la località
            </a>
        </p>
        
        
    </div>
    
    
</div>
    
</form>


