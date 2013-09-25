<?php

/* 
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaAttivita();
caricaSelettore();

$a = new Attivita(@$_GET['id']);

if (!$a->haPosizione()) {
    redirect('attivita.localita&id=' . $a->id);
}

$del        = $me->delegazioni(APP_ATTIVITA);
$comitati   = $me->comitatiDelegazioni(APP_ATTIVITA);
$domini     = $me->dominiDelegazioni(APP_ATTIVITA);

$g = GeoPolitica::daOid($a->comitato);
$visMinima = $a->visibilitaMinima($g);

?>

<form action="?p=attivita.modifica.ok" method="POST">
<input type="hidden" name="id" value="<?php echo $a->id; ?>" />
    
<div class="row-fluid">
    
    <div class="span7">
        <h2><i class="icon-flag muted"></i> Dettagli dell'attività</h2>
    </div>
    
    <div class="btn-group pull-right">
        <button type="submit" name="azione" value="salva" class="btn btn-success btn-large">
            <i class="icon-save"></i> Salva l'attività
        </button>
        <a href="?p=attivita.turni&id=<?= $a ?>" class="btn btn-primary btn-large">
            <i class="icon-pencil"></i> Modifica turni
        </a>
    </div>
    
</div>
    <hr />
<div class="row-fluid">
    <div class="span8">
    
        <div class="alert alert-info">
            <i class="icon-info-sign"></i>
            Presta molta attenzione quando decidi <strong> quali volontari possono partecipare </strong>:</br>
            <ul>
            <li>Se selezioni <strong>Tutti i Volontari della Croce Rossa Italiana</strong> permetti a tutti gli
            iscritti su Gaia di dare disponibilità per l'attività. </li>
            <li>Se selezioni <strong>Pubblica</strong> permetti anche a chi <strong>non</strong> è Volontario
            di partecipare. </li>
            </ul>
        </div>
        
          <div class="form-horizontal">
          <div class="control-group">
            <label class="control-label" for="inputNome">Nome</label>
            <div class="controls">
              <input class="input-xlarge grassetto" value="<?php echo $a->nome; ?>" type="text" id="inputNome" name="inputNome" placeholder="Es.: Aggiungi un Posto a Tavola" required autofocus pattern=".{2,}" />
            </div>
          </div>   
              
          <div class="control-group">
            <label class="control-label" for="inputVisibilita">Quali volontari possono chiedere di partecipare?</label>
            <div class="controls">
                <select class="input-xxlarge" name="inputVisibilita">
                    <?php foreach ( $conf['att_vis'] as $num => $nom ) { 
                        if ($num < $visMinima) { continue; }?>
                        <option value="<?php echo $num; ?>"
                            <?php if ( $a->visibilita == $num ) { ?>
                                selected="selected"
                            <?php } ?>
                                >
                                    <?php echo $nom; ?>
                        </option>
                    <?php } ?>
                </select>
                <p class="text-info"><i class="icon-info-sign"></i> I volontari al di fuori di questa selezione non vedranno l'attività nel calendario.</p>
            </div>
          </div>   
          <div class="control-group">
            <label class="control-label" for="inputDescrizione">Descrizione ed informazioni per i volontari</label>
            <div class="controls">
              <textarea rows="10" class="input-xlarge conEditor" type="text" id="inputDescrizione" name="inputDescrizione"><?php echo $a->descrizione; ?></textarea>
            </div>
          </div>
          
      
       

        </div>
    

    </div>
    
    <div class="span4">
        
        <p>
            <strong>Referente</strong><br />
            <?php echo $a->referente()->nomeCompleto(); ?>
        </p>
        
        <p>
            <strong>Organizzatore</strong><br />
            <?php 
            
            echo $g->nomeCompleto(); ?>
        </p>
        
        <p>
            <strong>Area d'intervento</strong><br />
            <?php echo $a->area()->nomeCompleto(); ?>
        </p>    
        
        <p>
            <strong>Posizione geografica</strong><br />
            <?php echo $a->luogo; ?><br />
            <a href='?p=attivita.localita&id=<?= $a->id; ?>'>
                <i class='icon-pencil'></i>
                modifica la località
            </a>
        </p>
        
        
    </div>
    
    
</div>
    
</form>