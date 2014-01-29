<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
caricaSelettore();
paginaModale();

controllaParametri(array('id'));

$attivita = $_GET['id'];
$attivita = Attivita::id($attivita);

paginaAttivita($attivita);

if(isset($_GET['g'])){ ?>
        <form action="?p=attivita.referente.ok&g" method="POST">
<?php }else{ ?>
        <form action="?p=attivita.referente.ok" method="POST">
<?php } ?>                

<input type="hidden" name="id" value="<?php echo $attivita->id; ?>" />

<div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-user"></i> Seleziona il referente</h3>
        </div>
        <div class="modal-body">
          <p><strong>Chi è il referente?</strong>
          <ul>
              <li>Punto di riferimento per i volontari che vogliono partecipare
                  all'attività;</li>
              <li>I suoi contatti verranno divulgati coi
                    volontari interessati all'attività;</li>
              <li>Generalmente è presente sul posto all'attività e/o
                conosce chi vi ci si reca.</li>
          </ul>
           <p class="text-info"><i class="icon-info-sign"></i> <strong>Nota bene</strong>: potrai anche successivamente decidere se delegare 
                al referente l'inserimento di tutti i dettagli dell'attività, compresi giorni e turni.</p>
           <p>&nbsp;</p>
          <p>
              <a data-selettore="true" 
                 data-input="inputReferente" 
                 data-autosubmit="true" 
                 data-comitati="<?php echo $attivita->comitato; ?>"
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
