<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
caricaSelettore();
paginaModale();

controllaParametri(array('id'));

$id = $_GET['id'];
$corsoBase = CorsoBase::id($id);

paginaCorsoBase($corsoBase);

?>
<form action="?p=formazione.corsibase.direttore.ok" method="POST">
               

<input type="hidden" name="id" value="<?php echo $corsoBase->id; ?>" />

<div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-user"></i> Seleziona il direttore</h3>
        </div>
        <div class="modal-body">
          <p><strong>Chi è il direttore?</strong>
          <ul>
              <li>Punto di riferimento per gli aspiranti volontari che vogliono partecipare
                  al corso base e per i docenti;</li>
              <li>I suoi contatti verranno divulgati agli aspiranti volontari
                    interessati al corso;</li>
              <li>Generalmente è presente durante le lezioni e
                conosce i docenti.</li>
          </ul>
           <p class="text-info"><i class="icon-info-sign"></i> <strong>Nota bene</strong>: potrai anche successivamente decidere se delegare 
                al direttore l'inserimento di tutti i dettagli del corso, comprese informazioni e lezioni.</p>
           <p>&nbsp;</p>
          <p>
              <a data-selettore="true" 
                 data-input="inputDirettore" 
                 data-autosubmit="true" 
                 data-comitati="<?php echo $corsoBase->organizzatore; ?>"
                 class="btn btn-inverse btn-block btn-large">
                  Seleziona un volontario... <i class="icon-pencil"></i>
              </a>
          
        </div>
        <!-- <div class="modal-footer">
          <a href="?p=attivita" class="btn">Annulla</a>
          <button type="submit" class="btn btn-primary">
              <i class="icon-asterisk"></i> Crea attività
          </button>
        </div> -->
</div>
    
</form>
